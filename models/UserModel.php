<?php

class UserModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'tb_users';
    }

    // Lấy danh sách tất cả tài khoản người dùng
    public function getAllUsers()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY user_id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Đếm tổng số tài khoản (Dùng cho thống kê Dashboard)
    public function countTotalUsers()
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetch()['total'] ?? 0;
    }

    // Lấy chi tiết thông tin của một người dùng theo ID
    public function getUserById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE user_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // Tìm kiếm một tài khoản dựa trên Email (Dùng rất nhiều trong phần Đăng nhập, Đăng ký)
    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    // Tạo mới/Đăng ký một người dùng vào CSDL
    public function insertUser($full_name, $email, $password, $phone = null, $address = null, $role = 0, $status = 1)
    {
        $sql = "INSERT INTO {$this->table} (full_name, email, password, phone, address, role, status) 
                VALUES (:full_name, :email, :password, :phone, :address, :role, :status)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'full_name' => $full_name,
            'email' => $email,
            'password' => $password, // remember to hash this before calling
            'phone' => $phone,
            'address' => $address,
            'role' => $role,
            'status' => $status
        ]);
    }

    // Cập nhật thông tin cá nhân hoặc quyền (role), trạng thái (status) của người dùng
    public function updateUser($id, $full_name, $phone, $address, $status, $role)
    {
        $sql = "UPDATE {$this->table} 
                SET full_name = :full_name, phone = :phone, address = :address, status = :status, role = :role 
                WHERE user_id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'full_name' => $full_name,
            'phone' => $phone,
            'address' => $address,
            'status' => $status,
            'role' => $role
        ]);
    }

    // Cập nhật mật khẩu mới cho người dùng
    public function updatePassword($id, $new_password)
    {
        $sql = "UPDATE {$this->table} SET password = :password WHERE user_id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'password' => $new_password,
            'id' => $id
        ]);
    }

    // Xóa hoàn toàn một tài khoản người dùng
    public function deleteUser($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE user_id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
