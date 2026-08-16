<?php

class ReviewModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'tb_reviews';
    }

    // Lấy danh sách đánh giá của 1 sản phẩm
    public function getReviewsByProductId($product_id)
    {
        $sql = "SELECT r.*, u.full_name 
                FROM {$this->table} r
                JOIN tb_orders o ON r.order_id = o.order_id
                JOIN tb_users u ON o.user_id = u.user_id
                WHERE r.product_id = :product_id
                ORDER BY r.review_date DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['product_id' => $product_id]);
        return $stmt->fetchAll();
    }

    // Lấy điểm trung bình và tổng số đánh giá
    public function getAverageRating($product_id)
    {
        $sql = "SELECT AVG(rating) as avg_rating, COUNT(*) as total_reviews 
                FROM {$this->table} 
                WHERE product_id = :product_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['product_id' => $product_id]);
        return $stmt->fetch();
    }

    // Kiểm tra xem user có quyền đánh giá sản phẩm này không
    // Điều kiện: Có mua (order completed) và chưa từng đánh giá đơn hàng đó
    public function checkEligibilityToReview($user_id, $product_id)
    {
        // 1. Tìm order_id mà user đã mua sản phẩm này và đã giao thành công (completed)
        // và order đó chưa có review nào cho sản phẩm này của user này.
        $sql = "SELECT oi.order_id 
                FROM tb_order_items oi
                JOIN tb_orders o ON oi.order_id = o.order_id
                JOIN tb_product_variants pv ON oi.variant_id = pv.variant_id
                WHERE o.user_id = :user_id 
                  AND pv.product_id = :product_id 
                  AND o.status = 'completed'
                  AND NOT EXISTS (
                      SELECT 1 FROM {$this->table} r 
                      WHERE r.order_id = o.order_id 
                        AND r.product_id = :product_id 
                  )
                LIMIT 1";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'user_id' => $user_id,
            'product_id' => $product_id
        ]);
        
        $result = $stmt->fetch();
        return $result ? $result['order_id'] : false;
    }

    // Thêm đánh giá mới
    public function insertReview($order_id, $product_id, $rating, $content)
    {
        $sql = "INSERT INTO {$this->table} (order_id, product_id, rating, content, review_date) 
                VALUES (:order_id, :product_id, :rating, :content, NOW())";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'order_id' => $order_id,
            'product_id' => $product_id,
            'rating' => $rating,
            'content' => $content
        ]);
    }
}
