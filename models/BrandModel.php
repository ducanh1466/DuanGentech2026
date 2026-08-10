<?php

class BrandModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'tb_brands';
    }

    public function getAllBrands($keyword = '', $limit = 0, $offset = 0)
    {
        return $this->fetchWithPagination(
            "SELECT * FROM {$this->table}",
            [],
            ['brand_name'],
            $keyword,
            "brand_id DESC",
            $limit,
            $offset
        );
    }

    public function countTotalBrands($keyword = '')
    {
        return $this->countTotalFiltered(
            "SELECT COUNT(*) as total FROM {$this->table}",
            [],
            ['brand_name'],
            $keyword
        );
    }

    // Lấy thông tin một thương hiệu theo ID
    public function getBrandById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE brand_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // Thêm mới một thương hiệu vào CSDL
    public function insertBrand($brand_name, $description = null, $status = 1)
    {
        $sql = "INSERT INTO {$this->table} (brand_name, description, status) VALUES (:brand_name, :description, :status)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'brand_name' => $brand_name,
            'description' => $description,
            'status' => $status
        ]);
    }

    // Cập nhật thông tin thương hiệu
    public function updateBrand($id, $brand_name, $description = null, $status = 1)
    {
        $sql = "UPDATE {$this->table} SET brand_name = :brand_name, description = :description, status = :status WHERE brand_id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'brand_name' => $brand_name,
            'description' => $description,
            'status' => $status
        ]);
    }

    // Xóa một thương hiệu khỏi CSDL (Có xử lý an toàn lỗi khóa ngoại)
    public function deleteBrand($id)
    {
        try {
            $sql = "DELETE FROM {$this->table} WHERE brand_id = :id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute(['id' => $id]);
        } catch (\PDOException $e) {
            // Mã lỗi 23000: Bị vướng ràng buộc khóa ngoại (vẫn còn sản phẩm thuộc thương hiệu)
            if ($e->getCode() == '23000') {
                return false;
            }
            throw $e;
        }
    }

    // Lấy các thương hiệu thuộc một danh mục cụ thể (thông qua bảng sản phẩm)
    public function getBrandsByCategoryId($categoryId)
    {
        $sql = "SELECT DISTINCT b.* 
                FROM {$this->table} b
                JOIN tb_products p ON b.brand_id = p.brand_id
                WHERE p.category_id = :category_id AND b.status = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['category_id' => $categoryId]);
        return $stmt->fetchAll();
    }
}