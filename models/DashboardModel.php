<?php

class DashboardModel extends BaseModel
{
    public function getTotalOrders()
    {
        try {
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM tb_orders");
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            return 0; // Return 0 if table doesn't exist yet
        }
    }

    public function getTotalRevenue()
    {
        try {
            $stmt = $this->pdo->query("SELECT SUM(total_amount) FROM tb_orders WHERE status = 'completed'");
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function getTotalProducts()
    {
        try {
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM tb_products");
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function getTotalUsers()
    {
        try {
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM tb_users");
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
                    ORDER BY created_at DESC 
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
            $sql = "SELECT MONTH(created_at) as month, SUM(total_amount) as total 
                    FROM tb_orders 
                    WHERE YEAR(created_at) = :year AND status = 'completed'
                    GROUP BY MONTH(created_at)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':year', $year, PDO::PARAM_INT);
            $stmt->execute();
            
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($results as $row) {
                // index từ 0 đến 11 tương ứng với tháng 1 đến 12
                $revenue[(int)$row['month'] - 1] = (int)$row['total'];
            }

            return ['revenue' => $revenue];
        } catch (PDOException $e) {
            return ['revenue' => array_fill(0, 12, 0)];
        }
    }
}
