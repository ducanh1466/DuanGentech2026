<?php

class CategoryModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'tb_categories';
    }

    // Lấy danh sách tất cả các danh mục
    public function getAllCategories($keyword = '', $limit = 0, $offset = 0)
    {
        $sql = "SELECT * FROM {$this->table}";
        if (!empty($keyword)) {
            $sql .= " WHERE category_name LIKE :keyword";
        }
        $sql .= " ORDER BY category_id DESC";
        
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

    public function countTotalCategories($keyword = '')
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        if (!empty($keyword)) {
            $sql .= " WHERE category_name LIKE :keyword";
        }
        $stmt = $this->pdo->prepare($sql);
        if (!empty($keyword)) {
            $stmt->bindValue(':keyword', "%$keyword%");
        }
        $stmt->execute();
        return $stmt->fetch()['total'] ?? 0;
    }

    // Lấy thông tin chi tiết một danh mục theo ID
    public function getCategoryById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE category_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // Thêm mới một danh mục vào CSDL
    public function insertCategory($category_name, $description = null)
    {
        $sql = "INSERT INTO {$this->table} (category_name, description) VALUES (:category_name, :description)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'category_name' => $category_name,
            'description' => $description
        ]);
    }

    // Cập nhật thông tin danh mục
    public function updateCategory($id, $category_name, $description = null)
    {
        $sql = "UPDATE {$this->table} SET category_name = :category_name, description = :description WHERE category_id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'category_name' => $category_name,
            'description' => $description
        ]);
    }

    // Xóa một danh mục khỏi CSDL
    public function deleteCategory($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE category_id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
