<?php

class ProductModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'tb_products';
    }

    // Lấy toàn bộ danh sách sản phẩm (Dùng nhiều trong trang quản trị Admin)
    // Bao gồm: tên danh mục, tên thương hiệu, 1 ảnh đại diện và mức giá rẻ nhất trong các biến thể
    public function getAllProducts($keyword = '', $limit = 0, $offset = 0, $status = '', $category_id = null)
    {
        // Get products with their primary image and minimum variant price
        $baseSql = "SELECT p.*, c.category_name, b.brand_name,
                   (SELECT REPLACE(REPLACE(image_url, '/uploads/products/', '/assets/uploads/products/'), '/assets/assets/', '/assets/') FROM tb_product_images WHERE product_id = p.product_id AND is_primary = 1 LIMIT 1) as image,
                   (SELECT MIN(price) FROM tb_product_variants WHERE product_id = p.product_id) as price,
                   (SELECT variant_id FROM tb_product_variants WHERE product_id = p.product_id ORDER BY price ASC LIMIT 1) as default_variant_id
            FROM {$this->table} p
            LEFT JOIN tb_categories c ON p.category_id = c.category_id
            LEFT JOIN tb_brands b ON p.brand_id = b.brand_id";
        
        $params = [];
        $whereAdded = false;

        if ($status !== '') {
            if ($status === '1' || $status === 'active') {
                $baseSql .= " WHERE (p.status = 'active' OR p.status = '1')";
            } elseif ($status === '0' || $status === 'inactive') {
                $baseSql .= " WHERE (p.status = 'inactive' OR p.status = '0')";
            } else {
                $baseSql .= " WHERE p.status = :status";
                $params['status'] = $status;
            }
            $whereAdded = true;
        } else {
            $baseSql .= " WHERE p.status != 'deleted'";
            $whereAdded = true;
        }

        if ($category_id) {
            $baseSql .= $whereAdded ? " AND p.category_id = :category_id" : " WHERE p.category_id = :category_id";
            $params['category_id'] = $category_id;
        }
            
        return $this->fetchWithPagination(
            $baseSql,
            $params,
            ['p.product_name'],
            $keyword,
            "p.product_id DESC",
            $limit,
            $offset
        );
    }

    public function countTotalProductsFiltered($keyword = '', $status = '', $category_id = null)
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} p";
        $params = [];
        $whereAdded = false;

        if ($status !== '') {
            if ($status === '1' || $status === 'active') {
                $sql .= " WHERE (p.status = 'active' OR p.status = '1')";
            } elseif ($status === '0' || $status === 'inactive') {
                $sql .= " WHERE (p.status = 'inactive' OR p.status = '0')";
            } else {
                $sql .= " WHERE p.status = :status";
                $params['status'] = $status;
            }
            $whereAdded = true;
        } else {
            $sql .= " WHERE p.status != 'deleted'";
            $whereAdded = true;
        }

        if ($category_id) {
            $sql .= $whereAdded ? " AND p.category_id = :category_id" : " WHERE p.category_id = :category_id";
            $params['category_id'] = $category_id;
        }

        return $this->countTotalFiltered(
            $sql,
            $params,
            ['p.product_name'],
            $keyword
        );
    }

    // Lấy danh sách các sản phẩm mới nhất (Thường dùng để hiển thị ngoài trang chủ Client)
    // Chỉ lấy các sản phẩm có trạng thái 'active' (đang hoạt động)
    public function getLatestProducts($limit = 8)
    {
        $sql = "SELECT p.*, c.category_name, b.brand_name,
                       (SELECT REPLACE(REPLACE(image_url, '/uploads/products/', '/assets/uploads/products/'), '/assets/assets/', '/assets/') FROM tb_product_images WHERE product_id = p.product_id AND is_primary = 1 LIMIT 1) as image,
                       (SELECT MIN(price) FROM tb_product_variants WHERE product_id = p.product_id) as price,
                       (SELECT variant_id FROM tb_product_variants WHERE product_id = p.product_id ORDER BY price ASC LIMIT 1) as default_variant_id
                FROM {$this->table} p
                LEFT JOIN tb_categories c ON p.category_id = c.category_id
                LEFT JOIN tb_brands b ON p.brand_id = b.brand_id
                WHERE (p.status = 'active' OR p.status = 1) AND p.status != 'deleted'
                ORDER BY p.product_id DESC 
                LIMIT :limit";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Lấy danh sách các sản phẩm bán chạy nhất dựa trên số lượng đã bán trong tb_order_items
    public function getBestSellingProducts($limit = 8)
    {
        $sql = "SELECT p.*, c.category_name, b.brand_name,
                       (SELECT REPLACE(REPLACE(image_url, '/uploads/products/', '/assets/uploads/products/'), '/assets/assets/', '/assets/') FROM tb_product_images WHERE product_id = p.product_id AND is_primary = 1 LIMIT 1) as image,
                       (SELECT MIN(price) FROM tb_product_variants WHERE product_id = p.product_id) as price,
                       (SELECT variant_id FROM tb_product_variants WHERE product_id = p.product_id ORDER BY price ASC LIMIT 1) as default_variant_id,
                       (SELECT SUM(oi.quantity) 
                        FROM tb_order_items oi 
                        LEFT JOIN tb_product_variants pv ON oi.variant_id = pv.variant_id 
                        WHERE pv.product_id = p.product_id OR oi.variant_id = p.product_id) as total_sold
                FROM {$this->table} p
                LEFT JOIN tb_categories c ON p.category_id = c.category_id
                LEFT JOIN tb_brands b ON p.brand_id = b.brand_id
                WHERE p.status = 'active' OR p.status = 1
                ORDER BY total_sold DESC, p.product_id DESC
                LIMIT :limit";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Lấy thông tin chi tiết của 1 sản phẩm cụ thể dựa vào ID
    public function getProductById($id)
    {
        $sql = "SELECT p.*, c.category_name, b.brand_name,
                       (SELECT REPLACE(REPLACE(image_url, '/uploads/products/', '/assets/uploads/products/'), '/assets/assets/', '/assets/') FROM tb_product_images WHERE product_id = p.product_id AND is_primary = 1 LIMIT 1) as image,
                       (SELECT MIN(price) FROM tb_product_variants WHERE product_id = p.product_id) as price,
                       fsi.flash_price,
                       fs.end_time as flash_end_time,
                       fsi.quantity as flash_limit,
                       fsi.sold as flash_sold
                FROM {$this->table} p
                LEFT JOIN tb_categories c ON p.category_id = c.category_id
                LEFT JOIN tb_brands b ON p.brand_id = b.brand_id
                LEFT JOIN tb_flash_sale_items fsi ON p.product_id = fsi.product_id
                LEFT JOIN tb_flash_sales fs ON fsi.flash_sale_id = fs.id AND fs.status = 'active' AND fs.start_time <= NOW() AND fs.end_time >= NOW()
                WHERE p.product_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch();
        
        if ($product && $product['flash_end_time'] && $product['flash_sold'] < $product['flash_limit']) {
            $product['is_flash_sale'] = true;
            $product['original_price'] = $product['price'];
            $product['price'] = $product['flash_price'];
        } else {
            if ($product) {
                $product['is_flash_sale'] = false;
            }
        }
        
        return $product;
    }

    // ------------------------------------------------------------------------
    // INVENTORY MANAGEMENT METHODS
    // ------------------------------------------------------------------------

    public function getAllInventory($keyword = '', $limit = 0, $offset = 0, $stockFilter = '', $category_id = null)
    {
        $sql = "SELECT pv.variant_id, p.product_id, p.product_name, pv.sku, pv.price, pv.stock_quantity as stock,
                       (SELECT REPLACE(REPLACE(image_url, '/uploads/products/', '/assets/uploads/products/'), '/assets/assets/', '/assets/') FROM tb_product_images WHERE product_id = p.product_id AND is_primary = 1 LIMIT 1) as image,
                       (SELECT GROUP_CONCAT(av.attribute_value SEPARATOR ' - ') 
                        FROM tb_variant_attributes va 
                        JOIN tb_attribute_values av ON va.attribute_value_id = av.attribute_value_id 
                        WHERE va.variant_id = pv.variant_id) as attributes
                FROM tb_product_variants pv
                JOIN tb_products p ON pv.product_id = p.product_id
                WHERE (p.status = 1 OR p.status = 'active')";

        $params = [];

        if (!empty($keyword)) {
            $sql .= " AND (p.product_name LIKE :keyword OR pv.sku LIKE :keyword)";
            $params['keyword'] = "%{$keyword}%";
        }

        if ($stockFilter === 'low') {
            $sql .= " AND pv.stock_quantity <= 10";
        } elseif ($stockFilter === 'out') {
            $sql .= " AND pv.stock_quantity = 0";
        } elseif ($stockFilter === 'in') {
            $sql .= " AND pv.stock_quantity > 10";
        }

        if ($category_id) {
            $sql .= " AND p.category_id = :category_id";
            $params['category_id'] = $category_id;
        }

        $sql .= " ORDER BY pv.stock_quantity ASC, p.product_id DESC";

        if ($limit > 0) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }

        $stmt = $this->pdo->prepare($sql);

        foreach ($params as $key => $val) {
            $stmt->bindValue(':' . $key, $val);
        }

        if ($limit > 0) {
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countInventory($keyword = '', $stockFilter = '', $category_id = null)
    {
        $sql = "SELECT COUNT(*) 
                FROM tb_product_variants pv
                JOIN tb_products p ON pv.product_id = p.product_id
                WHERE (p.status = 1 OR p.status = 'active')";

        $params = [];

        if (!empty($keyword)) {
            $sql .= " AND (p.product_name LIKE :keyword OR pv.sku LIKE :keyword)";
            $params['keyword'] = "%{$keyword}%";
        }

        if ($stockFilter === 'low') {
            $sql .= " AND pv.stock_quantity <= 10";
        } elseif ($stockFilter === 'out') {
            $sql .= " AND pv.stock_quantity = 0";
        } elseif ($stockFilter === 'in') {
            $sql .= " AND pv.stock_quantity > 10";
        }

        if ($category_id) {
            $sql .= " AND p.category_id = :category_id";
            $params['category_id'] = $category_id;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    public function updateStockQuick($variant_id, $stock)
    {
        try {
            $sql = "UPDATE tb_product_variants SET stock = :stock WHERE variant_id = :variant_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'stock' => (int)$stock,
                'variant_id' => (int)$variant_id
            ]);
        } catch(PDOException $e) {}

        try {
            $sql2 = "UPDATE tb_product_variants SET stock_quantity = :stock WHERE variant_id = :variant_id";
            $stmt2 = $this->pdo->prepare($sql2);
            return $stmt2->execute([
                'stock' => (int)$stock,
                'variant_id' => (int)$variant_id
            ]);
        } catch(PDOException $e) {}
        
        return true;
    }

    // Lấy danh sách các hình ảnh của một sản phẩm (Sắp xếp theo thứ tự hiển thị)
    public function getProductImages($product_id)
    {
        $sql = "SELECT *, REPLACE(REPLACE(image_url, '/uploads/products/', '/assets/uploads/products/'), '/assets/assets/', '/assets/') as image_url FROM tb_product_images WHERE product_id = :product_id ORDER BY display_order ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['product_id' => $product_id]);
        return $stmt->fetchAll();
    }

    // Lấy các thuộc tính nhóm của sản phẩm (Ví dụ: Màu sắc: Đỏ, Xanh | RAM: 8GB, 16GB)
    // Dùng để hiển thị phần chọn cấu hình ở trang chi tiết sản phẩm
    public function getProductAttributes($product_id)
    {
        $sql = "SELECT a.attribute_name, GROUP_CONCAT(DISTINCT av.attribute_value ORDER BY av.attribute_value ASC SEPARATOR ', ') as attribute_values
                FROM tb_product_variants pv
                JOIN tb_variant_attributes va ON pv.variant_id = va.variant_id
                JOIN tb_attribute_values av ON va.attribute_value_id = av.attribute_value_id
                JOIN tb_attributes a ON av.attribute_id = a.attribute_id
                WHERE pv.product_id = :product_id
                GROUP BY a.attribute_name";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['product_id' => $product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Lấy danh sách các biến thể (phiên bản) của một sản phẩm kèm theo thuộc tính của biến thể đó
    public function getVariantsByProductId($product_id)
    {
        // Lấy tất cả biến thể
        $sql = "SELECT * FROM tb_product_variants WHERE product_id = :product_id AND status = 1 ORDER BY variant_id ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['product_id' => $product_id]);
        $variants = $stmt->fetchAll();

        // Gắn thêm thuộc tính cho mỗi biến thể
        foreach ($variants as &$variant) {
            $variant['attributes'] = $this->getVariantAttributes($variant['variant_id']);
        }

        return $variants;
    }

    public function getVariantAttributes($variant_id)
    {
        $sql = "SELECT a.attribute_name, av.attribute_value, av.attribute_value_id, a.attribute_id
                FROM tb_variant_attributes va
                JOIN tb_attribute_values av ON va.attribute_value_id = av.attribute_value_id
                JOIN tb_attributes a ON av.attribute_id = a.attribute_id
                WHERE va.variant_id = :variant_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['variant_id' => $variant_id]);
        return $stmt->fetchAll();
    }

    // Lấy danh sách sản phẩm liên quan (cùng danh mục), loại trừ sản phẩm đang xem
    public function getProductsByCategory($category_id, $limit = 4, $exclude_id = 0)
    {
        $sql = "SELECT p.*, c.category_name, b.brand_name,
                       (SELECT REPLACE(REPLACE(image_url, '/uploads/products/', '/assets/uploads/products/'), '/assets/assets/', '/assets/') FROM tb_product_images WHERE product_id = p.product_id AND is_primary = 1 LIMIT 1) as image,
                       (SELECT MIN(price) FROM tb_product_variants WHERE product_id = p.product_id) as price
                FROM {$this->table} p
                LEFT JOIN tb_categories c ON p.category_id = c.category_id
                LEFT JOIN tb_brands b ON p.brand_id = b.brand_id
                WHERE p.category_id = :category_id AND p.product_id != :exclude_id AND (p.status = 'active' OR p.status = 1)
                ORDER BY p.product_id DESC 
                LIMIT :limit";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindValue(':exclude_id', $exclude_id, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Thêm mới một sản phẩm vào CSDL (Chỉ thêm thông tin cơ bản)
    public function insertProduct($category_id, $product_name, $brand_id, $price, $warranty_period = null, $description = null, $status = 1)
    {
        $sql = "INSERT INTO {$this->table} 
    (category_id, product_name, brand_id, warranty_period, description, status) 
    VALUES 
    (:category_id, :product_name, :brand_id, :warranty_period, :description, :status)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'category_id' => $category_id,
            'product_name' => $product_name,
            'brand_id' => $brand_id,
            'warranty_period' => $warranty_period,
            'description' => $description,
            'status' => $status
        ]);

        return $this->pdo->lastInsertId();
    }

    // Cập nhật thông tin cơ bản của một sản phẩm
    public function updateProduct($id, $category_id, $product_name, $brand_id, $price, $warranty_period = null, $description = null, $status = 1)
    {
        $sql = "UPDATE {$this->table} 
                SET category_id = :category_id,
                product_name = :product_name,
                brand_id = :brand_id,
                warranty_period = :warranty_period,
                description = :description,
                status = :status
                WHERE product_id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'category_id' => $category_id,
            'product_name' => $product_name,
            'brand_id' => $brand_id,
            'warranty_period' => $warranty_period,
            'description' => $description,
            'status' => $status
        ]);
    }

    // Xóa một sản phẩm khỏi CSDL (Xóa mềm - Soft Delete)
    public function deleteProduct($id)
    {
        $sql = "UPDATE {$this->table} SET status = 'deleted' WHERE product_id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    // Insert Product Image
    public function insertProductImage($product_id, $image_url, $display_order = 1, $is_primary = 1)
    {
        $sql = "INSERT INTO tb_product_images (product_id, image_url, display_order, is_primary) 
                VALUES (:product_id, :image_url, :display_order, :is_primary)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'product_id' => $product_id,
            'image_url' => $image_url,
            'display_order' => $display_order,
            'is_primary' => $is_primary
        ]);
    }

    public function deletePrimaryImage($product_id)
    {
        $sql = "DELETE FROM tb_product_images WHERE product_id = :product_id AND is_primary = 1";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['product_id' => $product_id]);
    }

    public function deleteGalleryImages($product_id)
    {
        $sql = "DELETE FROM tb_product_images WHERE product_id = :product_id AND is_primary = 0";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['product_id' => $product_id]);
    }

    // --- Các hàm xử lý BIẾN THỂ (VARIANTS) ---
    public function insertVariant($product_id, $variant_name, $price, $stock_quantity = 0, $sku = null, $image_url = null, $status = 1)
    {
        $sql = "INSERT INTO tb_product_variants (product_id, variant_name, price, stock_quantity, sku, image_url, status) 
                VALUES (:product_id, :variant_name, :price, :stock_quantity, :sku, :image_url, :status)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'product_id' => $product_id,
            'variant_name' => $variant_name,
            'price' => $price,
            'stock_quantity' => $stock_quantity,
            'sku' => $sku,
            'image_url' => $image_url,
            'status' => $status
        ]);
        return $this->pdo->lastInsertId();
    }

    public function insertDefaultVariant($product_id, $price, $stock_quantity = 0)
    {
        return $this->insertVariant($product_id, 'Mặc định', (int) $price, (int) $stock_quantity, null, null, 1);
    }

    public function insertVariantAttribute($variant_id, $attribute_value_id)
    {
        $sql = "INSERT INTO tb_variant_attributes (variant_id, attribute_value_id) VALUES (:variant_id, :attribute_value_id)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'variant_id' => $variant_id,
            'attribute_value_id' => $attribute_value_id
        ]);
    }

    public function updateVariant($variant_id, $variant_name, $price, $stock_quantity, $sku = null, $image_url = null)
    {
        $sql = "UPDATE tb_product_variants 
                SET variant_name = :variant_name, price = :price, stock_quantity = :stock_quantity, sku = :sku, image_url = :image_url
                WHERE variant_id = :variant_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'variant_id' => $variant_id,
            'variant_name' => $variant_name,
            'price' => $price,
            'stock_quantity' => $stock_quantity,
            'sku' => $sku,
            'image_url' => $image_url
        ]);
    }

    public function deleteUnusedVariants($product_id, $keep_variant_ids = [])
    {
        try {
            if (empty($keep_variant_ids)) {
                $sql = "DELETE FROM tb_product_variants WHERE product_id = :product_id AND variant_id NOT IN (SELECT variant_id FROM tb_order_items)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute(['product_id' => $product_id]);
            } else {
                $placeholders = implode(',', array_fill(0, count($keep_variant_ids), '?'));
                $sql = "DELETE FROM tb_product_variants 
                        WHERE product_id = ? 
                        AND variant_id NOT IN ($placeholders)
                        AND variant_id NOT IN (SELECT variant_id FROM tb_order_items)";
                $stmt = $this->pdo->prepare($sql);
                $params = array_merge([$product_id], $keep_variant_ids);
                $stmt->execute($params);
            }
        } catch (PDOException $e) {
            // Ignore if there are still foreign key constraints we didn't catch
        }
    }

    public function deleteVariantsByProductId($product_id)
    {
        try {
            $sql = "DELETE FROM tb_product_variants WHERE product_id = :product_id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute(['product_id' => $product_id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deleteVariantAttributesByVariant($variant_id)
    {
        $sql = "DELETE FROM tb_variant_attributes WHERE variant_id = :variant_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['variant_id' => $variant_id]);
    }

    // --- Các hàm xử lý THÔNG SỐ (SPECS) ---
    public function insertProductSpec($product_id, $spec_name, $spec_value)
    {
        $sql = "INSERT INTO tb_product_specs (product_id, spec_name, spec_value) VALUES (:product_id, :spec_name, :spec_value)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'product_id' => $product_id,
            'spec_name' => $spec_name,
            'spec_value' => $spec_value
        ]);
    }

    public function getProductSpecs($product_id)
    {
        $sql = "SELECT * FROM tb_product_specs WHERE product_id = :product_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['product_id' => $product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteProductSpecs($product_id)
    {
        $sql = "DELETE FROM tb_product_specs WHERE product_id = :product_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['product_id' => $product_id]);
    }

    // --- Các hàm phục vụ LỌC SẢN PHẨM (FILTER) ở trang danh sách sản phẩm ---

    // Lấy tất cả các thuộc tính đang có trong CSDL để tạo bộ lọc (ví dụ: lấy tất cả các loại RAM đang có)
    public function getAttributesForFilter()
    {
        $sql = "SELECT a.attribute_id, a.attribute_name, av.attribute_value_id, av.attribute_value 
                FROM tb_attributes a
                JOIN tb_attribute_values av ON a.attribute_id = av.attribute_id
                WHERE av.attribute_value_id IN (
                    SELECT DISTINCT va.attribute_value_id 
                    FROM tb_variant_attributes va
                    JOIN tb_product_variants pv ON va.variant_id = pv.variant_id
                    JOIN tb_products p ON pv.product_id = p.product_id
                    WHERE p.status = 1 OR p.status = 'active'
                )
                ORDER BY a.attribute_name, av.attribute_value";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();

        $attributes = [];
        foreach ($results as $row) {
            $attr_id = $row['attribute_id'];
            if (!isset($attributes[$attr_id])) {
                $attributes[$attr_id] = [
                    'attribute_name' => $row['attribute_name'],
                    'values' => []
                ];
            }
            $attributes[$attr_id]['values'][] = [
                'attribute_value_id' => $row['attribute_value_id'],
                'attribute_value' => $row['attribute_value']
            ];
        }
        return $attributes;
    }

    // Hàm nội bộ: Xây dựng câu truy vấn SQL động dựa trên các tiêu chí lọc
    private function buildFilterQuery($filters, $isCount = false)
    {
        $sqlSelect = $isCount ? "COUNT(DISTINCT p.product_id) as total" : "p.*, c.category_name, b.brand_name,
                           (SELECT image_url FROM tb_product_images WHERE product_id = p.product_id AND is_primary = 1 LIMIT 1) as image,
                           (SELECT MIN(price) FROM tb_product_variants WHERE product_id = p.product_id) as price,
                           (SELECT variant_id FROM tb_product_variants WHERE product_id = p.product_id ORDER BY price ASC LIMIT 1) as default_variant_id";
                           
        // We use LEFT JOIN for optional data and JOIN for data we need to filter strongly on
        $sql = "SELECT $sqlSelect
                FROM tb_products p
                LEFT JOIN tb_categories c ON p.category_id = c.category_id
                LEFT JOIN tb_brands b ON p.brand_id = b.brand_id
                WHERE (p.status = 'active' OR p.status = 1)";

        $params = [];

        if (!empty($filters['keyword'])) {
            $sql .= " AND (p.product_name LIKE :keyword OR c.category_name LIKE :keyword OR b.brand_name LIKE :keyword)";
            $params['keyword'] = "%{$filters['keyword']}%";
        }

        if (!empty($filters['categories'])) {
            $catIds = implode(',', array_map('intval', $filters['categories']));
            $sql .= " AND p.category_id IN ($catIds)";
        }

        if (!empty($filters['brands'])) {
            $brandIds = implode(',', array_map('intval', $filters['brands']));
            $sql .= " AND p.brand_id IN ($brandIds)";
        }

        // Logic AND đa chiều cho thuộc tính: Sản phẩm phải có chứa tất cả các thuộc tính được yêu cầu
        if (!empty($filters['attributeValues'])) {
            // Group attribute values by their parent attribute_id (to support OR within same attribute, AND across different)
            // But since the UI usually passes a flat array of attribute_value_ids, a strict AND is often implemented by counting matches
            // We assume the user wants products matching ALL selected attribute values (AND logic across different attributes)
            // Note: If they select two RAMs, they usually want OR. To handle this properly, we group them by attribute.
            // For simplicity here, we will just use EXISTS for each selected attribute value id, which means AND logic.
            // If grouped array is passed like ['attribute_id' => [val_id1, val_id2]], we can do IN for each group.
            
            if (is_array(current($filters['attributeValues']))) {
                // Grouped format: [attr_id_1 => [val_id_1, val_id_2], attr_id_2 => [val_id_3]]
                foreach ($filters['attributeValues'] as $attrId => $valIds) {
                    if (empty($valIds)) continue;
                    $valIdsStr = implode(',', array_map('intval', $valIds));
                    $sql .= " AND EXISTS (
                        SELECT 1 FROM tb_product_variants pv
                        JOIN tb_variant_attributes va ON pv.variant_id = va.variant_id
                        WHERE pv.product_id = p.product_id AND va.attribute_value_id IN ($valIdsStr)
                    )";
                }
            } else {
                // Flat array fallback
                $attrIds = implode(',', array_map('intval', $filters['attributeValues']));
                $sql .= " AND EXISTS (
                    SELECT 1 FROM tb_product_variants pv
                    JOIN tb_variant_attributes va ON pv.variant_id = va.variant_id
                    WHERE pv.product_id = p.product_id AND va.attribute_value_id IN ($attrIds)
                )";
            }
        }

        if (isset($filters['minPrice']) && $filters['minPrice'] > 0) {
            $sql .= " AND (SELECT MIN(price) FROM tb_product_variants WHERE product_id = p.product_id) >= :minPrice";
            $params['minPrice'] = $filters['minPrice'];
        }
        if (isset($filters['maxPrice']) && $filters['maxPrice'] > 0) {
            $sql .= " AND (SELECT MIN(price) FROM tb_product_variants WHERE product_id = p.product_id) <= :maxPrice";
            $params['maxPrice'] = $filters['maxPrice'];
        }

        if (isset($filters['minWarranty']) && $filters['minWarranty'] > 0) {
            $sql .= " AND p.warranty_period >= :minWarranty";
            $params['minWarranty'] = $filters['minWarranty'];
        }

        if (isset($filters['inStock']) && $filters['inStock']) {
            $sql .= " AND (SELECT SUM(stock_quantity) FROM tb_product_variants WHERE product_id = p.product_id) > 0";
        }

        if (isset($filters['minRating']) && $filters['minRating'] > 0) {
            $sql .= " AND (SELECT AVG(rating) FROM tb_reviews WHERE product_id = p.product_id) >= :minRating";
            $params['minRating'] = $filters['minRating'];
        }

        if (!$isCount) {
            $sort = $filters['sort'] ?? '';
            if ($sort == 'price_asc') {
                $sql .= " ORDER BY price ASC";
            } elseif ($sort == 'price_desc') {
                $sql .= " ORDER BY price DESC";
            } elseif ($sort == 'best_selling') {
                 $sql .= " ORDER BY (SELECT SUM(oi.quantity) FROM tb_order_items oi LEFT JOIN tb_product_variants pv ON oi.variant_id = pv.variant_id WHERE pv.product_id = p.product_id) DESC, p.product_id DESC";
            } elseif ($sort == 'top_rated') {
                $sql .= " ORDER BY (SELECT AVG(rating) FROM tb_reviews WHERE product_id = p.product_id) DESC, p.product_id DESC";
            } else {
                $sql .= " ORDER BY p.product_id DESC"; // Default: Newest
            }
        }

        return [$sql, $params];
    }

    public function getProductsFiltered($filters, $limit, $offset)
    {
        list($sql, $params) = $this->buildFilterQuery($filters);

        $limitInt = (int)$limit;
        $offsetInt = (int)$offset;
        $sql .= " LIMIT {$limitInt} OFFSET {$offsetInt}";

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Đếm tổng số lượng sản phẩm thỏa mãn điều kiện lọc (để tính toán số trang phân trang)
    public function countProductsFiltered($filters)
    {
        list($sql, $params) = $this->buildFilterQuery($filters, true);

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ? $result['total'] : 0;
    }
    // Lấy số lượng tồn kho của một biến thể
    public function getVariantStock($variant_id)
    {
        try {
            $sql = "SELECT stock_quantity FROM tb_product_variants WHERE variant_id = :variant_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['variant_id' => $variant_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result && isset($result['stock_quantity'])) {
                return (int) $result['stock_quantity'];
            }
        } catch (PDOException $e) {
            // Cột stock_quantity không tồn tại, bỏ qua
        }

        // Fallback to stock
        try {
            $sql2 = "SELECT stock FROM tb_product_variants WHERE variant_id = :variant_id";
            $stmt2 = $this->pdo->prepare($sql2);
            $stmt2->execute(['variant_id' => $variant_id]);
            $res2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            return $res2 ? (int) $res2['stock'] : 0;
        } catch (PDOException $e) {
            return 0;
        }
    }

    // Trừ số lượng tồn kho của một biến thể
    public function reduceVariantStock($variant_id, $quantity)
    {
        // Kiểm tra xem số lượng có đủ để trừ hay không để tránh số âm
        $currentStock = $this->getVariantStock($variant_id);
        if ($currentStock < $quantity) {
            return false;
        }

        // Cập nhật cả 2 cột nếu schema có sự nhầm lẫn
        try {
            $sql = "UPDATE tb_product_variants SET stock = stock - :quantity WHERE variant_id = :variant_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'quantity' => $quantity,
                'variant_id' => $variant_id
            ]);
        } catch(PDOException $e) {
            // Ignore if 'stock' column doesn't exist
        }

        try {
            $sql2 = "UPDATE tb_product_variants SET stock_quantity = stock_quantity - :quantity WHERE variant_id = :variant_id";
            $stmt2 = $this->pdo->prepare($sql2);
            $stmt2->execute([
                'quantity' => $quantity,
                'variant_id' => $variant_id
            ]);
        } catch(PDOException $e) {
            // Ignore if 'stock_quantity' doesn't exist
        }

        return true;
    }

    // Phục hồi số lượng tồn kho của một biến thể (dùng khi hủy đơn/hoàn hàng)
    public function restoreVariantStock($variant_id, $quantity)
    {
        try {
            $sql = "UPDATE tb_product_variants SET stock = stock + :quantity WHERE variant_id = :variant_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['quantity' => $quantity, 'variant_id' => $variant_id]);
        } catch(PDOException $e) {}

        try {
            $sql2 = "UPDATE tb_product_variants SET stock_quantity = stock_quantity + :quantity WHERE variant_id = :variant_id";
            $stmt2 = $this->pdo->prepare($sql2);
            $stmt2->execute(['quantity' => $quantity, 'variant_id' => $variant_id]);
        } catch(PDOException $e) {}
        
        return true;
    }

    // Lấy số lượng tồn kho của sản phẩm gốc
    public function getProductStock($product_id)
    {
        try {
            $sql = "SELECT stock_quantity FROM tb_products WHERE product_id = :product_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['product_id' => $product_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result && isset($result['stock_quantity'])) return (int) $result['stock_quantity'];
        } catch (PDOException $e) {
            // Ignore if column doesn't exist
        }
        
        try {
            $sql2 = "SELECT stock FROM tb_products WHERE product_id = :product_id";
            $stmt2 = $this->pdo->prepare($sql2);
            $stmt2->execute(['product_id' => $product_id]);
            $res2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            return $res2 ? (int) $res2['stock'] : 0;
        } catch (PDOException $e) {
            return 0;
        }
    }

    // Trừ số lượng tồn kho của sản phẩm gốc
    public function reduceProductStock($product_id, $quantity)
    {
        $currentStock = $this->getProductStock($product_id);
        if ($currentStock < $quantity) {
            return false;
        }

        try {
            $sql = "UPDATE tb_products SET stock = stock - :quantity WHERE product_id = :product_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['quantity' => $quantity, 'product_id' => $product_id]);
        } catch (PDOException $e) {
            // Ignore if column doesn't exist
        }

        try {
            $sql2 = "UPDATE tb_products SET stock_quantity = stock_quantity - :quantity WHERE product_id = :product_id";
            $stmt2 = $this->pdo->prepare($sql2);
            $stmt2->execute(['quantity' => $quantity, 'product_id' => $product_id]);
        } catch (PDOException $e) {
            // Ignore if column doesn't exist
        }
        return true;
    }

    // Phục hồi số lượng tồn kho của sản phẩm gốc (dùng khi hủy đơn/hoàn hàng)
    public function restoreProductStock($product_id, $quantity)
    {
        try {
            $sql = "UPDATE tb_products SET stock = stock + :quantity WHERE product_id = :product_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['quantity' => $quantity, 'product_id' => $product_id]);
        } catch(PDOException $e) {}

        try {
            $sql2 = "UPDATE tb_products SET stock_quantity = stock_quantity + :quantity WHERE product_id = :product_id";
            $stmt2 = $this->pdo->prepare($sql2);
            $stmt2->execute(['quantity' => $quantity, 'product_id' => $product_id]);
        } catch(PDOException $e) {}
        
        return true;
    }
}
