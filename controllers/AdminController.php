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

    // Chức năng: Quản lý danh mục (Hiển thị danh sách, thêm, sửa, xóa danh mục)
    public function categories()
    {
        $categoryModel = new CategoryModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action_type = $_POST['action_type'] ?? 'create';

            if ($action_type === 'create') {
                $name = trim($_POST['name'] ?? '');
                $description = trim($_POST['description'] ?? '');

                if (empty($name)) {
                    $_SESSION['error'] = 'Tên danh mục không được để trống!';
                } elseif (mb_strlen($name) > 255) {
                    $_SESSION['error'] = 'Tên danh mục không được vượt quá 255 ký tự!';
                } else {
                    $categoryModel->insertCategory($name, $description);
                    $_SESSION['success'] = 'Thêm danh mục thành công!';
                }
            } elseif ($action_type === 'update') {
                $id = $_POST['category_id'] ?? 0;
                $name = trim($_POST['name'] ?? '');
                $description = trim($_POST['description'] ?? '');

                if (empty($name)) {
                    $_SESSION['error'] = 'Tên danh mục không được để trống!';
                } elseif (mb_strlen($name) > 255) {
                    $_SESSION['error'] = 'Tên danh mục không được vượt quá 255 ký tự!';
                } else {
                    $categoryModel->updateCategory($id, $name, $description);
                    $_SESSION['success'] = 'Cập nhật danh mục thành công!';
                }
            } elseif ($action_type === 'delete') {
                $id = $_POST['category_id'] ?? 0;
                $categoryModel->deleteCategory($id);
                $_SESSION['success'] = 'Xóa danh mục thành công!';
            }

            header('Location: ' . BASE_URL . '?action=admin-categories');
            exit;
        }

        $categories = $categoryModel->getAllCategories();

        $title = 'Quản lý danh mục - DGENTECH Admin';
        $pageTitle = 'Danh mục';
        $action = 'admin-categories';
        $view = 'admin/categories';
        require_once PATH_VIEW_ADMIN;
    }
}