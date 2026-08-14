<?php

class BannerModel extends BaseModel
{
    // Đặt tên bảng là banners
    protected $table = 'banners';

    /**
     * Lấy danh sách tất cả các banner (dùng cho Admin)
     */
    public function getAllBanners($limit = 10, $offset = 0, $keyword = '', $status = '')
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
            ['title'],
            $keyword,
            "id DESC",
            $limit,
            $offset
        );
    }

    public function countTotalBannersFiltered($keyword = '', $status = '')
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
            ['title'],
            $keyword
        );
    }

    /**
     * Lấy các banner đang bật (status = 1) theo vị trí (dùng cho trang chủ Client)
     * 
     * @param string $position (hero_slider hoặc promo_banner)
     * @param int|null $limit Giới hạn số lượng lấy ra (VD: lấy 2 banner khuyến mãi)
     */
    public function getActiveBannersByPosition($position, $limit = null)
    {
        $sql = "SELECT * FROM {$this->table} WHERE position = :position AND status = 1 ORDER BY id DESC";
        if ($limit !== null) {
            $sql .= " LIMIT " . (int)$limit;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':position', $position, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy thông tin 1 banner theo ID (dùng cho sửa banner)
     */
    public function getBannerById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Thêm mới banner vào CSDL
     */
    public function createBanner($title, $image_url, $link, $position, $status)
    {
        $sql = "INSERT INTO {$this->table} (title, image_url, link, position, status) 
                VALUES (:title, :image_url, :link, :position, :status)";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':image_url', $image_url);
        $stmt->bindParam(':link', $link);
        $stmt->bindParam(':position', $position);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    /**
     * Cập nhật thông tin banner đã có
     */
    public function updateBanner($id, $title, $image_url, $link, $position, $status)
    {
        $sql = "UPDATE {$this->table} 
                SET title = :title, 
                    image_url = :image_url, 
                    link = :link, 
                    position = :position, 
                    status = :status 
                WHERE id = :id";
                
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':image_url', $image_url);
        $stmt->bindParam(':link', $link);
        $stmt->bindParam(':position', $position);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    /**
     * Xóa banner khỏi CSDL
     */
    public function deleteBanner($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
