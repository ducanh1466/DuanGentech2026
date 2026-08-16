<?php

class DiscountModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'tb_discounts';
    }

    public function getAllDiscounts($keyword = '', $limit = 0, $offset = 0)
    {
        $sql = "SELECT * FROM {$this->table}";
        $params = [];
        
        return $this->fetchWithPagination(
            $sql,
            $params,
            ['code'],
            $keyword,
            "discount_id DESC",
            $limit,
            $offset
        );
    }

    public function countTotalDiscountsFiltered($keyword = '')
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $params = [];

        return $this->countTotalFiltered(
            $sql,
            $params,
            ['code'],
            $keyword
        );
    }

    public function getDiscountById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE discount_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getDiscountByCode($code)
    {
        $sql = "SELECT * FROM {$this->table} WHERE code = :code";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['code' => $code]);
        return $stmt->fetch();
    }

    // Lấy danh sách các mã giảm giá đang public (active) để hiển thị trong giỏ hàng
    public function getActiveDiscounts()
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE status = 'active' 
                AND (quantity IS NULL OR quantity > 0)
                AND (start_date IS NULL OR start_date <= NOW())
                AND (end_date IS NULL OR end_date >= NOW())
                ORDER BY minimum_order_value ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function insertDiscount($code, $discount_type, $discount_value, $max_discount, $minimum_order_value, $quantity, $max_usage_per_user, $start_date, $end_date, $status)
    {
        $sql = "INSERT INTO {$this->table} (code, discount_type, discount_value, max_discount, minimum_order_value, quantity, max_usage_per_user, start_date, end_date, status) 
                VALUES (:code, :discount_type, :discount_value, :max_discount, :minimum_order_value, :quantity, :max_usage_per_user, :start_date, :end_date, :status)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'code' => $code,
            'discount_type' => $discount_type,
            'discount_value' => $discount_value,
            'max_discount' => $max_discount ?: null,
            'minimum_order_value' => $minimum_order_value ?: 0,
            'quantity' => $quantity !== '' ? $quantity : null,
            'max_usage_per_user' => $max_usage_per_user !== '' ? $max_usage_per_user : null,
            'start_date' => $start_date ?: null,
            'end_date' => $end_date ?: null,
            'status' => $status
        ]);
    }

    public function updateDiscount($id, $code, $discount_type, $discount_value, $max_discount, $minimum_order_value, $quantity, $max_usage_per_user, $start_date, $end_date, $status)
    {
        $sql = "UPDATE {$this->table} 
                SET code = :code, discount_type = :discount_type, discount_value = :discount_value, 
                    max_discount = :max_discount, minimum_order_value = :minimum_order_value, 
                    quantity = :quantity, max_usage_per_user = :max_usage_per_user, 
                    start_date = :start_date, end_date = :end_date, status = :status
                WHERE discount_id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'code' => $code,
            'discount_type' => $discount_type,
            'discount_value' => $discount_value,
            'max_discount' => $max_discount ?: null,
            'minimum_order_value' => $minimum_order_value ?: 0,
            'quantity' => $quantity !== '' ? $quantity : null,
            'max_usage_per_user' => $max_usage_per_user !== '' ? $max_usage_per_user : null,
            'start_date' => $start_date ?: null,
            'end_date' => $end_date ?: null,
            'status' => $status
        ]);
    }

    public function deleteDiscount($id)
    {
        // Xóa log usage trước
        $sqlUsage = "DELETE FROM tb_discount_usage WHERE discount_id = :id";
        $stmtUsage = $this->pdo->prepare($sqlUsage);
        $stmtUsage->execute(['id' => $id]);

        $sql = "DELETE FROM {$this->table} WHERE discount_id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    // Kiểm tra xem User đã dùng mã này bao nhiêu lần
    public function countUserUsage($discount_id, $user_id)
    {
        $sql = "SELECT COUNT(*) as total FROM tb_discount_usage WHERE discount_id = :discount_id AND user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['discount_id' => $discount_id, 'user_id' => $user_id]);
        return $stmt->fetch()['total'] ?? 0;
    }

    // Ghi lại việc sử dụng mã (trừ quantity và thêm vào log)
    public function recordUsage($discount_id, $user_id, $order_id)
    {
        // 1. Thêm log
        $sql = "INSERT INTO tb_discount_usage (discount_id, user_id, order_id, used_at) VALUES (:discount_id, :user_id, :order_id, NOW())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'discount_id' => $discount_id,
            'user_id' => $user_id,
            'order_id' => $order_id
        ]);

        // 2. Trừ quantity (nếu quantity khác null)
        $sqlReduce = "UPDATE {$this->table} SET quantity = quantity - 1 WHERE discount_id = :discount_id AND quantity IS NOT NULL AND quantity > 0";
        $stmtReduce = $this->pdo->prepare($sqlReduce);
        $stmtReduce->execute(['discount_id' => $discount_id]);
    }

    // Validate một mã giảm giá và trả về mảng kết quả
    public function validateDiscount($code, $cartTotal, $user_id)
    {
        $discount = $this->getDiscountByCode($code);
        
        if (!$discount) {
            return ['status' => false, 'message' => 'Mã giảm giá không tồn tại!'];
        }

        if ($discount['status'] !== 'active') {
            return ['status' => false, 'message' => 'Mã giảm giá đang bị khóa!'];
        }

        // Kiểm tra hạn sử dụng
        $now = date('Y-m-d H:i:s');
        if ($discount['start_date'] && $discount['start_date'] > $now) {
            return ['status' => false, 'message' => 'Mã giảm giá chưa đến thời gian hiệu lực!'];
        }
        if ($discount['end_date'] && $discount['end_date'] < $now) {
            return ['status' => false, 'message' => 'Mã giảm giá đã hết hạn!'];
        }

        // Kiểm tra số lượng
        if ($discount['quantity'] !== null && $discount['quantity'] <= 0) {
            return ['status' => false, 'message' => 'Mã giảm giá đã hết lượt sử dụng!'];
        }

        // Kiểm tra điều kiện đơn hàng tối thiểu
        if ($cartTotal < $discount['minimum_order_value']) {
            return ['status' => false, 'message' => 'Đơn hàng chưa đạt giá trị tối thiểu ' . number_format($discount['minimum_order_value'], 0, ',', '.') . 'đ để áp dụng mã này!'];
        }

        // Kiểm tra số lần sử dụng tối đa của User
        if ($discount['max_usage_per_user'] !== null) {
            $userUsageCount = $this->countUserUsage($discount['discount_id'], $user_id);
            if ($userUsageCount >= $discount['max_usage_per_user']) {
                return ['status' => false, 'message' => 'Bạn đã sử dụng hết lượt tối đa cho mã này!'];
            }
        }

        // Tính số tiền được giảm
        $discountAmount = 0;
        if ($discount['discount_type'] == 'fixed') {
            $discountAmount = $discount['discount_value'];
        } elseif ($discount['discount_type'] == 'percent') {
            $discountAmount = ($cartTotal * $discount['discount_value']) / 100;
            if ($discount['max_discount'] > 0 && $discountAmount > $discount['max_discount']) {
                $discountAmount = $discount['max_discount'];
            }
        }

        // Không giảm quá giá trị đơn hàng
        if ($discountAmount > $cartTotal) {
            $discountAmount = $cartTotal;
        }

        return [
            'status' => true,
            'discount' => $discount,
            'discount_amount' => $discountAmount,
            'new_total' => $cartTotal - $discountAmount
        ];
    }
}
