<?php
require_once 'BaseModel.php';

class AttributeModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllAttributesWithValues($limit = 10, $offset = 0, $keyword = '')
    {
        // 1. Lấy danh sách các ID thuộc tính (có phân trang)
        $sql = "SELECT attribute_id, attribute_name FROM tb_attributes";
        $params = [];
        if ($keyword !== '') {
            $sql .= " WHERE attribute_name LIKE :keyword";
            $params['keyword'] = "%$keyword%";
        }
        $sql .= " ORDER BY attribute_id DESC";
        
        if ($limit > 0) {
            $sql .= " LIMIT " . (int)$limit . " OFFSET " . (int)$offset;
        }

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue(":$key", $val);
        }
        $stmt->execute();
        $baseAttrs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($baseAttrs)) return [];

        // 2. Lấy danh sách giá trị của các thuộc tính vừa tìm được
        $attrIds = array_column($baseAttrs, 'attribute_id');
        $inQuery = implode(',', array_map('intval', $attrIds));
        
        $sqlValues = "SELECT attribute_id, attribute_value_id, attribute_value 
                      FROM tb_attribute_values 
                      WHERE attribute_id IN ($inQuery)
                      ORDER BY attribute_value ASC";
        $stmtValues = $this->pdo->query($sqlValues);
        $values = $stmtValues->fetchAll(PDO::FETCH_ASSOC);

        // 3. Ghép data
        $attributes = [];
        foreach ($baseAttrs as $attr) {
            $attr['values'] = [];
            $attributes[$attr['attribute_id']] = $attr;
        }

        foreach ($values as $val) {
            $attributes[$val['attribute_id']]['values'][] = [
                'attribute_value_id' => $val['attribute_value_id'],
                'attribute_value' => $val['attribute_value']
            ];
        }

        return array_values($attributes);
    }

    public function countTotalAttributesFiltered($keyword = '')
    {
        $sql = "SELECT COUNT(*) as total FROM tb_attributes";
        $params = [];
        if ($keyword !== '') {
            $sql .= " WHERE attribute_name LIKE :keyword";
            $params['keyword'] = "%$keyword%";
        }

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue(":$key", $val);
        }
        $stmt->execute();
        return $stmt->fetch()['total'] ?? 0;
    }

    /**
     * Lấy một thuộc tính theo ID
     */
    public function getAttributeById($id)
    {
        $sql = "SELECT * FROM tb_attributes WHERE attribute_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Thêm thuộc tính mới
     */
    public function addAttribute($name)
    {
        $sql = "INSERT INTO tb_attributes (attribute_name) VALUES (:name)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['name' => $name]);
        return $this->pdo->lastInsertId();
    }

    /**
     * Sửa tên thuộc tính
     */
    public function updateAttribute($id, $name)
    {
        $sql = "UPDATE tb_attributes SET attribute_name = :name WHERE attribute_id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['name' => $name, 'id' => $id]);
    }

    /**
     * Xóa thuộc tính
     */
    public function deleteAttribute($id)
    {
        $sql = "DELETE FROM tb_attributes WHERE attribute_id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Thêm giá trị cho thuộc tính
     */
    public function addAttributeValue($attribute_id, $value)
    {
        $sql = "INSERT INTO tb_attribute_values (attribute_id, attribute_value) VALUES (:attribute_id, :value)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['attribute_id' => $attribute_id, 'value' => $value]);
        return $this->pdo->lastInsertId();
    }

    /**
     * Xóa giá trị thuộc tính
     */
    public function deleteAttributeValue($value_id)
    {
        $sql = "DELETE FROM tb_attribute_values WHERE attribute_value_id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $value_id]);
    }
}
