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

    // Danh sách người dùng
    public function users()
    {
        $userModel = new UserModel();
        $keyword = trim($_GET['keyword'] ?? '');

        if (!empty($keyword)) {
            $users = $userModel->searchUser($keyword);
        } else {
            $users = $userModel->getAllUsers();
        }
        $title = 'Quản lý người dùng';
        $pageTitle = 'Quản lý người dùng';
        $action = 'admin-users';
        $view = 'admin/users';
        require_once PATH_VIEW_ADMIN;
    }

    // Hiển thị form thêm
    public function createUser()
    {
        $user = null;

        $title = 'Thêm người dùng';
        $pageTitle = 'Thêm người dùng';
        $action = 'admin-user-create';
        $view = 'admin/user_form';

        require_once PATH_VIEW_ADMIN;
    }

    // Xử lý thêm
    public function storeUser()
    {
        $userModel = new UserModel();

        $full_name = trim($_POST['full_name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $address = trim($_POST['address']);
        $role = $_POST['role'];
        $status = $_POST['status'];
        $password = $_POST['password'];
        if (empty($full_name)) {
            $_SESSION['error'] = 'Họ tên không được để trống!';
        } elseif (mb_strlen($full_name) > 100) {
            $_SESSION['error'] = 'Họ tên tối đa 100 ký tự!';
        } elseif (empty($email)) {
            $_SESSION['error'] = 'Email không được để trống!';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Email không đúng định dạng!';
        } elseif ($userModel->checkEmail($email)) {
            $_SESSION['error'] = 'Email đã tồn tại!';
        } elseif (empty($phone)) {
            $_SESSION['error'] = 'Số điện thoại không được để trống!';
        } elseif (!preg_match('/^0\d{9}$/', $phone)) {
            $_SESSION['error'] = 'Số điện thoại phải bắt đầu bằng số 0 và đủ 10 số!';
        } elseif (empty($password)) {
            $_SESSION['error'] = 'Mật khẩu không được để trống!';
        }
        if (!empty($_SESSION['error'])) {
            header('Location: ' . BASE_URL . '?action=admin-user-create');
            exit;
        }
        $password = password_hash($password, PASSWORD_DEFAULT);
        $userModel->insertUser(
            $full_name,
            $email,
            $password,
            $phone,
            $address,
            $role,
            $status
        );
        $_SESSION['success'] = 'Thêm người dùng thành công!';
        header('Location: ' . BASE_URL . '?action=admin-users');
        exit;
    }

    // Hiển thị form sửa
    public function editUser()
    {
        $userModel = new UserModel();
        $id = $_GET['id'] ?? 0;
        $user = $userModel->getUserById($id);
        if (!$user) {
            $_SESSION['error'] = 'Người dùng không tồn tại!';
            header('Location: ' . BASE_URL . '?action=admin-users');
            exit;
        }
        $title = 'Cập nhật người dùng';
        $pageTitle = 'Cập nhật người dùng';
        $action = 'admin-user-edit';
        $view = 'admin/user_form';
        require_once PATH_VIEW_ADMIN;
    }

    // Xử lý cập nhật
    public function updateUser()
    {
        $userModel = new UserModel();
        $id = $_GET['id'] ?? 0;
        $full_name = trim($_POST['full_name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $address = trim($_POST['address']);
        $role = $_POST['role'];
        $status = $_POST['status'];
        if (empty($full_name)) {
            $_SESSION['error'] = 'Họ tên không được để trống!';
        } elseif (mb_strlen($full_name) > 100) {
            $_SESSION['error'] = 'Họ tên tối đa 100 ký tự!';
        } elseif (empty($email)) {
            $_SESSION['error'] = 'Email không được để trống!';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Email không đúng định dạng!';
        } elseif ($userModel->checkEmailUpdate($email, $id)) {
            $_SESSION['error'] = 'Email đã tồn tại!';
        } elseif (empty($phone)) {
            $_SESSION['error'] = 'Số điện thoại không được để trống!';
        } elseif (!preg_match('/^0\d{9}$/', $phone)) {
            $_SESSION['error'] = 'Số điện thoại phải bắt đầu bằng số 0 và đủ 10 số!';
        }
        if (!empty($_SESSION['error'])) {
            header('Location: ' . BASE_URL . '?action=admin-user-edit&id=' . $id);
            exit;
        }
        $userModel->updateUser(
            $id,
            $full_name,
            $email,
            $phone,
            $address,
            $role,
            $status
        );
        $_SESSION['success'] = 'Cập nhật người dùng thành công!';
        header('Location: ' . BASE_URL . '?action=admin-users');
        exit;
    }

    // Khóa / Mở khóa tài khoản
    public function changeUserStatus()
    {
        $userModel = new UserModel();
        $id = $_GET['id'] ?? 0;
        $status = $_GET['status'] ?? 1;
        $userModel->changeStatus($id, $status);
        if ($status == 0) {
            $_SESSION['success'] = 'Đã khóa tài khoản thành công!';
        } else {
            $_SESSION['success'] = 'Đã mở khóa tài khoản thành công!';
        }
        header('Location: ' . BASE_URL . '?action=admin-users');
        exit;
    }
    
    // Xóa người dùng
    public function deleteUser()
    {
        $userModel = new UserModel();
        $id = $_GET['id'] ?? 0;
        $userModel->deleteUser($id);
        $_SESSION['success'] = 'Xóa người dùng thành công!';
        header('Location: ' . BASE_URL . '?action=admin-users');
        exit;
    }
}
