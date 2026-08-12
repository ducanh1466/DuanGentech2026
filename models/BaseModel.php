<?php

class BaseModel
{
    protected $table;
    public $pdo;

    // Kết nối CSDL
    public function __construct()
    {
        $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8', DB_HOST, DB_PORT, DB_NAME);

        try {
            $this->pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
        } catch (PDOException $e) {
            // Xử lý lỗi kết nối
            die("Kết nối cơ sở dữ liệu thất bại: {$e->getMessage()}. Vui lòng thử lại sau.");
        }
    }

    public function getPdo()
    {
        return $this->pdo;
    }

    // Hàm dùng chung để lấy dữ liệu có phân trang và tìm kiếm
    public function fetchWithPagination($baseSql, $params = [], $searchColumns = [], $keyword = '', $orderBy = '', $limit = 0, $offset = 0)
    {
        if ($keyword !== '' && !empty($searchColumns)) {
            $conditions = [];
            foreach ($searchColumns as $col) {
                $conditions[] = "$col LIKE :keyword";
            }
            $baseSql .= (stripos($baseSql, 'WHERE') !== false ? " AND (" : " WHERE (") . implode(' OR ', $conditions) . ")";
            $params['keyword'] = "%$keyword%";
        }

        if (!empty($orderBy)) {
            $baseSql .= " ORDER BY " . $orderBy;
        }

        if ($limit > 0) {
            $baseSql .= " LIMIT :limit OFFSET :offset";
        }

        $stmt = $this->pdo->prepare($baseSql);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        
        if ($limit > 0) {
            $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Hàm dùng chung để đếm tổng số bản ghi khi có tìm kiếm
    public function countTotalFiltered($baseSql, $params = [], $searchColumns = [], $keyword = '')
    {
        if ($keyword !== '' && !empty($searchColumns)) {
            $conditions = [];
            foreach ($searchColumns as $col) {
                $conditions[] = "$col LIKE :keyword";
            }
            $baseSql .= (stripos($baseSql, 'WHERE') !== false ? " AND (" : " WHERE (") . implode(' OR ', $conditions) . ")";
            $params['keyword'] = "%$keyword%";
        }

        $stmt = $this->pdo->prepare($baseSql);
        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();
        return $stmt->fetch()['total'] ?? 0;
    }

    // Hủy kết nối CSDL
    public function __destruct()
    {
        $this->pdo = null;
    }
}
