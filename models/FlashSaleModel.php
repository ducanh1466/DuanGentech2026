<?php
require_once 'BaseModel.php';

class FlashSaleModel extends BaseModel
{
    // Lấy tất cả chiến dịch flash sale
    public function getAllFlashSales()
    {
        $sql = "SELECT * FROM tb_flash_sales ORDER BY start_time DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy chi tiết chiến dịch
    public function getFlashSaleById($id)
    {
        $sql = "SELECT * FROM tb_flash_sales WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy chiến dịch đang hoạt động
    public function getActiveFlashSale()
    {
        $sql = "SELECT * FROM tb_flash_sales 
                WHERE status = 'active' 
                AND start_time <= NOW() 
                AND end_time >= NOW() 
                ORDER BY start_time ASC LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tạo chiến dịch mới
    public function createFlashSale($title, $start_time, $end_time, $status)
    {
        $sql = "INSERT INTO tb_flash_sales (title, start_time, end_time, status) 
                VALUES (:title, :start_time, :end_time, :status)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'title' => $title,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'status' => $status
        ]);
    }

    // Cập nhật chiến dịch
    public function updateFlashSale($id, $title, $start_time, $end_time, $status)
    {
        $sql = "UPDATE tb_flash_sales 
                SET title = :title, start_time = :start_time, end_time = :end_time, status = :status 
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'title' => $title,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'status' => $status,
            'id' => $id
        ]);
    }

    // Xóa chiến dịch
    public function deleteFlashSale($id)
    {
        $sql = "DELETE FROM tb_flash_sales WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    // Lấy các sản phẩm thuộc chiến dịch (bao gồm thông tin sản phẩm)
    public function getFlashSaleItems($flash_sale_id)
    {
        $sql = "SELECT fi.*, p.product_name,
                       (SELECT REPLACE(image_url, '/uploads/products/', '/assets/uploads/products/') FROM tb_product_images WHERE product_id = p.product_id AND is_primary = 1 LIMIT 1) as image,
                       (SELECT MIN(price) FROM tb_product_variants WHERE product_id = p.product_id) as price
                FROM tb_flash_sale_items fi 
                JOIN tb_products p ON fi.product_id = p.product_id 
                WHERE fi.flash_sale_id = :flash_sale_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['flash_sale_id' => $flash_sale_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm hoặc cập nhật sản phẩm vào chiến dịch
    public function saveFlashSaleItem($flash_sale_id, $product_id, $flash_price, $quantity)
    {
        // Kiểm tra xem sản phẩm đã có trong flash sale này chưa
        $sqlCheck = "SELECT id FROM tb_flash_sale_items WHERE flash_sale_id = :flash_sale_id AND product_id = :product_id";
        $stmtCheck = $this->pdo->prepare($sqlCheck);
        $stmtCheck->execute(['flash_sale_id' => $flash_sale_id, 'product_id' => $product_id]);
        $existing = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            // Cập nhật
            $sql = "UPDATE tb_flash_sale_items 
                    SET flash_price = :flash_price, quantity = :quantity 
                    WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                'flash_price' => $flash_price,
                'quantity' => $quantity,
                'id' => $existing['id']
            ]);
        } else {
            // Thêm mới
            $sql = "INSERT INTO tb_flash_sale_items (flash_sale_id, product_id, flash_price, quantity, sold) 
                    VALUES (:flash_sale_id, :product_id, :flash_price, :quantity, 0)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                'flash_sale_id' => $flash_sale_id,
                'product_id' => $product_id,
                'flash_price' => $flash_price,
                'quantity' => $quantity
            ]);
        }
    }

    // Xóa sản phẩm khỏi chiến dịch
    public function deleteFlashSaleItem($id)
    {
        $sql = "DELETE FROM tb_flash_sale_items WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    // Tăng số lượng đã bán của sản phẩm trong chiến dịch đang hoạt động
    public function incrementFlashSaleSold($product_id, $quantityToBuy)
    {
        // Chỉ cập nhật nếu thuộc chiến dịch đang hoạt động
        $sql = "UPDATE tb_flash_sale_items fsi
                JOIN tb_flash_sales fs ON fsi.flash_sale_id = fs.id
                SET fsi.sold = fsi.sold + :qty
                WHERE fsi.product_id = :product_id
                AND fs.status = 'active' 
                AND fs.start_time <= NOW() 
                AND fs.end_time >= NOW()";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'qty' => $quantityToBuy,
            'product_id' => $product_id
        ]);
    }
}
