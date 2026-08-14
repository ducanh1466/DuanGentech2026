<?php
class NewsCategoryModel extends BaseModel
{
    protected $table = 'tb_news_categories';

    public function getAllCategories($limit = 10, $offset = 0, $keyword = '', $status = '')
    {
        $sql = "SELECT * FROM {$this->table}";
        $params = [];
        if ($status !== '') {
            $sql .= " WHERE status = :status";
            $params['status'] = $status;
        }

        return $this->fetchWithPagination(
            $sql,
            $params,
            ['name'],
            $keyword,
            "id DESC",
            $limit,
            $offset
        );
    }

    public function countTotalCategoriesFiltered($keyword = '', $status = '')
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $params = [];
        if ($status !== '') {
            $sql .= " WHERE status = :status";
            $params['status'] = $status;
        }

        return $this->countTotalFiltered(
            $sql,
            $params,
            ['name'],
            $keyword
        );
    }

    public function getActiveCategories()
    {
        $sql = "SELECT * FROM {$this->table} WHERE status = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getCategoryById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createCategory($name, $slug, $status)
    {
        $sql = "INSERT INTO {$this->table} (name, slug, status) VALUES (:name, :slug, :status)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':slug', $slug);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updateCategory($id, $name, $slug, $status)
    {
        $sql = "UPDATE {$this->table} SET name = :name, slug = :slug, status = :status WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':slug', $slug);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteCategory($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
