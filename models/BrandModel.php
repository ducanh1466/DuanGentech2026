<?php

class BrandModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'tb_brands';
    }

    // Lấy danh sách tất cả các thương hiệu
    public function getAllBrands($keyword = '', $limit = 0, $offset = 0)
    {
        $sql = "SELECT * FROM {$this->table}";
        if (!empty($keyword)) {
            $sql .= " WHERE brand_name LIKE :keyword";
        }
        $sql .= " ORDER BY brand_id DESC";
        
        if ($limit > 0) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }
        
        $stmt = $this->pdo->prepare($sql);
        if (!empty($keyword)) {
            $stmt->bindValue(':keyword', "%$keyword%");
        }
        if ($limit > 0) {
            $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countTotalBrands($keyword = '')
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        if (!empty($keyword)) {
            $sql .= " WHERE brand_name LIKE :keyword";
        }
        $stmt = $this->pdo->prepare($sql);
        if (!empty($keyword)) {
            $stmt->bindValue(':keyword', "%$keyword%");
        }
        $stmt->execute();
        return $stmt->fetch()['total'] ?? 0;
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
}