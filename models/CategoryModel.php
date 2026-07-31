<?php

class CategoryModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'tb_categories';
    }

    public function getAllCategories($keyword = '', $limit = 0, $offset = 0)
    {
        return $this->fetchWithPagination(
            "SELECT * FROM {$this->table}",
            [],
            ['category_name'],
            $keyword,
            "category_id DESC",
            $limit,
            $offset
        );
    }

    public function countTotalCategories($keyword = '')
    {
        return $this->countTotalFiltered(
            "SELECT COUNT(*) as total FROM {$this->table}",
            [],
            ['category_name'],
            $keyword
        );
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
