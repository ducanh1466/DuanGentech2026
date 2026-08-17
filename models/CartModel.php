<?php
require_once 'BaseModel.php';

class CartModel extends BaseModel
{
    // Lấy ID giỏ hàng của user hiện tại, nếu chưa có thì tạo mới
    public function getOrCreateCartId($userId)
    {
        // Kiểm tra xem user đã có giỏ hàng chưa
        $sql = "SELECT cart_id FROM tb_carts WHERE user_id = :user_id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        $cart = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cart) {
            return $cart['cart_id'];
        }

        // Nếu chưa có, tạo giỏ hàng mới
        $sqlInsert = "INSERT INTO tb_carts (user_id, created_at, updated_at) VALUES (:user_id, NOW(), NOW())";
        $stmtInsert = $this->pdo->prepare($sqlInsert);
        $stmtInsert->execute(['user_id' => $userId]);
        
        return $this->pdo->lastInsertId();
    }

    // Lấy chi tiết các sản phẩm trong giỏ hàng
    public function getCartItems($cartId)
    {
        $sql = "
            SELECT 
                ci.cart_item_id,
                ci.quantity,
                v.variant_id,
                v.variant_name,
                v.price as original_price,
                v.stock_quantity,
                p.product_id,
                p.product_name,
                pi.image_url,
                fsi.flash_price,
                fs.end_time as flash_end_time,
                fsi.quantity as flash_limit,
                fsi.sold as flash_sold
            FROM tb_cart_items ci
            JOIN tb_product_variants v ON ci.variant_id = v.variant_id
            JOIN tb_products p ON v.product_id = p.product_id
            LEFT JOIN (
                SELECT product_id, REPLACE(image_url, '/uploads/products/', '/assets/uploads/products/') as image_url 
                FROM tb_product_images 
                WHERE is_primary = 1
            ) pi ON p.product_id = pi.product_id
            LEFT JOIN tb_flash_sale_items fsi ON p.product_id = fsi.product_id
            LEFT JOIN tb_flash_sales fs ON fsi.flash_sale_id = fs.id AND fs.status = 'active' AND fs.start_time <= NOW() AND fs.end_time >= NOW()
            WHERE ci.cart_id = :cart_id
        ";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['cart_id' => $cartId]);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Process prices based on flash sale
        foreach ($items as &$item) {
            if (!empty($item['flash_end_time']) && $item['flash_sold'] < $item['flash_limit']) {
                $item['price'] = $item['flash_price'];
                $item['is_flash_sale'] = true;
            } else {
                $item['price'] = $item['original_price'];
                $item['is_flash_sale'] = false;
            }
        }
        
        return $items;
    }

    // Thêm sản phẩm vào giỏ
    public function addItem($cartId, $variantId, $quantity)
    {
        // Kiểm tra xem sản phẩm đã có trong giỏ chưa
        $sqlCheck = "SELECT cart_item_id, quantity FROM tb_cart_items WHERE cart_id = :cart_id AND variant_id = :variant_id";
        $stmtCheck = $this->pdo->prepare($sqlCheck);
        $stmtCheck->execute([
            'cart_id' => $cartId,
            'variant_id' => $variantId
        ]);
        
        $existingItem = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        if ($existingItem) {
            // Nếu có rồi, cập nhật số lượng
            $newQuantity = $existingItem['quantity'] + $quantity;
            $sqlUpdate = "UPDATE tb_cart_items SET quantity = :quantity WHERE cart_item_id = :cart_item_id";
            $stmtUpdate = $this->pdo->prepare($sqlUpdate);
            $stmtUpdate->execute([
                'quantity' => $newQuantity,
                'cart_item_id' => $existingItem['cart_item_id']
            ]);
            return $existingItem['cart_item_id'];
        } else {
            // Nếu chưa có, thêm mới
            $sqlInsert = "INSERT INTO tb_cart_items (cart_id, variant_id, quantity) VALUES (:cart_id, :variant_id, :quantity)";
            $stmtInsert = $this->pdo->prepare($sqlInsert);
            $stmtInsert->execute([
                'cart_id' => $cartId,
                'variant_id' => $variantId,
                'quantity' => $quantity
            ]);
            return $this->pdo->lastInsertId();
        }
    }

    // Cập nhật số lượng sản phẩm trong giỏ
    public function updateItemQuantity($cartItemId, $quantity)
    {
        $sql = "UPDATE tb_cart_items SET quantity = :quantity WHERE cart_item_id = :cart_item_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'quantity' => $quantity,
            'cart_item_id' => $cartItemId
        ]);
    }

    // Xóa một sản phẩm khỏi giỏ
    public function removeItem($cartItemId)
    {
        $sql = "DELETE FROM tb_cart_items WHERE cart_item_id = :cart_item_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['cart_item_id' => $cartItemId]);
    }

    // Xóa toàn bộ sản phẩm trong giỏ (Dùng sau khi đặt hàng thành công)
    public function clearCartItems($cartId)
    {
        $sql = "DELETE FROM tb_cart_items WHERE cart_id = :cart_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['cart_id' => $cartId]);
    }
}
