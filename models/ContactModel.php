<?php

class ContactModel extends BaseModel {
    
    protected $table = 'tb_contacts';

    public function addContact($data) {
        $sql = "INSERT INTO {$this->table} (fullname, phone, order_id, product_model, serial_number, type, priority, message, status, attached_file, assigned_department) 
                VALUES (:fullname, :phone, :order_id, :product_model, :serial_number, :type, :priority, :message, 'pending', :attached_file, 'CSKH')";
        
        $params = [
            'fullname' => $data['fullname'],
            'phone' => $data['phone'],
            'order_id' => $data['order_id'] ?? null,
            'product_model' => $data['product_model'] ?? null,
            'serial_number' => $data['serial_number'] ?? null,
            'type' => $data['type'],
            'priority' => $data['priority'] ?? 'normal',
            'message' => $data['message'],
            'attached_file' => $data['attached_file'] ?? null
        ];
        
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute($params);
        if ($result) {
            $contactId = $this->pdo->lastInsertId();
            $this->addLog($contactId, null, 'create', 'Khách hàng tạo mới yêu cầu hỗ trợ.');
            return true;
        }
        return false;
    }

    public function addLog($contactId, $userId, $action, $note = null) {
        $sql = "INSERT INTO tb_contact_logs (contact_id, user_id, action, note) VALUES (:contact_id, :user_id, :action, :note)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'contact_id' => $contactId,
            'user_id' => $userId,
            'action' => $action,
            'note' => $note
        ]);
    }

    public function getLogsByContactId($contactId) {
        $sql = "SELECT l.*, u.full_name as user_name FROM tb_contact_logs l 
                LEFT JOIN tb_users u ON l.user_id = u.user_id 
                WHERE l.contact_id = :contact_id ORDER BY l.id ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['contact_id' => $contactId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllContacts($limit, $offset, $keyword = '', $status = '', $startDate = '', $endDate = '', $department = '') {
        $sql = "SELECT * FROM {$this->table} WHERE 1=1";
        $params = [];

        if (!empty($keyword)) {
            $sql .= " AND (id LIKE :keyword OR phone LIKE :keyword)";
            $params['keyword'] = "%{$keyword}%";
        }

        if ($status !== '') {
            $sql .= " AND status = :status";
            $params['status'] = $status;
        }

        if (!empty($startDate)) {
            $sql .= " AND DATE(created_at) >= :start_date";
            $params['start_date'] = $startDate;
        }

        if (!empty($endDate)) {
            $sql .= " AND DATE(created_at) <= :end_date";
            $params['end_date'] = $endDate;
        }

        if ($department !== '') {
            $sql .= " AND assigned_department = :department";
            $params['department'] = $department;
        }

        $sql .= " ORDER BY id DESC LIMIT :limit OFFSET :offset";
        
        $stmt = $this->pdo->prepare($sql);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countTotalContactsFiltered($keyword = '', $status = '', $startDate = '', $endDate = '', $department = '') {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE 1=1";
        $params = [];

        if (!empty($keyword)) {
            $sql .= " AND (id LIKE :keyword OR phone LIKE :keyword)";
            $params['keyword'] = "%{$keyword}%";
        }

        if ($status !== '') {
            $sql .= " AND status = :status";
            $params['status'] = $status;
        }

        if (!empty($startDate)) {
            $sql .= " AND DATE(created_at) >= :start_date";
            $params['start_date'] = $startDate;
        }

        if (!empty($endDate)) {
            $sql .= " AND DATE(created_at) <= :end_date";
            $params['end_date'] = $endDate;
        }

        if ($department !== '') {
            $sql .= " AND assigned_department = :department";
            $params['department'] = $department;
        }

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();
        return $stmt->fetchColumn() ?? 0;
    }

    public function getContactById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateStatus($id, $status) {
        $sql = "UPDATE {$this->table} SET status = :status WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['status' => $status, 'id' => $id]);
    }

    public function updateDepartment($id, $department) {
        $sql = "UPDATE {$this->table} SET assigned_department = :department WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['department' => $department, 'id' => $id]);
    }
}
