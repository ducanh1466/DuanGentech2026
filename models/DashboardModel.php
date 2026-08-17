<?php

class DashboardModel extends BaseModel
{
    public function getTotalOrders($startDate = null, $endDate = null)
    {
        try {
            $sql = "SELECT COUNT(*) FROM tb_orders WHERE 1=1";
            $params = [];
            if ($startDate && $endDate) {
                $sql .= " AND order_date >= :start AND order_date <= :end";
                $params['start'] = $startDate . ' 00:00:00';
                $params['end'] = $endDate . ' 23:59:59';
            }
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            return 0; // Return 0 if table doesn't exist yet
        }
    }

    public function getTotalRevenue($startDate = null, $endDate = null)
    {
        try {
            $sql = "SELECT SUM(total_amount) FROM tb_orders WHERE status = 'completed'";
            $params = [];
            if ($startDate && $endDate) {
                $sql .= " AND order_date >= :start AND order_date <= :end";
                $params['start'] = $startDate . ' 00:00:00';
                $params['end'] = $endDate . ' 23:59:59';
            }
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return (float) $stmt->fetchColumn();
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function getTotalProducts($startDate = null, $endDate = null)
    {
        try {
            $sql = "SELECT COUNT(*) FROM tb_products WHERE 1=1";
            $params = [];
            if ($startDate && $endDate) {
                $sql .= " AND created_at >= :start AND created_at <= :end";
                $params['start'] = $startDate . ' 00:00:00';
                $params['end'] = $endDate . ' 23:59:59';
            }
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function getTotalUsers($startDate = null, $endDate = null)
    {
        try {
            $sql = "SELECT COUNT(*) FROM tb_users WHERE 1=1";
            $params = [];
            if ($startDate && $endDate) {
                $sql .= " AND created_at >= :start AND created_at <= :end";
                $params['start'] = $startDate . ' 00:00:00';
                $params['end'] = $endDate . ' 23:59:59';
            }
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function getRecentOrders($limit = 5)
    {
        try {
            $sql = "SELECT order_id, recipient_name, total_amount, status 
                    FROM tb_orders 
                    ORDER BY order_date DESC 
                    LIMIT :limit";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return []; // Return empty array if table doesn't exist
        }
    }

    public function getRevenueByMonths($year)
    {
        try {
            // Khởi tạo mảng doanh thu 12 tháng bằng 0
            $revenue = array_fill(0, 12, 0);

            // Truy vấn lấy tổng doanh thu theo từng tháng trong năm (chỉ lấy đơn hàng đã hoàn thành)
            $sql = "SELECT MONTH(order_date) as month, SUM(total_amount) as total 
                    FROM tb_orders 
                    WHERE YEAR(order_date) = :year AND status = 'completed'
                    GROUP BY MONTH(order_date)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':year', $year, PDO::PARAM_INT);
            $stmt->execute();
            
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($results as $row) {
                // index từ 0 đến 11 tương ứng với tháng 1 đến 12
                $revenue[(int)$row['month'] - 1] = (float)$row['total'];
            }

            return ['revenue' => $revenue];
        } catch (PDOException $e) {
            return ['revenue' => array_fill(0, 12, 0)];
        }
    }

    public function getTopSellingProducts($limit = 5, $startDate = null, $endDate = null)
    {
        try {
            $sql = "SELECT p.product_name, p.product_id, SUM(od.quantity) as total_sold,
                           (SELECT REPLACE(image_url, '/uploads/products/', '/assets/uploads/products/') FROM tb_product_images WHERE product_id = p.product_id AND is_primary = 1 LIMIT 1) as image
                    FROM tb_order_items od
                    JOIN tb_orders o ON o.order_id = od.order_id
                    LEFT JOIN tb_product_variants pv ON od.variant_id = pv.variant_id
                    JOIN tb_products p ON (pv.product_id = p.product_id OR od.variant_id = p.product_id)
                    WHERE o.status = 'completed'";
            $params = [];
            
            if ($startDate && $endDate) {
                $sql .= " AND o.order_date >= :start AND o.order_date <= :end";
                $params['start'] = $startDate . ' 00:00:00';
                $params['end'] = $endDate . ' 23:59:59';
            }
            
            $sql .= " GROUP BY p.product_id ORDER BY total_sold DESC LIMIT :limit";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            foreach ($params as $key => $val) {
                $stmt->bindValue(':' . $key, $val);
            }
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getPendingAlerts()
    {
        $alerts = [
            'pending_orders' => 0,
            'pending_contacts' => 0
        ];

        try {
            // Count pending orders
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM tb_orders WHERE status = 'pending'");
            $alerts['pending_orders'] = (int) $stmt->fetchColumn();

            // Count pending contacts
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM tb_contacts WHERE status = 'pending'");
            $alerts['pending_contacts'] = (int) $stmt->fetchColumn();
            
        } catch (PDOException $e) {
            // ignore
        }
        
        return $alerts;
    }

    public function getLowStockProducts($limit = 5, $threshold = 10)
    {
        try {
            $sql = "SELECT p.product_name, pv.variant_id, pv.stock_quantity as stock,
                           (SELECT GROUP_CONCAT(val.attribute_value SEPARATOR ' - ') 
                            FROM tb_variant_attributes va 
                            JOIN tb_attribute_values val ON va.attribute_value_id = val.attribute_value_id 
                            WHERE va.variant_id = pv.variant_id) as attributes
                    FROM tb_product_variants pv
                    JOIN tb_products p ON p.product_id = pv.product_id
                    WHERE pv.stock_quantity <= :threshold
                    ORDER BY pv.stock_quantity ASC
                    LIMIT :limit";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':threshold', (int)$threshold, PDO::PARAM_INT);
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getOrdersByStatus()
    {
        try {
            $sql = "SELECT status, COUNT(*) as count 
                    FROM tb_orders 
                    GROUP BY status";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getTopVIPCustomers($limit = 5, $startDate = null, $endDate = null)
    {
        try {
            $sql = "SELECT u.user_id, u.full_name, u.email, 
                           COUNT(o.order_id) as total_orders, 
                           SUM(o.total_amount) as total_spent
                    FROM tb_orders o
                    JOIN tb_users u ON o.user_id = u.user_id
                    WHERE o.status = 'completed'";
            $params = [];
            
            if ($startDate && $endDate) {
                $sql .= " AND o.order_date >= :start AND o.order_date <= :end";
                $params['start'] = $startDate . ' 00:00:00';
                $params['end'] = $endDate . ' 23:59:59';
            }
            
            $sql .= " GROUP BY u.user_id ORDER BY total_spent DESC LIMIT :limit";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            foreach ($params as $key => $val) {
                $stmt->bindValue(':' . $key, $val);
            }
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getSalesByCategory($startDate = null, $endDate = null)
    {
        try {
            $sql = "SELECT c.category_name, SUM(od.unit_price * od.quantity) as total_revenue
                    FROM tb_order_items od
                    JOIN tb_orders o ON od.order_id = o.order_id
                    LEFT JOIN tb_product_variants pv ON od.variant_id = pv.variant_id
                    JOIN tb_products p ON (pv.product_id = p.product_id OR od.variant_id = p.product_id)
                    JOIN tb_categories c ON p.category_id = c.category_id
                    WHERE o.status = 'completed'";
            $params = [];
            
            if ($startDate && $endDate) {
                $sql .= " AND o.order_date >= :start AND o.order_date <= :end";
                $params['start'] = $startDate . ' 00:00:00';
                $params['end'] = $endDate . ' 23:59:59';
            }
            
            $sql .= " GROUP BY c.category_id ORDER BY total_revenue DESC";
            
            $stmt = $this->pdo->prepare($sql);
            foreach ($params as $key => $val) {
                $stmt->bindValue(':' . $key, $val);
            }
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}
