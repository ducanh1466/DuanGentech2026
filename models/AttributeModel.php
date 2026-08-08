<?php
require_once 'BaseModel.php';

class AttributeModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Lấy tất cả thuộc tính kèm theo các giá trị của nó
     */
    public function getAllAttributesWithValues()
    {
        $sql = "SELECT a.attribute_id, a.attribute_name, 
                       av.attribute_value_id, av.attribute_value
                FROM tb_attributes a
                LEFT JOIN tb_attribute_values av ON a.attribute_id = av.attribute_id
                ORDER BY a.attribute_id DESC, av.attribute_value ASC";
        
        $stmt = $this->pdo->query($sql);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $attributes = [];
        foreach ($results as $row) {
            $attr_id = $row['attribute_id'];
            if (!isset($attributes[$attr_id])) {
                $attributes[$attr_id] = [
                    'attribute_id' => $attr_id,
                    'attribute_name' => $row['attribute_name'],
                    'values' => []
                ];
            }
            if (!empty($row['attribute_value_id'])) {
                $attributes[$attr_id]['values'][] = [
                    'attribute_value_id' => $row['attribute_value_id'],
                    'attribute_value' => $row['attribute_value']
                ];
            }
        }
        return array_values($attributes);
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
