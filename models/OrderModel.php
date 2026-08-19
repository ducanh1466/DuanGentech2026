<?php

class OrderModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'tb_orders';
    }

    // Lấy danh sách tất cả đơn hàng kèm tên người đặt (Dùng cho trang Quản trị)
    public function getAllOrders()
    {
        $sql = "SELECT o.*, u.full_name as user_full_name 
                FROM {$this->table} o
                LEFT JOIN tb_users u ON o.user_id = u.user_id
                ORDER BY o.order_id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getOrdersPaginated($limit = 10, $offset = 0, $keyword = '', $status = '')
    {
        $sql = "SELECT o.*, u.full_name as user_full_name FROM {$this->table} o LEFT JOIN tb_users u ON o.user_id = u.user_id";
        $params = [];
        if ($status !== '') {
            $sql .= " WHERE o.status = :status";
            $params['status'] = $status;
        }

        return $this->fetchWithPagination(
            $sql,
            $params,
            ['o.order_id', 'u.full_name', 'o.recipient_phone'],
            $keyword,
            "o.order_id DESC",
            $limit,
            $offset
        );
    }

    public function countTotalOrdersFiltered($keyword = '', $status = '')
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} o LEFT JOIN tb_users u ON o.user_id = u.user_id";
        $params = [];
        if ($status !== '') {
            $sql .= " WHERE o.status = :status";
            $params['status'] = $status;
        }

        return $this->countTotalFiltered(
            $sql,
            $params,
            ['o.order_id', 'u.full_name', 'o.recipient_phone'],
            $keyword
        );
    }

    public function getOrderById($id)
    {
        $sql = "SELECT o.*, u.full_name as user_full_name, u.email as user_email,
                       d.code as discount_code, d.discount_type, d.discount_value, d.max_discount
                FROM {$this->table} o
                LEFT JOIN tb_users u ON o.user_id = u.user_id
                LEFT JOIN tb_discounts d ON o.discount_id = d.discount_id
                WHERE o.order_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // Lấy lịch sử mua hàng của 1 khách hàng cụ thể dựa vào ID người dùng
    public function getOrdersByUserId($user_id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE user_id = :user_id ORDER BY order_id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll();
    }

    // Lấy lịch sử mua hàng lọc theo trạng thái
    public function getOrdersByUserIdAndStatus($user_id, $status = '')
    {
        if (empty($status) || $status === 'all') {
            return $this->getOrdersByUserId($user_id);
        }
        
        if ($status === 'returned_all') {
            $sql = "SELECT * FROM {$this->table} WHERE user_id = :user_id AND status IN ('return_requested', 'returned') ORDER BY order_id DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['user_id' => $user_id]);
            return $stmt->fetchAll();
        }

        $sql = "SELECT * FROM {$this->table} WHERE user_id = :user_id AND status = :status ORDER BY order_id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'user_id' => $user_id,
            'status' => $status
        ]);
        return $stmt->fetchAll();
    }

    // Tạo mới 1 đơn hàng vào CSDL (Khi khách thực hiện thao tác đặt hàng/thanh toán)
    public function insertOrder($user_id, $discount_id = null, $total_amount, $status = 'pending', $recipient_name, $recipient_phone, $shipping_address, $note = null, $payment_method = 'cod', $payment_status = 'unpaid', $shipping_fee = 0)
    {
        $sql = "INSERT INTO {$this->table} (user_id, discount_id, total_amount, status, recipient_name, recipient_phone, shipping_address, note, payment_method, payment_status, order_date, shipping_fee) 
                VALUES (:user_id, :discount_id, :total_amount, :status, :recipient_name, :recipient_phone, :shipping_address, :note, :payment_method, :payment_status, NOW(), :shipping_fee)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'user_id' => $user_id,
            'discount_id' => $discount_id,
            'total_amount' => $total_amount,
            'status' => $status,
            'recipient_name' => $recipient_name,
            'recipient_phone' => $recipient_phone,
            'shipping_address' => $shipping_address,
            'note' => $note,
            'payment_method' => $payment_method,
            'payment_status' => $payment_status,
            'shipping_fee' => $shipping_fee
        ]);
        return $this->pdo->lastInsertId();
    }

    // Cập nhật trạng thái đơn hàng (kèm lý do hủy/trả hàng và ảnh minh chứng nếu có)
    public function updateOrderStatus($id, $status, $cancel_reason = null, $cancel_images = null)
    {
        $sql = "UPDATE {$this->table} SET status = :status";
        $params = ['status' => $status, 'id' => $id];
        
        if ($cancel_reason !== null) {
            $sql .= ", cancel_reason = :cancel_reason";
            $params['cancel_reason'] = $cancel_reason;
        }
        
        if ($cancel_images !== null) {
            $sql .= ", cancel_images = :cancel_images";
            $params['cancel_images'] = $cancel_images;
        }
        
        $sql .= " WHERE order_id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    // Rollback tồn kho và mã giảm giá khi đơn hàng bị Hủy hoặc Hoàn trả
    public function rollbackOrderInventoryAndDiscount($order_id)
    {
        require_once PATH_MODEL . 'OrderDetailModel.php';
        require_once PATH_MODEL . 'ProductModel.php';
        require_once PATH_MODEL . 'DiscountModel.php';

        $orderDetailModel = new OrderDetailModel();
        $orderDetailModel->pdo = $this->pdo;

        $productModel = new ProductModel();
        $productModel->pdo = $this->pdo;

        $discountModel = new DiscountModel();
        $discountModel->pdo = $this->pdo;

        // Restore stock
        $details = $orderDetailModel->getDetailsByOrderId($order_id);
        foreach ($details as $item) {
            $productModel->restoreVariantStock($item['variant_id'], $item['quantity']);
            $productModel->restoreProductStock($item['product_id'], $item['quantity']);
        }

        // Revert discount usage
        $discountModel->revertUsage($order_id);
    }

    // Đếm tổng số lượng tất cả các đơn hàng (Dùng cho thống kê Dashboard)
    public function countTotalOrders()
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetch()['total'] ?? 0;
    }

    // Tính tổng doanh thu (Chỉ cộng tổng tiền của những đơn hàng đã 'completed' - hoàn thành)
    public function getTotalRevenue()
    {
        $sql = "SELECT SUM(total_amount) as total FROM {$this->table} WHERE status = 'completed'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetch()['total'] ?? 0;
    }

    // Lấy danh sách các đơn hàng gần đây nhất (Để hiển thị ở màn hình chính của Dashboard)
    public function getRecentOrders($limit = 5)
    {
        $sql = "SELECT o.*, u.full_name as user_full_name 
                FROM {$this->table} o
                LEFT JOIN tb_users u ON o.user_id = u.user_id
                ORDER BY o.order_id DESC LIMIT :limit";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Lấy thống kê doanh thu và số đơn hàng theo từng tháng trong 1 năm cụ thể (Để vẽ Biểu đồ doanh thu)
    public function getMonthlyRevenue($year)
    {
        $sql = "SELECT MONTH(order_date) as month, SUM(total_amount) as revenue, COUNT(order_id) as orders
                FROM {$this->table} 
                WHERE YEAR(order_date) = :year AND status = 'completed'
                GROUP BY MONTH(order_date)
                ORDER BY MONTH(order_date)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['year' => $year]);
        return $stmt->fetchAll();
    }

    // Lấy danh sách các năm có phát sinh giao dịch/đơn hàng (Dùng để làm bộ lọc chọn năm xem biểu đồ)
    public function getAvailableYears()
    {
        $sql = "SELECT DISTINCT YEAR(order_date) as year FROM {$this->table} ORDER BY year DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $years = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Ensure current year is always in the list
        $currentYear = (string) date('Y');
        if (!in_array($currentYear, $years)) {
            $years[] = $currentYear;
            rsort($years);
        }
        return $years;
    }

    // Cập nhật trạng thái thanh toán của đơn hàng
    public function updatePaymentStatus($orderId, $status)
    {
        $sql = "UPDATE {$this->table} SET payment_status = :status WHERE order_id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'status' => $status,
            'id' => $orderId
        ]);
    }
}
