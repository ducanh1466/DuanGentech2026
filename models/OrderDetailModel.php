<?php

class OrderDetailModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'tb_order_items';
    }

    public function insertOrderDetail($order_id, $product_id, $variant_id = null, $quantity, $unit_price)
    {
        // Use variant_id if provided, otherwise use product_id as variant_id (based on DB schema)
        $actual_variant_id = $variant_id ? $variant_id : $product_id;

        $sql = "INSERT INTO {$this->table} (order_id, variant_id, quantity, unit_price) 
                VALUES (:order_id, :variant_id, :quantity, :unit_price)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'order_id' => $order_id,
            'variant_id' => $actual_variant_id,
            'quantity' => $quantity,
            'unit_price' => $unit_price
        ]);
    }

    public function getDetailsByOrderId($order_id)
    {
        $sql = "SELECT od.*, p.product_name, 
                       (SELECT image_url FROM tb_product_images WHERE product_id = p.product_id AND is_primary = 1 LIMIT 1) as product_image
                FROM {$this->table} od
                LEFT JOIN tb_product_variants pv ON od.variant_id = pv.variant_id
                LEFT JOIN tb_products p ON (pv.product_id = p.product_id OR od.variant_id = p.product_id)
                WHERE od.order_id = :order_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['order_id' => $order_id]);
        return $stmt->fetchAll();
    }
}
