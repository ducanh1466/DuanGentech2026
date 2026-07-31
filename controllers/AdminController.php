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
        $dashboardModel = new DashboardModel();

        // Lấy số liệu thống kê tổng quan từ CSDL
        $totalOrders = $dashboardModel->getTotalOrders();
        $revenue = $dashboardModel->getTotalRevenue();
        $totalProducts = $dashboardModel->getTotalProducts();
        $totalUsers = $dashboardModel->getTotalUsers();

        // Lấy năm đang chọn, mặc định là năm hiện tại
        $selectedYear = $_GET['year'] ?? date('Y');
        $availableYears = [date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1];

        // Lấy 5 đơn hàng mới nhất
        $recentOrders = $dashboardModel->getRecentOrders(5);

        // Lấy dữ liệu doanh thu theo 12 tháng của năm được chọn
        $chartData = json_encode($dashboardModel->getRevenueByMonths($selectedYear));

        $title = 'Dashboard - DGENTECH Admin';
        $pageTitle = 'Dashboard';
        $action = 'admin';
        $view = 'admin/dashboard';
        require_once PATH_VIEW_ADMIN;
    }

    // Chức năng: Quản lý danh mục (Hiển thị danh sách)
    public function categories()
    {
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAllCategories();
        
        $title = 'Quản lý danh mục - DGENTECH Admin';
        $pageTitle = 'Danh mục';
        $action = 'admin-categories';
        $view = 'admin/categories';
        require_once PATH_VIEW_ADMIN;
    }

    // Chức năng: Hiển thị form Thêm/Sửa danh mục
    public function categoryForm()
    {
        $id = $_GET['id'] ?? 0;
        $category = null;
        $isDetail = false;
        
        if ($id) {
            $categoryModel = new CategoryModel();
            $category = $categoryModel->getCategoryById($id);
        }

        $title = ($id ? 'Sửa' : 'Thêm') . ' danh mục - DGENTECH Admin';
        $pageTitle = 'Danh mục';
        $action = 'admin-categories';
        $view = 'admin/category_form';
        require_once PATH_VIEW_ADMIN;
    }

    // Chức năng: Hiển thị form Chi tiết danh mục
    public function categoryDetail()
    {
        $id = $_GET['id'] ?? 0;
        if (!$id) {
            header('Location: ' . BASE_URL . '?action=admin-categories');
            exit;
        }

        $categoryModel = new CategoryModel();
        $category = $categoryModel->getCategoryById($id);
        $isDetail = true;

        $title = 'Chi tiết danh mục - DGENTECH Admin';
        $pageTitle = 'Danh mục';
        $action = 'admin-categories';
        $view = 'admin/category_form';
        require_once PATH_VIEW_ADMIN;
    }

    // Chức năng: Thêm danh mục
    public function categoryCreate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoryModel = new CategoryModel();
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
            header('Location: ' . BASE_URL . '?action=admin-categories');
            exit;
        }
    }

    // Chức năng: Sửa danh mục
    public function categoryUpdate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoryModel = new CategoryModel();
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
            header('Location: ' . BASE_URL . '?action=admin-categories');
            exit;
        }
    }

    // Chức năng: Xóa danh mục
    public function categoryDelete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoryModel = new CategoryModel();
            $id = $_POST['category_id'] ?? 0;
            $categoryModel->deleteCategory($id);
            $_SESSION['success'] = 'Xóa danh mục thành công!';
            header('Location: ' . BASE_URL . '?action=admin-categories');
            exit;
        }
    }
    
    // Chức năng: Hiển thị form Thêm/Sửa thương hiệu
    public function brandForm()
    {
        $id = $_GET['id'] ?? 0;
        $brand = null;
        $isDetail = false;
        
        if ($id) {
            $brandModel = new BrandModel();
            $brand = $brandModel->getBrandById($id);
        }

        $title = ($id ? 'Sửa' : 'Thêm') . ' thương hiệu - DGENTECH Admin';
        $pageTitle = 'Thương hiệu';
        $action = 'admin-brands';
        $view = 'admin/brand_form';
        require_once PATH_VIEW_ADMIN;
    }

    // Chức năng: Hiển thị form Chi tiết thương hiệu
    public function brandDetail()
    {
        $id = $_GET['id'] ?? 0;
        if (!$id) {
            header('Location: ' . BASE_URL . '?action=admin-brands');
            exit;
        }

        $brandModel = new BrandModel();
        $brand = $brandModel->getBrandById($id);
        $isDetail = true;

        $title = 'Chi tiết thương hiệu - DGENTECH Admin';
        $pageTitle = 'Thương hiệu';
        $action = 'admin-brands';
        $view = 'admin/brand_form';
        require_once PATH_VIEW_ADMIN;
    }

    // Chức năng: Hiển thị form Thêm/Sửa thương hiệu
    public function brandForm()
    {
        $id = $_GET['id'] ?? 0;
        $brand = null;
        $isDetail = false;
        
        if ($id) {
            $brandModel = new BrandModel();
            $brand = $brandModel->getBrandById($id);
        }

        $title = ($id ? 'Sửa' : 'Thêm') . ' thương hiệu - DGENTECH Admin';
        $pageTitle = 'Thương hiệu';
        $action = 'admin-brands';
        $view = 'admin/brand_form';
        require_once PATH_VIEW_ADMIN;
    }

    // Chức năng: Hiển thị form Chi tiết thương hiệu
    public function brandDetail()
    {
        $id = $_GET['id'] ?? 0;
        if (!$id) {
            header('Location: ' . BASE_URL . '?action=admin-brands');
            exit;
        }

        $brandModel = new BrandModel();
        $brand = $brandModel->getBrandById($id);
        $isDetail = true;

        $title = 'Chi tiết thương hiệu - DGENTECH Admin';
        $pageTitle = 'Thương hiệu';
        $action = 'admin-brands';
        $view = 'admin/brand_form';
        require_once PATH_VIEW_ADMIN;
    }

    public function products()
    {
        $productModel = new ProductModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action_type = $_POST['action_type'] ?? '';
            if ($action_type === 'delete') {
                $id = $_POST['product_id'] ?? 0;
                $productModel->deleteProduct($id);
                $_SESSION['success'] = 'Xóa sản phẩm thành công!';
            }
            header('Location: ' . BASE_URL . '?action=admin-products');
            exit;
        }

        $products = $productModel->getAllProducts();

        $title = 'Quản lý sản phẩm - DGENTECH Admin';
        $pageTitle = 'Sản phẩm';
        $action = 'admin-products';
        $view = 'admin/products';
        require_once PATH_VIEW_ADMIN;
    }

    // Chức năng: Hiển thị form Thêm/Sửa sản phẩm và xử lý dữ liệu khi submit form
    public function productForm()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();
        $brandModel = new BrandModel();

        $id = $_GET['id'] ?? 0;
        $product = null;

        if ($id) {
            $product = $productModel->getProductById($id);
            $variants = $productModel->getVariantsByProductId($id);
        } else {
            $variants = [];
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category_id = !empty($_POST['category_id']) ? $_POST['category_id'] : null;
            $product_name = trim($_POST['product_name'] ?? '');
            $brand_id = !empty($_POST['brand_id']) ? $_POST['brand_id'] : null;
            $warranty_period = !empty($_POST['warranty_period']) ? $_POST['warranty_period'] : null;
            $description = trim($_POST['description'] ?? '');
            $status = $_POST['status'] ?? 'active';
            $price_raw = $_POST['price'] ?? '0';
            $price = (int) str_replace(['.', ','], '', $price_raw);
            $stock = (int) ($_POST['stock'] ?? 0);

            // Validations
            if (empty($product_name)) {
                $_SESSION['error'] = 'Tên sản phẩm không được để trống!';
                header('Location: ' . BASE_URL . '?action=' . ($id ? 'admin-product-edit&id=' . $id : 'admin-product-create'));
                exit;
            }
            if (mb_strlen($product_name) > 255) {
                $_SESSION['error'] = 'Tên sản phẩm không vượt quá 255 ký tự!';
                header('Location: ' . BASE_URL . '?action=' . ($id ? 'admin-product-edit&id=' . $id : 'admin-product-create'));
                exit;
            }
            if ($price < 0) {
                $_SESSION['error'] = 'Giá sản phẩm phải là số dương!';
                header('Location: ' . BASE_URL . '?action=' . ($id ? 'admin-product-edit&id=' . $id : 'admin-product-create'));
                exit;
            }
            if ($stock < 0) {
                $_SESSION['error'] = 'Số lượng tồn kho không được là số âm!';
                header('Location: ' . BASE_URL . '?action=' . ($id ? 'admin-product-edit&id=' . $id : 'admin-product-create'));
                exit;
            }

            // Handle file upload
            $image_path = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                $file_info = pathinfo($_FILES['image']['name']);
                $extension = strtolower($file_info['extension'] ?? '');
                
                if (!in_array($extension, $allowed_extensions)) {
                    $_SESSION['error'] = 'Định dạng ảnh không hợp lệ (chỉ hỗ trợ JPG, PNG, WEBP, GIF)!';
                    header('Location: ' . BASE_URL . '?action=' . ($id ? 'admin-product-edit&id=' . $id : 'admin-product-create'));
                    exit;
                }

                $upload_dir = 'uploads/products/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                $file_name = time() . '_' . basename($_FILES['image']['name']);
                $target_file = $upload_dir . $file_name;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    $image_path = BASE_URL . $target_file;
                }
            }

            if ($id) {
                // Update
                $productModel->updateProduct($id, $category_id, $product_name, $brand_id, $warranty_period, $description, $status);
                // Also update primary image if uploaded
                if ($image_path) {
                    $productModel->deleteProductImages($id);
                    $productModel->insertProductImage($id, $image_path, 1, 1);
                }
                $_SESSION['success'] = 'Cập nhật sản phẩm thành công!';
            } else {
                // Create
                $id = $productModel->insertProduct($category_id, $product_name, $brand_id, $warranty_period, $description, $status,);
                if ($image_path) {
                    $productModel->insertProductImage($id, $image_path, 1, 1);
                }
                $_SESSION['success'] = 'Thêm sản phẩm thành công!';
            }

            // Process variants
            $variant_names = $_POST['variant_name'] ?? [];
            $variant_ids = $_POST['variant_id'] ?? [];
            $variant_prices = $_POST['variant_price'] ?? [];
            $variant_stocks = $_POST['variant_stock'] ?? [];
            $submitted_variant_names = array_filter(array_map('trim', (array) $variant_names));
            $existing_variants = $id ? $productModel->getVariantsByProductId($id) : [];

            if ($id) {
                // Update mode
                $submitted_ids = [];
                if (!empty($variant_names) && is_array($variant_names)) {
                    for ($i = 0; $i < count($variant_names); $i++) {
                        $v_name = trim($variant_names[$i]);
                        $v_id = $variant_ids[$i] ?? '';
                        $v_price = (isset($variant_prices[$i]) && $variant_prices[$i] !== '') ? (int)$variant_prices[$i] : $price;
                        $v_stock = (isset($variant_stocks[$i]) && $variant_stocks[$i] !== '') ? (int)$variant_stocks[$i] : $stock;

                        if ($v_name !== '') {
                            if (!empty($v_id)) {
                                $productModel->updateVariant($v_id, $v_name, $v_price, $v_stock);
                                $submitted_ids[] = $v_id;
                            } else {
                                $new_id = $productModel->insertVariant($id, $v_name, $v_price, $v_stock);
                                $submitted_ids[] = $new_id;
                            }
                        }
                    }
                }
                $productModel->deleteUnusedVariants($id, $submitted_ids);
            } else {
                // Create mode
                if (!empty($variant_names) && is_array($variant_names)) {
                    for ($i = 0; $i < count($variant_names); $i++) {
                        $v_name = trim($variant_names[$i]);
                        $v_price = (isset($variant_prices[$i]) && $variant_prices[$i] !== '') ? (int)$variant_prices[$i] : $price;
                        $v_stock = (isset($variant_stocks[$i]) && $variant_stocks[$i] !== '') ? (int)$variant_stocks[$i] : $stock;
                        if ($v_name !== '') {
                            $productModel->insertVariant($id, $v_name, $v_price, $v_stock);
                        }
                    }
                }
            }

            if (empty($submitted_variant_names) && empty($existing_variants) && $price > 0) {
                $productModel->insertDefaultVariant($id, $price, $stock);
            }

            header('Location: ' . BASE_URL . '?action=admin-products');
            exit;
        }

        $categories = $categoryModel->getAllCategories();
        $brands = $brandModel->getAllBrands();
        $title = $id ? 'Sửa sản phẩm' : 'Thêm sản phẩm';
        $pageTitle = $title;
        $action = $id ? 'admin-product-edit' : 'admin-product-create';
        $view = 'admin/product_form';
        require_once PATH_VIEW_ADMIN;
    }

    // Chức năng: Quản lý thương hiệu (Hiển thị danh sách)
    public function brands()
    {
        $brandModel = new BrandModel();
        $brands = $brandModel->getAllBrands();

        $title = 'Quản lý thương hiệu - DGENTECH Admin';
        $pageTitle = 'Thương hiệu';
        $action = 'admin-brands';
        $view = 'admin/brands';
        require_once PATH_VIEW_ADMIN;
    }

    // Chức năng: Thêm thương hiệu
    public function brandCreate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $brandModel = new BrandModel();
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $status = $_POST['status'] ?? 1;

            if (empty($name)) {
                $_SESSION['error'] = 'Tên thương hiệu không được để trống!';
            } elseif (mb_strlen($name) > 255) {
                $_SESSION['error'] = 'Tên thương hiệu không được vượt quá 255 ký tự!';
            } else {
                $brandModel->insertBrand($name, $description, $status);
                $_SESSION['success'] = 'Thêm thương hiệu thành công!';
            }
            header('Location: ' . BASE_URL . '?action=admin-brands');
            exit;
        }
    }

    // Chức năng: Sửa thương hiệu
    public function brandUpdate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $brandModel = new BrandModel();
            $id = $_POST['brand_id'] ?? 0;
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $status = $_POST['status'] ?? 1;

            if (empty($name)) {
                $_SESSION['error'] = 'Tên thương hiệu không được để trống!';
            } elseif (mb_strlen($name) > 255) {
                $_SESSION['error'] = 'Tên thương hiệu không được vượt quá 255 ký tự!';
            } else {
                $brandModel->updateBrand($id, $name, $description, $status);
                $_SESSION['success'] = 'Cập nhật thương hiệu thành công!';
            }
            header('Location: ' . BASE_URL . '?action=admin-brands');
            exit;
        }
    }

    // Chức năng: Xóa thương hiệu
    public function brandDelete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $brandModel = new BrandModel();
            $id = $_POST['brand_id'] ?? 0;
            $brandModel->deleteBrand($id);
            $_SESSION['success'] = 'Xóa thương hiệu thành công!';
            header('Location: ' . BASE_URL . '?action=admin-brands');
            exit;
        }
    }
}
