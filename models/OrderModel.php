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

    // Phân trang đơn hàng
    public function getOrdersPaginated($limit = 10, $offset = 0, $keyword = '')
    {
        return $this->fetchWithPagination(
            "SELECT o.*, u.full_name as user_full_name FROM {$this->table} o LEFT JOIN tb_users u ON o.user_id = u.user_id",
            [],
            ['o.order_id', 'u.full_name', 'o.recipient_phone'],
            $keyword,
            "o.order_id DESC",
            $limit,
            $offset
        );
    }

    public function countTotalOrdersFiltered($keyword = '')
    {
        return $this->countTotalFiltered(
            "SELECT COUNT(*) as total FROM {$this->table} o LEFT JOIN tb_users u ON o.user_id = u.user_id",
            [],
            ['o.order_id', 'u.full_name', 'o.recipient_phone'],
            $keyword
        );
    }

    // Lấy chi tiết thông tin chung của 1 đơn hàng theo ID mã đơn
    public function getOrderById($id)
    {
        $sql = "SELECT o.*, u.full_name as user_full_name, u.email as user_email
                FROM {$this->table} o
                LEFT JOIN tb_users u ON o.user_id = u.user_id
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

    // Tạo mới 1 đơn hàng vào CSDL (Khi khách thực hiện thao tác đặt hàng/thanh toán)
    public function insertOrder($user_id, $discount_id = null, $total_amount, $status = 'pending', $recipient_name, $recipient_phone, $shipping_address, $note = null, $payment_method = 'cod', $payment_status = 'unpaid')
    {
        $sql = "INSERT INTO {$this->table} (user_id, discount_id, total_amount, status, recipient_name, recipient_phone, shipping_address, note, payment_method, payment_status, order_date) 
                VALUES (:user_id, :discount_id, :total_amount, :status, :recipient_name, :recipient_phone, :shipping_address, :note, :payment_method, :payment_status, NOW())";
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
            'payment_status' => $payment_status
        ]);
        return $this->pdo->lastInsertId();
    }

    // Cập nhật trạng thái đơn hàng (VD: Từ Chờ xử lý -> Đang giao hàng)
    public function updateOrderStatus($id, $status)
    {
        $sql = "UPDATE {$this->table} SET status = :status WHERE order_id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'status' => $status,
            'id' => $id
        ]);
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
}
