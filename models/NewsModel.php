<?php
class NewsModel extends BaseModel
{
    protected $table = 'tb_news';

    public function getAllNews($limit = 10, $offset = 0, $keyword = '', $status = '')
    {
        $sql = "SELECT n.*, c.name as category_name FROM {$this->table} n LEFT JOIN tb_news_categories c ON n.category_id = c.id";
        $params = [];
        if ($status !== '') {
            $sql .= " WHERE n.status = :status";
            $params['status'] = $status;
        }

        return $this->fetchWithPagination(
            $sql,
            $params,
            ['n.title'],
            $keyword,
            "n.created_at DESC",
            $limit,
            $offset
        );
    }

    public function countTotalNewsFiltered($keyword = '', $status = '')
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} n LEFT JOIN tb_news_categories c ON n.category_id = c.id";
        $params = [];
        if ($status !== '') {
            $sql .= " WHERE n.status = :status";
            $params['status'] = $status;
        }

        return $this->countTotalFiltered(
            $sql,
            $params,
            ['n.title'],
            $keyword
        );
    }

    public function getActiveNews($limit = null)
    {
        $sql = "SELECT n.*, c.name as category_name 
                FROM {$this->table} n
                LEFT JOIN tb_news_categories c ON n.category_id = c.id
                WHERE n.status = 1 AND n.is_featured = 0
                ORDER BY n.created_at DESC";
                
        if ($limit !== null) {
            $sql .= " LIMIT " . (int)$limit;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFeaturedNews()
    {
        $sql = "SELECT n.*, c.name as category_name 
                FROM {$this->table} n
                LEFT JOIN tb_news_categories c ON n.category_id = c.id
                WHERE n.status = 1 AND n.is_featured = 1
                ORDER BY n.created_at DESC LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getNewsBySlug($slug)
    {
        $sql = "SELECT n.*, c.name as category_name 
                FROM {$this->table} n
                LEFT JOIN tb_news_categories c ON n.category_id = c.id
                WHERE n.slug = :slug";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':slug', $slug);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getNewsById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function incrementViews($id)
    {
        $sql = "UPDATE {$this->table} SET views = views + 1 WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function createNews($data)
    {
        $sql = "INSERT INTO {$this->table} (title, slug, summary, content, image_url, category_id, is_featured, status) 
                VALUES (:title, :slug, :summary, :content, :image_url, :category_id, :is_featured, :status)";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':slug', $data['slug']);
        $stmt->bindParam(':summary', $data['summary']);
        $stmt->bindParam(':content', $data['content']);
        $stmt->bindParam(':image_url', $data['image_url']);
        $stmt->bindParam(':category_id', $data['category_id']);
        $stmt->bindParam(':is_featured', $data['is_featured']);
        $stmt->bindParam(':status', $data['status']);
        
        return $stmt->execute();
    }

    public function updateNews($id, $data)
    {
        $sql = "UPDATE {$this->table} 
                SET title = :title, slug = :slug, summary = :summary, content = :content, 
                    image_url = :image_url, category_id = :category_id, 
                    is_featured = :is_featured, status = :status
                WHERE id = :id";
                
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':slug', $data['slug']);
        $stmt->bindParam(':summary', $data['summary']);
        $stmt->bindParam(':content', $data['content']);
        $stmt->bindParam(':image_url', $data['image_url']);
        $stmt->bindParam(':category_id', $data['category_id']);
        $stmt->bindParam(':is_featured', $data['is_featured']);
        $stmt->bindParam(':status', $data['status']);
        
        return $stmt->execute();
    }

    public function deleteNews($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
