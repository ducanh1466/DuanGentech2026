<?php

class AdminController
{

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user'])) {
            $_SESSION['user'] = [
                'role' => 1,
                'full_name' => 'Admin Test',
                'email' => 'admin@dgentech.vn'
            ];
        }
    }

    public function dashboard()
    {
        $title = 'Dashboard - DGENTECH Admin';
        $pageTitle = 'Dashboard';
        $action = 'admin';
        $view = 'admin/dashboard';
        require_once PATH_VIEW_ADMIN;
    }

    // Chức năng: Hiển thị danh sách người dùng và xử lý cập nhật thông tin người dùng từ model
    public function users()
    {
        // Chỉ admin chính (role 1) mới được quản lý tài khoản người dùngg
        if ($_SESSION['user']['role'] != 1) {
            header('Location: ' . BASE_URL . '?action=admin-products');
            exit;
        }
        $userModel = new UserModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action_type = $_POST['action_type'] ?? '';
            $user_id = $_POST['user_id'] ?? 0;

            if ($action_type === 'update_user') {
                $status = $_POST['status'] ?? 0;
                $role = $_POST['role'] ?? 0;
                $full_name = trim($_POST['full_name'] ?? '');
                $phone = trim($_POST['phone'] ?? '');
                $address = trim($_POST['address'] ?? '');
                $password = $_POST['new_password'] ?? '';

                if (empty($full_name)) {
                    $_SESSION['error'] = 'Họ tên không được để trống!';
                } elseif (mb_strlen($full_name) > 50) {
                    $_SESSION['error'] = 'Họ tên không được vượt quá 50 ký tự!';
                } elseif (!preg_match('/^[0-9]{10,11}$/', $phone)) {
                    $_SESSION['error'] = 'Số điện thoại không hợp lệ (phải gồm 10-11 chữ số)!';
                } elseif (!empty($password) && mb_strlen($password) < 6) {
                    $_SESSION['error'] = 'Mật khẩu mới phải dài ít nhất 6 ký tự!';
                } else {
                    $user = $userModel->getUserById($user_id);
                    if ($user) {
                        $userModel->updateUser($user_id, $full_name, $phone, $address, $status, $role);
                        if (!empty($password)) {
                            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                            $userModel->updatePassword($user_id, $hashed_password);
                        }
                        $_SESSION['success'] = 'Cập nhật người dùng thành công!';
                    }
                }
            }

            header('Location: ' . BASE_URL . '?action=admin-users');
            exit;
        }

        $users = $userModel->getAllUsers();

        $title = 'Quản lý người dùng - DGENTECH Admin';
        $pageTitle = 'Người dùng';
        $action = 'admin-users';
        $view = 'admin/users';
        require_once PATH_VIEW_ADMIN;
    }

    // Chức năng: Hiển thị form sửa thông tin người dùng và lưu dữ liệu (trang riêng biệt)
    public function userForm()
    {
        // Kiểm tra quyền
        if ($_SESSION['user']['role'] != 1) {
            header('Location: ' . BASE_URL . '?action=admin-products');
            exit;
        }

        $userModel = new UserModel();
        $id = $_GET['id'] ?? 0;
        
        if (!$id) {
            // Only editing is supported right now, redirect back if no ID
            header('Location: ' . BASE_URL . '?action=admin-users');
            exit;
        }

        $user = $userModel->getUserById($id);
        if (!$user) {
            header('Location: ' . BASE_URL . '?action=admin-users');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'] ?? 0;
            $role = $_POST['role'] ?? 0;
            $full_name = $_POST['full_name'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            $password = $_POST['new_password'] ?? '';

            $userModel->updateUser($id, $full_name, $phone, $address, $status, $role);
            if (!empty($password)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $userModel->updatePassword($id, $hashed_password);
            }
            $_SESSION['success'] = 'Cập nhật người dùng thành công!';
            header('Location: ' . BASE_URL . '?action=admin-users');
            exit;
        }

        $title = 'Sửa người dùng - DGENTECH Admin';
        $pageTitle = 'Sửa người dùng';
        $action = 'admin-user-edit';
        $view = 'admin/user_form';
        require_once PATH_VIEW_ADMIN;
    }
}