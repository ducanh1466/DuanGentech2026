<?php
class UserModel extends BaseModel
{
    // Đếm tổng số người dùng (Dashboard)
    public function countTotalUsers()
    {
        $sql = "SELECT COUNT(*) FROM tb_users";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    // Lấy tất cả người dùng (hỗ trợ tìm kiếm)
    public function getAllUsers($keyword = '', $limit = 0, $offset = 0, $status = '')
    {
        $sql = "SELECT * FROM tb_users";
        $params = [];
        if ($status !== '') {
            $sql .= " WHERE role = :status";
            $params['status'] = $status;
        }
        
        return $this->fetchWithPagination(
            $sql,
            $params,
            ['full_name', 'email', 'phone'],
            $keyword,
            "user_id DESC",
            $limit,
            $offset
        );
    }

    public function countTotalUsersFiltered($keyword = '', $status = '')
    {
        $sql = "SELECT COUNT(*) as total FROM tb_users";
        $params = [];
        if ($status !== '') {
            $sql .= " WHERE role = :status";
            $params['status'] = $status;
        }

        return $this->countTotalFiltered(
            $sql,
            $params,
            ['full_name', 'email', 'phone'],
            $keyword
        );
    }
    // Lấy thông tin 1 người dùng
    public function getUserById($id)
    {
        $sql = "SELECT *
                FROM tb_users
                WHERE user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Thêm người dùng
    public function insertUser(
        $full_name,
        $email,
        $password,
        $phone,
        $address,
        $role,
        $status,
        $permissions = null
    ) {
        $sql = "INSERT INTO tb_users
                (
                    full_name,
                    email,
                    password,
                    phone,
                    address,
                    role,
                    status,
                    permissions,
                    registered_at
                )
                VALUES
                (
                    ?,?,?,?,?,?,?,?,NOW()
                )";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $full_name,
            $email,
            $password,
            $phone,
            $address,
            $role,
            $status,
            $permissions
        ]);
    }
    // Cập nhật người dùng
    public function updateUser(
        $id,
        $full_name,
        $email,
        $phone,
        $address,
        $role,
        $status,
        $permissions = null
    ) {
        $sql = "UPDATE tb_users
                SET
                full_name = ?,
                email = ?,
                phone = ?,
                address = ?,
                role = ?,
                status = ?,
                permissions = ?
                WHERE user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $full_name,
            $email,
            $phone,
            $address,
            $role,
            $status,
            $permissions,
            $id
        ]);
    }

    // Cập nhật profile từ Checkout
    public function updateUserCheckoutProfile($id, $full_name, $phone, $address)
    {
        $sql = "UPDATE tb_users
                SET
                full_name = ?,
                phone = ?,
                address = ?
                WHERE user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $full_name,
            $phone,
            $address,
            $id
        ]);
    }
    // Xóa người dùng
    public function deleteUser($id)
    {
        $sql = "DELETE FROM tb_users
                WHERE user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
    // Tìm kiếm người dùng
    public function searchUser($keyword)
    {
        $sql = "SELECT *
                FROM tb_users
                WHERE
                full_name LIKE ?
                OR
                email LIKE ?
                OR
                phone LIKE ?
                ORDER BY user_id DESC";
        $stmt = $this->pdo->prepare($sql);
        $keyword = "%{$keyword}%";
        $stmt->execute([
            $keyword,
            $keyword,
            $keyword
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Khóa hoặc mở khóa tài khoản
    public function changeStatus($id, $status)
    {
        $sql = "UPDATE tb_users
                SET status = ?
                WHERE user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $status,
            $id
        ]);
    }
    // Kiểm tra email đã tồn tại chưa
    public function checkEmail($email)
    {
        $sql = "SELECT *
                FROM tb_users
                WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Kiểm tra email khi cập nhật
    public function checkEmailUpdate($email, $id)
    {
        $sql = "SELECT *
                FROM tb_users
                WHERE email = ?
                AND user_id <> ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $email,
            $id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM tb_users WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function updateProfile($id, $full_name, $phone, $address)
    {
        $sql = "UPDATE tb_users SET full_name = ?, phone = ?, address = ? WHERE user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$full_name, $phone, $address, $id]);
    }

    public function updatePassword($id, $password)
    {
        $sql = "UPDATE tb_users SET password = ? WHERE user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$password, $id]);
    }
}