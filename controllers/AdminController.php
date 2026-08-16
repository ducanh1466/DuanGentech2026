<?php

class AdminController
{

     public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Kiểm tra xem đã đăng nhập chưa và có quyền vào admin không (role 1, 2, 3, 4)
        if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], [1, 2, 3, 4])) {
            header("Location: ?act=login");
            exit();
        }

        $action = $_GET['action'] ?? 'admin';
        $role = $_SESSION['user']['role'];
        
        // Luôn cho phép các hành động chung
        $common_allowed = [
            'admin', 'admin-profile', 'admin-update-profile', 'admin-change-password', 'admin-update-password'
        ];
        if (in_array($action, $common_allowed)) {
            return;
        }

        // CNTT (role 1) full quyền
        if ($role == 1) {
            return;
        }

        // Lấy danh sách quyền từ session
        $permissionsStr = $_SESSION['user']['permissions'] ?? '[]';
        $permissions = json_decode($permissionsStr, true);
        if (!is_array($permissions)) {
            $permissions = [];
        }

        $is_allowed = false;
        
        // Kiểm tra quyền theo từng module
        if (in_array('products', $permissions)) {
            $allowed_product = ['admin-products', 'admin-product-create', 'admin-product-store', 'admin-product-edit', 'admin-product-update', 'admin-product-delete', 'admin-product-toggle'];
            if (in_array($action, $allowed_product)) $is_allowed = true;
        }
        if (in_array('categories', $permissions)) {
            $allowed_category = ['admin-categories', 'admin-category-form', 'admin-category-store', 'admin-category-update', 'admin-category-delete', 'admin-category-status'];
            if (in_array($action, $allowed_category)) $is_allowed = true;
        }
        if (in_array('brands', $permissions)) {
            $allowed_brand = ['admin-brands', 'admin-brand-form', 'admin-brand-store', 'admin-brand-update', 'admin-brand-delete', 'admin-brand-status'];
            if (in_array($action, $allowed_brand)) $is_allowed = true;
        }
        if (in_array('attributes', $permissions)) {
            $allowed_attribute = ['admin-attributes', 'admin-attribute-create', 'admin-attribute-store', 'admin-attribute-edit', 'admin-attribute-update', 'admin-attribute-delete'];
            if (in_array($action, $allowed_attribute)) $is_allowed = true;
        }
        if (in_array('orders', $permissions)) {
            $allowed_order = ['admin-orders', 'admin-order-detail'];
            if (in_array($action, $allowed_order)) $is_allowed = true;
        }
        if (in_array('contacts', $permissions)) {
            $allowed_contact = ['admin-contacts', 'admin-contact-status', 'admin-contact-department', 'admin-contact-bulk', 'admin-contact-logs'];
            if (in_array($action, $allowed_contact)) $is_allowed = true;
        }
        if (in_array('news', $permissions)) {
            $allowed_news = ['admin-news', 'admin-news-form', 'admin-news-store', 'admin-news-update', 'admin-news-delete', 'admin-news-status',
                             'admin-news-categories', 'admin-news-category-form', 'admin-news-category-store', 'admin-news-category-update', 'admin-news-category-delete', 'admin-news-category-status'];
            if (in_array($action, $allowed_news)) $is_allowed = true;
        }
        if (in_array('banners', $permissions)) {
            $allowed_banner = ['admin-banners', 'admin-banner-form', 'admin-banner-store', 'admin-banner-update', 'admin-banner-delete', 'admin-banner-status'];
            if (in_array($action, $allowed_banner)) $is_allowed = true;
        }

        if (!$is_allowed) {
            header("Location: " . BASE_URL . "?action=admin");
            exit();
        }
    }

    private function getPaginationParams()
    {
        $keyword = trim($_GET['keyword'] ?? '');
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        if ($page < 1)
            $page = 1;
        $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 10;
        if (!in_array($limit, [10, 20, 50, 100])) {
            $limit = 10;
        }
        $offset = ($page - 1) * $limit;
        return [$keyword, $page, $limit, $offset];
    }

    public function dashboard()
    {
        $dashboardModel = new DashboardModel();

        // TEMPORARY DB UPGRADE TO SUPPORT BILLIONS (BIGINT)
        try {
            $pdo = $dashboardModel->getPdo();
            if ($pdo) {
                $pdo->exec("ALTER TABLE tb_orders MODIFY total_amount BIGINT");
                $pdo->exec("ALTER TABLE tb_products MODIFY price BIGINT");
                $pdo->exec("ALTER TABLE tb_product_variants MODIFY price BIGINT");
            }
        } catch (\Exception $e) {
        }

        // Xử lý bộ lọc thời gian
        $dateFilter = $_GET['date_filter'] ?? 'all';
        $startDate = null;
        $endDate = null;
        $prevStartDate = null;
        $prevEndDate = null;
        $trendText = '';

        switch ($dateFilter) {
            case 'today':
                $startDate = date('Y-m-d');
                $endDate = date('Y-m-d');
                $prevStartDate = date('Y-m-d', strtotime('-1 day'));
                $prevEndDate = date('Y-m-d', strtotime('-1 day'));
                $trendText = 'so với hôm qua';
                break;
            case 'this_week':
                $startDate = date('Y-m-d', strtotime('monday this week'));
                $endDate = date('Y-m-d', strtotime('sunday this week'));
                $prevStartDate = date('Y-m-d', strtotime('monday last week'));
                $prevEndDate = date('Y-m-d', strtotime('sunday last week'));
                $trendText = 'so với tuần trước';
                break;
            case 'this_month':
                $startDate = date('Y-m-01');
                $endDate = date('Y-m-t');
                $prevStartDate = date('Y-m-01', strtotime('first day of last month'));
                $prevEndDate = date('Y-m-t', strtotime('last day of last month'));
                $trendText = 'so với tháng trước';
                break;
            case 'this_year':
                $startDate = date('Y-01-01');
                $endDate = date('Y-12-31');
                $prevStartDate = date('Y-01-01', strtotime('-1 year'));
                $prevEndDate = date('Y-12-31', strtotime('-1 year'));
                $trendText = 'so với năm trước';
                break;
            default:
                $trendText = 'từ trước tới nay';
                break;
        }

        // Hàm tính phần trăm thay đổi
        $calculateTrend = function($current, $previous) {
            if ($previous == 0) {
                return $current > 0 ? 100 : 0;
            }
            return (($current - $previous) / $previous) * 100;
        };

        // Lấy số liệu thống kê tổng quan từ CSDL (có lọc thời gian)
        $totalOrders = $dashboardModel->getTotalOrders($startDate, $endDate);
        $revenue = $dashboardModel->getTotalRevenue($startDate, $endDate);
        $totalProducts = $dashboardModel->getTotalProducts($startDate, $endDate);
        $totalUsers = $dashboardModel->getTotalUsers($startDate, $endDate);

        // Tính số liệu kỳ trước
        $prevOrders = 0;
        $prevRevenue = 0;
        $prevProducts = 0;
        $prevUsers = 0;

        if ($dateFilter != 'all') {
            $prevOrders = $dashboardModel->getTotalOrders($prevStartDate, $prevEndDate);
            $prevRevenue = $dashboardModel->getTotalRevenue($prevStartDate, $prevEndDate);
            $prevProducts = $dashboardModel->getTotalProducts($prevStartDate, $prevEndDate);
            $prevUsers = $dashboardModel->getTotalUsers($prevStartDate, $prevEndDate);
        }

        $trendOrders = $calculateTrend($totalOrders, $prevOrders);
        $trendRevenue = $calculateTrend($revenue, $prevRevenue);
        $trendProducts = $calculateTrend($totalProducts, $prevProducts);
        $trendUsers = $calculateTrend($totalUsers, $prevUsers);

        // Lấy năm đang chọn, mặc định là năm hiện tại
        $selectedYear = $_GET['year'] ?? date('Y');
        $availableYears = [date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1];

        // Lấy 5 đơn hàng mới nhất
        $recentOrders = $dashboardModel->getRecentOrders(5);

        // Lấy dữ liệu doanh thu theo 12 tháng của năm được chọn
        $chartData = json_encode($dashboardModel->getRevenueByMonths($selectedYear));

        // Lấy dữ liệu mới cho bản nâng cấp (Top Bán Chạy cũng bị lọc)
        $topSellingProducts = $dashboardModel->getTopSellingProducts(5, $startDate, $endDate);
        $lowStockProducts = $dashboardModel->getLowStockProducts(5, 10);
        $orderStatusData = json_encode($dashboardModel->getOrdersByStatus());
        
        // Khối cảnh báo
        $alerts = $dashboardModel->getPendingAlerts();

        // Khách hàng VIP và Doanh thu theo danh mục
        $topVIPCustomers = $dashboardModel->getTopVIPCustomers(5, $startDate, $endDate);
        $salesByCategoryData = json_encode($dashboardModel->getSalesByCategory($startDate, $endDate));

        $title = 'Dashboard - DGENTECH Admin';
        $pageTitle = 'Dashboard';
        $action = 'admin';
        $view = 'admin/dashboard';
        require_once PATH_VIEW_ADMIN;
    }

    // ------------------------------------------------------------------------
    // INVENTORY MANAGEMENT (QUẢN LÝ KHO)
    // ------------------------------------------------------------------------

    public function inventory()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        list($keyword, $page, $limit, $offset) = $this->getPaginationParams();
        $stockFilter = $_GET['stock_filter'] ?? '';
        $category_id = $_GET['category_id'] ?? null;

        $inventory = $productModel->getAllInventory($keyword, $limit, $offset, $stockFilter, $category_id);
        $totalRecords = $productModel->countInventory($keyword, $stockFilter, $category_id);
        $totalPages = ceil($totalRecords / $limit);

        // Lấy danh sách danh mục để hiển thị ở bộ lọc
        $categories = $categoryModel->getAllCategories();

        $title = 'Quản lý Kho - DGENTECH Admin';
        $pageTitle = 'Quản lý Kho';
        $action = 'admin-inventory';
        $view = 'admin/inventory';
        require_once PATH_VIEW_ADMIN;
    }

    public function updateStockQuick()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $variant_id = $_POST['variant_id'] ?? 0;
            $stock = $_POST['stock'] ?? 0;

            if ($variant_id > 0 && $stock >= 0) {
                $productModel = new ProductModel();
                $success = $productModel->updateStockQuick($variant_id, $stock);
                if ($success) {
                    echo json_encode(['success' => true, 'message' => 'Cập nhật thành công']);
                    exit;
                }
            }
            echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
            exit;
        }
    }

    // Chức năng: Quản lý danh mục (Hiển thị danh sách)
    public function categories()
    {
        $categoryModel = new CategoryModel();
        list($keyword, $page, $limit, $offset) = $this->getPaginationParams();

        $categories = $categoryModel->getAllCategories($keyword, $limit, $offset);
        $totalRecords = $categoryModel->countTotalCategories($keyword);
        $totalPages = ceil($totalRecords / $limit);

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
            $image = null; // Default image

            // Handle Image Upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = 'assets/uploads/categories/';
                if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
                $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $file_name = uniqid() . '.' . $file_extension;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $file_name)) {
                    $image = $file_name;
                }
            }

            if (empty($name)) {
                $_SESSION['error'] = 'Tên danh mục không được để trống!';
            } elseif (mb_strlen($name) > 255) {
                $_SESSION['error'] = 'Tên danh mục không được vượt quá 255 ký tự!';
            } else {
                $categoryModel->insertCategory($name, $description, $image);
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
            
            // Get existing category to keep old image if no new one is uploaded
            $existingCat = $categoryModel->getCategoryById($id);
            $image = $existingCat['icon'] ?? null; // using the same column name 'icon' to avoid db re-alter if possible, but let's assume it's 'icon' or 'image'. We will use 'icon' column to store image filename so we don't need to change DB again if it was already created.

            // Handle Image Upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = 'assets/uploads/categories/';
                if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
                $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $file_name = uniqid() . '.' . $file_extension;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $file_name)) {
                    $image = $file_name;
                }
            }

            if (empty($name)) {
                $_SESSION['error'] = 'Tên danh mục không được để trống!';
            } elseif (mb_strlen($name) > 255) {
                $_SESSION['error'] = 'Tên danh mục không được vượt quá 255 ký tự!';
            } else {
                $categoryModel->updateCategory($id, $name, $description, $image);
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
            try {
                $categoryModel->deleteCategory($id);
                $_SESSION['success'] = 'Xóa danh mục thành công!';
            } catch (\PDOException $e) {
                if ($e->getCode() == '23000') {
                    $_SESSION['error'] = 'Không thể xóa danh mục này vì vẫn còn sản phẩm thuộc danh mục!';
                } else {
                    $_SESSION['error'] = 'Có lỗi xảy ra khi xóa danh mục!';
                }
            }
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



    public function products()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();
        
        list($keyword, $page, $limit, $offset) = $this->getPaginationParams();
        $status = $_GET['status'] ?? '';
        $category_id = $_GET['category_id'] ?? null;

        $products = $productModel->getAllProducts($keyword, $limit, $offset, $status, $category_id);
        $totalRecords = $productModel->countTotalProductsFiltered($keyword, $status, $category_id);
        $totalPages = ceil($totalRecords / $limit);

        // Lấy danh sách danh mục để hiển thị ở bộ lọc
        $categories = $categoryModel->getAllCategories();

        $title = 'Quản lý sản phẩm - DGENTECH Admin';
        $pageTitle = 'Sản phẩm';
        $action = 'admin-products';
        $view = 'admin/products';

        require_once PATH_VIEW_ADMIN;
    }

    // Chức năng: Thêm sản phẩm
    public function createProduct()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();
        $brandModel = new BrandModel();
        require_once PATH_MODEL . 'AttributeModel.php';
        $attrModel = new AttributeModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category_id = $_POST['category_id'] ?? null;
            $product_name = trim($_POST['product_name'] ?? '');
            $brand_id = $_POST['brand_id'] ?? null;
            $warranty_period = !empty($_POST['warranty_period']) ? (int) $_POST['warranty_period'] : null;
            $description = trim($_POST['description'] ?? '');
            $status = $_POST['status'] ?? 'active';
            $price = (float) str_replace(['.', ','], '', $_POST['price'] ?? 0);
            $stock = (int) ($_POST['stock'] ?? 0);

            if (empty($product_name)) {
                $_SESSION['error'] = 'Tên sản phẩm không được để trống!';
                header('Location: ' . BASE_URL . '?action=admin-product-create');
                exit;
            }

            // Thêm sản phẩm
            $id = $productModel->insertProduct($category_id, $product_name, $brand_id, $price, $warranty_period, $description, $status);

            // Upload ảnh chính
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = 'uploads/products/';
                if (!is_dir($upload_dir))
                    mkdir($upload_dir, 0777, true);
                $file_name = time() . '_' . basename($_FILES['image']['name']);
                $target_file = $upload_dir . $file_name;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    $productModel->insertProductImage($id, BASE_URL . $target_file, 1, 1);
                }
            }

            // Upload ảnh phụ (gallery)
            if (isset($_FILES['gallery_images']) && !empty($_FILES['gallery_images']['name'][0])) {
                $upload_dir = 'uploads/products/';
                if (!is_dir($upload_dir))
                    mkdir($upload_dir, 0777, true);

                $galleryCount = count($_FILES['gallery_images']['name']);
                for ($i = 0; $i < $galleryCount; $i++) {
                    if ($_FILES['gallery_images']['error'][$i] === UPLOAD_ERR_OK) {
                        $file_name = time() . '_gallery_' . $i . '_' . basename($_FILES['gallery_images']['name'][$i]);
                        $target_file = $upload_dir . $file_name;
                        if (move_uploaded_file($_FILES['gallery_images']['tmp_name'][$i], $target_file)) {
                            // is_primary = 0, display_order = $i + 2
                            $productModel->insertProductImage($id, BASE_URL . $target_file, $i + 2, 0);
                        }
                    }
                }
            }

            // Xử lý Specs (Thông số kỹ thuật)
            $spec_names = $_POST['spec_name'] ?? [];
            $spec_values = $_POST['spec_value'] ?? [];
            foreach ($spec_names as $i => $sname) {
                $sname = trim($sname);
                $sval = trim($spec_values[$i] ?? '');
                if (!empty($sname) && !empty($sval)) {
                    $productModel->insertProductSpec($id, $sname, $sval);
                }
            }

            // Xử lý Biến thể (Variants)
            $variant_names = $_POST['variant_name'] ?? [];
            $variant_prices = $_POST['variant_price'] ?? [];
            $variant_stocks = $_POST['variant_stock'] ?? [];
            $variant_skus = $_POST['variant_sku'] ?? [];
            $variant_attr_ids = $_POST['variant_attr_ids'] ?? [];

            if (empty($variant_names) || empty(trim($variant_names[0] ?? ''))) {
                // Nếu không có biến thể nào được nhập, tạo biến thể mặc định
                $productModel->insertDefaultVariant($id, $price, $stock);
            } else {
                foreach ($variant_names as $i => $name) {
                    $name = trim($name);
                    if ($name != '') {
                        $v_price = (float) str_replace(['.', ','], '', $variant_prices[$i] ?? $price);
                        $v_stock = (int) ($variant_stocks[$i] ?? 0);
                        $v_sku = trim($variant_skus[$i] ?? '');

                        $vid = $productModel->insertVariant($id, $name, $v_price, $v_stock, $v_sku);

                        // Xử lý liên kết thuộc tính
                        if (!empty($variant_attr_ids[$i])) {
                            $attrs = explode(',', $variant_attr_ids[$i]);
                            foreach ($attrs as $attr_val_id) {
                                $productModel->insertVariantAttribute($vid, trim($attr_val_id));
                            }
                        }
                    }
                }
            }

            $_SESSION['success'] = 'Thêm sản phẩm thành công!';
            header('Location: ' . BASE_URL . '?action=admin-products');
            exit;
        }

        $categories = $categoryModel->getAllCategories();
        $brands = $brandModel->getAllBrands();
        $all_attributes = $attrModel->getAllAttributesWithValues();
        $specs = [];

        $title = 'Thêm sản phẩm - DGENTECH Admin';
        $pageTitle = 'Thêm sản phẩm';
        $action = 'admin-product-create';
        $view = 'admin/product_form';
        require_once PATH_VIEW_ADMIN;
    }

    // Chức năng: sửa sản phẩm
    public function editProduct()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();
        $brandModel = new BrandModel();
        require_once PATH_MODEL . 'AttributeModel.php';
        $attrModel = new AttributeModel();

        $id = $_GET['id'] ?? 0;
        $product = $productModel->getProductById($id);
        $variants = $productModel->getVariantsByProductId($id);
        $specs = $productModel->getProductSpecs($id);

        // Lấy danh sách ảnh phụ
        $all_images = $productModel->getProductImages($id);
        $gallery_images = array_filter($all_images, function ($img) {
            return $img['is_primary'] == 0;
        });

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category_id = $_POST['category_id'] ?? null;
            $product_name = trim($_POST['product_name'] ?? '');
            $brand_id = $_POST['brand_id'] ?? null;
            $warranty_period = !empty($_POST['warranty_period']) ? (int) $_POST['warranty_period'] : null;
            $description = trim($_POST['description'] ?? '');
            $status = $_POST['status'] ?? 'active';
            $price = (float) str_replace(['.', ','], '', $_POST['price'] ?? 0);
            $stock = (int) ($_POST['stock'] ?? 0);

            $productModel->updateProduct($id, $category_id, $product_name, $brand_id, $price, $warranty_period, $description, $status);

            // Upload ảnh mới (nếu có)
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = 'uploads/products/';
                if (!is_dir($upload_dir))
                    mkdir($upload_dir, 0777, true);
                $file_name = time() . '_' . basename($_FILES['image']['name']);
                $target_file = $upload_dir . $file_name;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    $productModel->deletePrimaryImage($id);
                    $productModel->insertProductImage($id, BASE_URL . $target_file, 1, 1);
                }
            }

            // Xử lý Upload ảnh phụ mới (nếu người dùng chọn upload thêm ảnh phụ, sẽ ghi đè ảnh phụ cũ)
            if (isset($_FILES['gallery_images']) && !empty($_FILES['gallery_images']['name'][0])) {
                $upload_dir = 'uploads/products/';
                if (!is_dir($upload_dir))
                    mkdir($upload_dir, 0777, true);

                // Xóa toàn bộ ảnh phụ cũ
                $productModel->deleteGalleryImages($id);

                $galleryCount = count($_FILES['gallery_images']['name']);
                for ($i = 0; $i < $galleryCount; $i++) {
                    if ($_FILES['gallery_images']['error'][$i] === UPLOAD_ERR_OK) {
                        $file_name = time() . '_gallery_' . $i . '_' . basename($_FILES['gallery_images']['name'][$i]);
                        $target_file = $upload_dir . $file_name;
                        if (move_uploaded_file($_FILES['gallery_images']['tmp_name'][$i], $target_file)) {
                            $productModel->insertProductImage($id, BASE_URL . $target_file, $i + 2, 0);
                        }
                    }
                }
            }

            // Xử lý Specs (Thông số kỹ thuật)
            $productModel->deleteProductSpecs($id);
            $spec_names = $_POST['spec_name'] ?? [];
            $spec_values = $_POST['spec_value'] ?? [];
            foreach ($spec_names as $i => $sname) {
                $sname = trim($sname);
                $sval = trim($spec_values[$i] ?? '');
                if (!empty($sname) && !empty($sval)) {
                    $productModel->insertProductSpec($id, $sname, $sval);
                }
            }

            // Update biến thể
            $variant_ids = $_POST['variant_id'] ?? [];
            $variant_names = $_POST['variant_name'] ?? [];
            $variant_prices = $_POST['variant_price'] ?? [];
            $variant_stocks = $_POST['variant_stock'] ?? [];
            $variant_skus = $_POST['variant_sku'] ?? [];
            $variant_attr_ids = $_POST['variant_attr_ids'] ?? [];

            $submitted_ids = [];

            if (empty($variant_names) || empty(trim($variant_names[0] ?? ''))) {
                // Xóa hết cũ, tạo 1 cái mặc định
                $productModel->deleteVariantsByProductId($id);
                $productModel->insertDefaultVariant($id, $price, $stock);
            } else {
                foreach ($variant_names as $i => $name) {
                    $name = trim($name);
                    if ($name != '') {
                        $v_price = (float) str_replace(['.', ','], '', $variant_prices[$i] ?? $price);
                        $v_stock = (int) ($variant_stocks[$i] ?? 0);
                        $v_sku = trim($variant_skus[$i] ?? '');

                        if (!empty($variant_ids[$i])) {
                            $vid = $variant_ids[$i];
                            $productModel->updateVariant($vid, $name, $v_price, $v_stock, $v_sku);
                            $submitted_ids[] = $vid;

                            // Cập nhật thuộc tính (xóa cũ thêm mới cho nhanh)
                            $productModel->deleteVariantAttributesByVariant($vid);
                        } else {
                            $vid = $productModel->insertVariant($id, $name, $v_price, $v_stock, $v_sku);
                            $submitted_ids[] = $vid;
                        }

                        // Liên kết thuộc tính
                        if (!empty($variant_attr_ids[$i])) {
                            $attrs = explode(',', $variant_attr_ids[$i]);
                            foreach ($attrs as $attr_val_id) {
                                $productModel->insertVariantAttribute($vid, trim($attr_val_id));
                            }
                        }
                    }
                }
                $productModel->deleteUnusedVariants($id, $submitted_ids);
            }

            $_SESSION['success'] = 'Cập nhật sản phẩm thành công!';
            header('Location: ' . BASE_URL . '?action=admin-products');
            exit;
        }

        $categories = $categoryModel->getAllCategories();
        $brands = $brandModel->getAllBrands();
        $all_attributes = $attrModel->getAllAttributesWithValues();

        $title = 'Sửa sản phẩm - DGENTECH Admin';
        $pageTitle = 'Sản phẩm';
        $action = 'admin-product-edit';
        $view = 'admin/product_form';
        require_once PATH_VIEW_ADMIN;
    }

    // Chức năng: Xóa sản phẩm
    public function deleteProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['product_id'] ?? 0;
            if ($id) {
                $productModel = new ProductModel();

                try {
                    $pdo = $productModel->getPdo();
                    $pdo->beginTransaction();

                    // 1. Xóa ảnh
                    $productModel->deletePrimaryImage($id);
                    $productModel->deleteGalleryImages($id);

                    // 2. Xóa Specs
                    $productModel->deleteProductSpecs($id);

                    // Xóa Đánh giá (Reviews) liên quan
                    $pdo->exec("DELETE FROM tb_reviews WHERE product_id = " . (int)$id);

                    // 3. Xóa thuộc tính biến thể (Variant attributes) và Giỏ hàng
                    $variants = $productModel->getVariantsByProductId($id);
                    foreach ($variants as $var) {
                        $productModel->deleteVariantAttributesByVariant($var['variant_id']);
                        $pdo->exec("DELETE FROM tb_cart_items WHERE variant_id = " . (int)$var['variant_id']);
                        
                        // CẢNH BÁO: Nếu bạn muốn xóa bất chấp sản phẩm đã có trong đơn hàng, hãy bỏ comment dòng dưới.
                        // Tuy nhiên điều này sẽ làm mất lịch sử đơn hàng của khách.
                        // $pdo->exec("DELETE FROM tb_order_items WHERE variant_id = " . (int)$var['variant_id']);
                    }

                    // 4. Xóa các biến thể (Variants)
                    $productModel->deleteVariantsByProductId($id);

                    // 5. Cuối cùng, xóa Sản phẩm
                    $productModel->deleteProduct($id);

                    $pdo->commit();
                    $_SESSION['success'] = 'Xóa sản phẩm thành công!';
                } catch (\PDOException $e) {
                    $productModel->getPdo()->rollBack();
                    if ($e->getCode() == '23000') {
                        $_SESSION['error'] = 'Không thể xóa sản phẩm này vì nó đã phát sinh đơn hàng! Hãy chuyển trạng thái sản phẩm sang Ngừng kinh doanh thay vì xóa.';
                    } else {
                        $_SESSION['error'] = 'Lỗi hệ thống: Không thể xóa sản phẩm.';
                    }
                } catch (\Exception $e) {
                    $productModel->getPdo()->rollBack();
                    $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
                }
            }

            header('Location: ' . BASE_URL . '?action=admin-products');
            exit;
        }
    }

    // Chức năng: Quản lý thương hiệu (Hiển thị danh sách)
    public function brands()
    {
        $brandModel = new BrandModel();
        list($keyword, $page, $limit, $offset) = $this->getPaginationParams();
        $status = $_GET['status'] ?? '';

        $brands = $brandModel->getAllBrands($keyword, $limit, $offset, $status);
        $totalRecords = $brandModel->countTotalBrandsFiltered($keyword, $status);
        $totalPages = ceil($totalRecords / $limit);

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
    //QUẢN LÝ NGƯỜI DÙNG
    // Danh sách người dùng
    public function users()
    {
        $userModel = new UserModel();
        list($keyword, $page, $limit, $offset) = $this->getPaginationParams();
        $status = $_GET['status'] ?? '';

        $users = $userModel->getAllUsers($keyword, $limit, $offset, $status);
        $totalRecords = $userModel->countTotalUsersFiltered($keyword, $status);
        $totalPages = ceil($totalRecords / $limit);
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
        $permissions = isset($_POST['permissions']) ? json_encode($_POST['permissions']) : null;
        if ($role == 0) $permissions = null;

        $password = password_hash($password, PASSWORD_DEFAULT);
        $userModel->insertUser(
            $full_name,
            $email,
            $password,
            $phone,
            $address,
            $role,
            $status,
            $permissions
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
        $permissions = isset($_POST['permissions']) ? json_encode($_POST['permissions']) : null;
        if ($role == 0) $permissions = null;

        $userModel->updateUser(
            $id,
            $full_name,
            $email,
            $phone,
            $address,
            $role,
            $status,
            $permissions
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
        try {
            $userModel->deleteUser($id);
            $_SESSION['success'] = 'Xóa người dùng thành công!';
        } catch (\PDOException $e) {
            if ($e->getCode() == '23000') {
                $_SESSION['error'] = 'Không thể xóa người dùng này vì tài khoản đang có dữ liệu liên kết (đơn hàng, bình luận...)!';
            } else {
                $_SESSION['error'] = 'Lỗi khi xóa người dùng: ' . $e->getMessage();
            }
        }
        header('Location: ' . BASE_URL . '?action=admin-users');
        exit;
    }
    public function orders()
    {

        $orderModel = new OrderModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $order_id = $_POST['order_id'] ?? 0;
            $status = $_POST['status'] ?? 'pending';

            $orderModel->updateOrderStatus($order_id, $status);
            $_SESSION['success'] = 'Cập nhật trạng thái đơn hàng thành công!';
            header('Location: ' . BASE_URL . '?action=admin-orders');
            exit;
        }

        list($keyword, $page, $limit, $offset) = $this->getPaginationParams();
        $status = $_GET['status'] ?? '';

        $orders = $orderModel->getOrdersPaginated($limit, $offset, $keyword, $status);
        $totalRecords = $orderModel->countTotalOrdersFiltered($keyword, $status);
        $totalPages = ceil($totalRecords / $limit);

        $title = 'Quản lý đơn hàng - DGENTECH Admin';
        $pageTitle = 'Đơn hàng';
        $action = 'admin-orders';
        $view = 'admin/orders';
        require_once PATH_VIEW_ADMIN;
    }

    // Chức năng: Hiển thị chi tiết một đơn hàng cụ thể
    public function orderDetail()
    {

        $orderModel = new OrderModel();
        $id = $_GET['id'] ?? 0;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'] ?? 'pending';
            $orderModel->updateOrderStatus($id, $status);
            header("Location: " . BASE_URL . "?action=admin-order-detail&id=" . $id);
            exit;
        }

        $order = $orderModel->getOrderById($id);
        if (!$order) {
            header('Location: ' . BASE_URL . '?action=admin-orders');
            exit;
        }

        require_once PATH_ROOT . 'models/OrderDetailModel.php';
        $orderDetailModel = new OrderDetailModel();
        $orderDetails = $orderDetailModel->getDetailsByOrderId($id);

        $title = 'Chi tiết đơn hàng - DGENTECH Admin';
        $pageTitle = 'Chi tiết đơn hàng';
        $action = 'admin-order-detail';
        $view = 'admin/order_detail';
        require_once PATH_VIEW_ADMIN;
    }
    public function profile()
    {
        $userModel = new UserModel();
        // Lấy thông tin mới nhất từ DB dựa vào user đang đăng nhập
        $user = $userModel->getUserById($_SESSION['user']['user_id'] ?? $_SESSION['user']['id'] ?? 0);
        if ($user) {
            $_SESSION['user'] = $user; // Cập nhật session
        }

        $title = 'Thông tin tài khoản - DGENTECH Admin';
        $pageTitle = 'Thông tin tài khoản';
        $action = 'admin-profile';
        $view = 'admin/profile';
        require_once PATH_VIEW_ADMIN;
    }

    public function updateProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new UserModel();
            $full_name = trim($_POST['full_name'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $address = trim($_POST['address'] ?? '');

            if (empty($full_name) || empty($phone)) {
                $_SESSION['error'] = 'Vui lòng nhập đầy đủ họ tên và số điện thoại!';
            } else {
                $userId = $_SESSION['user']['user_id'] ?? $_SESSION['user']['id'];
                $result = $userModel->updateProfile($userId, $full_name, $phone, $address);
                if ($result) {
                    $_SESSION['success'] = 'Cập nhật thông tin thành công!';
                } else {
                    $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại!';
                }
            }
        }

        header('Location: ' . BASE_URL . '?action=admin-profile');
        exit;
    }

    public function changePassword()
    {
        $title = 'Đổi mật khẩu - DGENTECH Admin';
        $pageTitle = 'Đổi mật khẩu';
        $action = 'admin-change-password';
        $view = 'admin/change_password';
        require_once PATH_VIEW_ADMIN;
    }

    public function updatePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new UserModel();
            $old_password = $_POST['old_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
                $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin!';
            } elseif ($new_password !== $confirm_password) {
                $_SESSION['error'] = 'Mật khẩu mới không khớp!';
            } else {
                $userId = $_SESSION['user']['user_id'] ?? $_SESSION['user']['id'];
                $user = $userModel->getUserById($userId);

                if ($user && password_verify($old_password, $user['password'])) {
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $result = $userModel->updatePassword($userId, $hashed_password);
                    if ($result) {
                        $_SESSION['success'] = 'Đổi mật khẩu thành công!';
                    } else {
                        $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại!';
                    }
                } else {
                    $_SESSION['error'] = 'Mật khẩu hiện tại không chính xác!';
                }
            }
        }

        header('Location: ' . BASE_URL . '?action=admin-change-password');
        exit;
    }

    // ==========================================
    // QUẢN LÝ BANNER
    // ==========================================

    /**
     * Hiển thị danh sách banner
     */
    public function banners()
    {
        $bannerModel = new BannerModel();
        list($keyword, $page, $limit, $offset) = $this->getPaginationParams();
        $status = $_GET['status'] ?? '';
        
        $banners = $bannerModel->getAllBanners($limit, $offset, $keyword, $status);
        $totalRecords = $bannerModel->countTotalBannersFiltered($keyword, $status);
        $totalPages = ceil($totalRecords / $limit);

        $title = 'Quản lý Banner - DGENTECH Admin';
        $pageTitle = 'Quản lý Banner';
        $action = 'admin-banners';
        $view = 'admin/banners';
        require_once PATH_VIEW_ADMIN;
    }

    /**
     * Hiển thị form Thêm / Sửa banner
     */
    public function bannerForm()
    {
        $id = $_GET['id'] ?? null;
        $banner = null;

        // Nếu có truyền ID lên url thì là đang ở chế độ Chỉnh Sửa
        if ($id) {
            $bannerModel = new BannerModel();
            $banner = $bannerModel->getBannerById($id);
            if (!$banner) {
                $_SESSION['error'] = 'Không tìm thấy banner!';
                header('Location: ' . BASE_URL . '?action=admin-banners');
                exit;
            }
        }

        $title = isset($banner) ? 'Sửa Banner - DGENTECH Admin' : 'Thêm mới Banner - DGENTECH Admin';
        $pageTitle = isset($banner) ? 'Sửa Banner' : 'Thêm mới Banner';
        $action = 'admin-banner-form';
        $view = 'admin/banner_form';
        require_once PATH_VIEW_ADMIN;
    }

    /**
     * Xử lý Thêm banner vào DB
     */
    public function bannerCreate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $link = $_POST['link'] ?? '';
            $position = $_POST['position'] ?? 'promo_banner';
            $status = isset($_POST['status']) ? (int) $_POST['status'] : 1;
            $image_url = '';

            // Xử lý upload ảnh
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['image'];
                // Đảm bảo thư mục upload tồn tại
                $uploadDir = './assets/uploads/banner/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                // Tạo tên file ngẫu nhiên để tránh trùng
                $filename = time() . '_' . basename($file['name']);
                $targetPath = $uploadDir . $filename;

                if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                    $image_url = $filename;
                }
            }

            if (empty($title) || empty($image_url)) {
                $_SESSION['error'] = 'Vui lòng nhập tiêu đề và chọn ảnh!';
                header('Location: ' . BASE_URL . '?action=admin-banner-form');
                exit;
            }

            $bannerModel = new BannerModel();
            $result = $bannerModel->createBanner($title, $image_url, $link, $position, $status);

            if ($result) {
                $_SESSION['success'] = 'Thêm banner thành công!';
                header('Location: ' . BASE_URL . '?action=admin-banners');
                exit;
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại!';
                header('Location: ' . BASE_URL . '?action=admin-banner-form');
                exit;
            }
        }
    }

    /**
     * Xử lý Cập nhật banner trong DB
     */
    public function bannerUpdate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            $title = $_POST['title'] ?? '';
            $link = $_POST['link'] ?? '';
            $position = $_POST['position'] ?? 'promo_banner';
            $status = isset($_POST['status']) ? (int) $_POST['status'] : 0;
            $old_image = $_POST['old_image'] ?? '';
            $image_url = $old_image;

            if (empty($id) || empty($title)) {
                $_SESSION['error'] = 'Vui lòng nhập đủ thông tin bắt buộc!';
                header('Location: ' . BASE_URL . '?action=admin-banner-form&id=' . $id);
                exit;
            }

            // Xử lý upload ảnh nếu có cập nhật ảnh mới
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['image'];
                $uploadDir = './assets/uploads/banner/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $filename = time() . '_' . basename($file['name']);
                $targetPath = $uploadDir . $filename;

                if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                    $image_url = $filename;

                    // (Tùy chọn) Xóa ảnh cũ đi cho nhẹ server
                    if (!empty($old_image) && file_exists($uploadDir . $old_image)) {
                        unlink($uploadDir . $old_image);
                    }
                }
            }

            $bannerModel = new BannerModel();
            $result = $bannerModel->updateBanner($id, $title, $image_url, $link, $position, $status);

            if ($result) {
                $_SESSION['success'] = 'Cập nhật banner thành công!';
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra khi cập nhật!';
            }
            header('Location: ' . BASE_URL . '?action=admin-banners');
            exit;
        }
    }

    /**
     * Xử lý Xóa banner
     */
    public function bannerDelete()
    {
        $id = $_GET['id'] ?? 0;
        if ($id) {
            $bannerModel = new BannerModel();
            // Lấy thông tin banner để xóa ảnh
            $banner = $bannerModel->getBannerById($id);
            if ($banner) {
                // Xóa file ảnh vật lý
                $uploadDir = './assets/uploads/banner/';
                if (!empty($banner['image_url']) && file_exists($uploadDir . $banner['image_url'])) {
                    unlink($uploadDir . $banner['image_url']);
                }

                // Xóa data trong DB
                if ($bannerModel->deleteBanner($id)) {
                    $_SESSION['success'] = 'Xóa banner thành công!';
                } else {
                    $_SESSION['error'] = 'Có lỗi xảy ra khi xóa!';
                }
            }
        }
        header('Location: ' . BASE_URL . '?action=admin-banners');
        exit;
    }
    // --- QUẢN LÝ THUỘC TÍNH (ATTRIBUTES) ---

    public function attributes()
    {
        require_once PATH_MODEL . 'AttributeModel.php';
        $attrModel = new AttributeModel();
        list($keyword, $page, $limit, $offset) = $this->getPaginationParams();
        $attributes = $attrModel->getAllAttributesWithValues($limit, $offset, $keyword);
        $totalRecords = $attrModel->countTotalAttributesFiltered($keyword);
        $totalPages = ceil($totalRecords / $limit);
        $title = 'Quản lý Thuộc tính - DGENTECH Admin';
        $pageTitle = 'Thuộc tính';
        $action = 'admin-attributes';
        $view = 'admin/attributes';
        require_once PATH_VIEW_ADMIN;
    }

    public function attributeCreate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['attribute_name'] ?? '');
            if (!empty($name)) {
                require_once PATH_MODEL . 'AttributeModel.php';
                $attrModel = new AttributeModel();
                $attrModel->addAttribute($name);
                $_SESSION['success'] = 'Thêm thuộc tính thành công!';
            } else {
                $_SESSION['error'] = 'Tên thuộc tính không hợp lệ!';
            }
        }
        header('Location: ' . BASE_URL . '?action=admin-attributes');
        exit;
    }

    public function attributeDetail()
    {
        $id = $_GET['id'] ?? 0;
        if (!$id) {
            header('Location: ' . BASE_URL . '?action=admin-attributes');
            exit;
        }

        require_once PATH_MODEL . 'AttributeModel.php';
        $attrModel = new AttributeModel();
        
        // Cần một hàm để lấy 1 thuộc tính và các giá trị của nó
        // Hoặc lấy tất cả rồi lọc ra
        $all_attributes = $attrModel->getAllAttributesWithValues();
        $attribute = null;
        foreach ($all_attributes as $attr) {
            if ($attr['attribute_id'] == $id) {
                $attribute = $attr;
                break;
            }
        }
        
        if (!$attribute) {
            $_SESSION['error'] = 'Không tìm thấy thuộc tính!';
            header('Location: ' . BASE_URL . '?action=admin-attributes');
            exit;
        }

        $title = 'Chi tiết Thuộc tính - DGENTECH Admin';
        $pageTitle = 'Thuộc tính';
        $action = 'admin-attributes';
        $view = 'admin/attribute_detail';
        require_once PATH_VIEW_ADMIN;
    }

    public function attributeUpdate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['attribute_id'] ?? 0;
            $name = trim($_POST['attribute_name'] ?? '');
            if ($id && !empty($name)) {
                require_once PATH_MODEL . 'AttributeModel.php';
                $attrModel = new AttributeModel();
                $attrModel->updateAttribute($id, $name);
                $_SESSION['success'] = 'Cập nhật thuộc tính thành công!';
            } else {
                $_SESSION['error'] = 'Dữ liệu không hợp lệ!';
            }
        }
        header('Location: ' . BASE_URL . '?action=admin-attributes');
        exit;
    }

    public function attributeDelete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['attribute_id'] ?? 0;
            if ($id) {
                require_once PATH_MODEL . 'AttributeModel.php';
                $attrModel = new AttributeModel();
                $attrModel->deleteAttribute($id);
                $_SESSION['success'] = 'Xóa thuộc tính thành công!';
            }
        }
        header('Location: ' . BASE_URL . '?action=admin-attributes');
        exit;
    }

    public function attributeValueCreate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $attr_id = $_POST['attribute_id'] ?? 0;
            $value = trim($_POST['attribute_value'] ?? '');
            if ($attr_id && !empty($value)) {
                require_once PATH_MODEL . 'AttributeModel.php';
                $attrModel = new AttributeModel();
                $attrModel->addAttributeValue($attr_id, $value);
                $_SESSION['success'] = 'Thêm giá trị thành công!';
            } else {
                $_SESSION['error'] = 'Dữ liệu không hợp lệ!';
            }
            header('Location: ' . BASE_URL . '?action=admin-attribute-detail&id=' . $attr_id);
            exit;
        }
    }

    public function attributeValueDelete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['attribute_value_id'] ?? 0;
            $attr_id = $_POST['attribute_id'] ?? 0;
            if ($id) {
                require_once PATH_MODEL . 'AttributeModel.php';
                $attrModel = new AttributeModel();
                $attrModel->deleteAttributeValue($id);
                $_SESSION['success'] = 'Xóa giá trị thành công!';
            }
            header('Location: ' . BASE_URL . '?action=admin-attribute-detail&id=' . $attr_id);
            exit;
        }
    }

    // ==========================================
    // QUẢN LÝ TIN TỨC (NEWS)
    // ==========================================
    public function news()
    {
        require_once PATH_MODEL . 'NewsModel.php';
        $newsModel = new NewsModel();
        
        list($keyword, $page, $limit, $offset) = $this->getPaginationParams();
        $status = $_GET['status'] ?? '';
        
        $newsList = $newsModel->getAllNews($limit, $offset, $keyword, $status);
        $totalRecords = $newsModel->countTotalNewsFiltered($keyword, $status);
        $totalPages = ceil($totalRecords / $limit);
        
        $title = 'Quản lý Tin tức - DGENTECH Admin';
        $pageTitle = 'Tin tức';
        $action = 'admin-news';
        $view = 'admin/news';
        require_once PATH_VIEW_ADMIN;
    }

    public function newsForm()
    {
        require_once PATH_MODEL . 'NewsModel.php';
        require_once PATH_MODEL . 'NewsCategoryModel.php';
        
        $id = $_GET['id'] ?? 0;
        $news = null;

        if ($id) {
            $newsModel = new NewsModel();
            $news = $newsModel->getNewsById($id);
        }

        $categoryModel = new NewsCategoryModel();
        $categories = $categoryModel->getActiveCategories();

        $title = ($id ? 'Sửa' : 'Thêm') . ' bài viết - DGENTECH Admin';
        $pageTitle = 'Tin tức';
        $action = 'admin-news';
        $view = 'admin/news_form';
        require_once PATH_VIEW_ADMIN;
    }

    public function newsCreate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once PATH_MODEL . 'NewsModel.php';
            $newsModel = new NewsModel();

            $data = [
                'title' => trim($_POST['title'] ?? ''),
                'slug' => trim($_POST['slug'] ?? ''),
                'summary' => trim($_POST['summary'] ?? ''),
                'content' => $_POST['content'] ?? '',
                'category_id' => !empty($_POST['category_id']) ? $_POST['category_id'] : null,
                'status' => $_POST['status'] ?? 1,
                'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
                'image_url' => null
            ];

            // Upload ảnh
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = 'assets/uploads/news/';
                if (!is_dir(PATH_ROOT . $upload_dir)) mkdir(PATH_ROOT . $upload_dir, 0777, true);
                
                $file_name = time() . '_' . basename($_FILES['image']['name']);
                $target_file = PATH_ROOT . $upload_dir . $file_name;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    $data['image_url'] = BASE_URL . $upload_dir . $file_name;
                }
            }

            $newsModel->createNews($data);
            $_SESSION['success'] = 'Thêm bài viết thành công!';
            header('Location: ' . BASE_URL . '?action=admin-news');
            exit;
        }
    }

    public function newsUpdate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once PATH_MODEL . 'NewsModel.php';
            $newsModel = new NewsModel();

            $id = $_POST['news_id'] ?? 0;
            $data = [
                'title' => trim($_POST['title'] ?? ''),
                'slug' => trim($_POST['slug'] ?? ''),
                'summary' => trim($_POST['summary'] ?? ''),
                'content' => $_POST['content'] ?? '',
                'category_id' => !empty($_POST['category_id']) ? $_POST['category_id'] : null,
                'status' => $_POST['status'] ?? 1,
                'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
                'image_url' => $_POST['old_image_url'] ?? null
            ];

            // Upload ảnh mới
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = 'assets/uploads/news/';
                if (!is_dir(PATH_ROOT . $upload_dir)) mkdir(PATH_ROOT . $upload_dir, 0777, true);
                
                $file_name = time() . '_' . basename($_FILES['image']['name']);
                $target_file = PATH_ROOT . $upload_dir . $file_name;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    $data['image_url'] = BASE_URL . $upload_dir . $file_name;
                }
            }

            $newsModel->updateNews($id, $data);
            $_SESSION['success'] = 'Cập nhật bài viết thành công!';
            header('Location: ' . BASE_URL . '?action=admin-news');
            exit;
        }
    }

    public function newsDelete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once PATH_MODEL . 'NewsModel.php';
            $newsModel = new NewsModel();
            
            $id = $_POST['news_id'] ?? 0;
            $newsModel->deleteNews($id);
            
            $_SESSION['success'] = 'Xóa bài viết thành công!';
            header('Location: ' . BASE_URL . '?action=admin-news');
            exit;
        }
    }

    // ==========================================
    // QUẢN LÝ DANH MỤC TIN TỨC (NEWS CATEGORIES)
    // ==========================================
    public function newsCategories()
    {
        require_once PATH_MODEL . 'NewsCategoryModel.php';
        $categoryModel = new NewsCategoryModel();
        list($keyword, $page, $limit, $offset) = $this->getPaginationParams();
        $status = $_GET['status'] ?? '';
        
        $categories = $categoryModel->getAllCategories($limit, $offset, $keyword, $status);
        $totalRecords = $categoryModel->countTotalCategoriesFiltered($keyword, $status);
        $totalPages = ceil($totalRecords / $limit);
        $title = 'Danh mục Tin tức - DGENTECH Admin';
        $pageTitle = 'Danh mục Tin tức';
        $action = 'admin-news-categories';
        $view = 'admin/news_categories';
        require_once PATH_VIEW_ADMIN;
    }

    public function newsCategoryForm()
    {
        require_once PATH_MODEL . 'NewsCategoryModel.php';
        
        $id = $_GET['id'] ?? 0;
        $category = null;

        if ($id) {
            $categoryModel = new NewsCategoryModel();
            $category = $categoryModel->getCategoryById($id);
        }

        $title = ($id ? 'Sửa' : 'Thêm') . ' danh mục - DGENTECH Admin';
        $pageTitle = 'Danh mục Tin tức';
        $action = 'admin-news-categories';
        $view = 'admin/news_category_form';
        require_once PATH_VIEW_ADMIN;
    }

    public function newsCategoryCreate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once PATH_MODEL . 'NewsCategoryModel.php';
            $categoryModel = new NewsCategoryModel();

            $name = trim($_POST['name'] ?? '');
            $slug = trim($_POST['slug'] ?? '');
            $status = $_POST['status'] ?? 1;

            $categoryModel->createCategory($name, $slug, $status);
            
            $_SESSION['success'] = 'Thêm danh mục thành công!';
            header('Location: ' . BASE_URL . '?action=admin-news-categories');
            exit;
        }
    }

    public function newsCategoryUpdate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once PATH_MODEL . 'NewsCategoryModel.php';
            $categoryModel = new NewsCategoryModel();

            $id = $_POST['category_id'] ?? 0;
            $name = trim($_POST['name'] ?? '');
            $slug = trim($_POST['slug'] ?? '');
            $status = $_POST['status'] ?? 1;

            $categoryModel->updateCategory($id, $name, $slug, $status);
            
            $_SESSION['success'] = 'Cập nhật danh mục thành công!';
            header('Location: ' . BASE_URL . '?action=admin-news-categories');
            exit;
        }
    }

    public function newsCategoryDelete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once PATH_MODEL . 'NewsCategoryModel.php';
            $categoryModel = new NewsCategoryModel();
            
            $id = $_POST['category_id'] ?? 0;
            $categoryModel->deleteCategory($id);
            
            $_SESSION['success'] = 'Xóa danh mục thành công!';
            header('Location: ' . BASE_URL . '?action=admin-news-categories');
            exit;
        }
    }

    public function contacts()
    {
        require_once PATH_MODEL . 'ContactModel.php';
        $contactModel = new ContactModel();

        $role = $_SESSION['user']['role'] ?? 1;
        $department = $_GET['department'] ?? '';

        $permissions = $_SESSION['user']['permissions'] ?? [];
        if (is_string($permissions)) {
            $permissions = json_decode($permissions, true) ?: [];
        }

        if ($role != 1) {
            if (in_array('contacts_cskh', $permissions) && !in_array('contacts_kythuat', $permissions)) {
                $department = 'CSKH';
            } elseif (in_array('contacts_kythuat', $permissions) && !in_array('contacts_cskh', $permissions)) {
                $department = 'KyThuat';
            } else {
                if (empty($department) || !in_array($department, ['CSKH', 'KyThuat'])) {
                    if (in_array('contacts_cskh', $permissions)) {
                        header('Location: ' . BASE_URL . '?action=admin-contacts&department=CSKH');
                        exit;
                    } elseif (in_array('contacts_kythuat', $permissions)) {
                        header('Location: ' . BASE_URL . '?action=admin-contacts&department=KyThuat');
                        exit;
                    }
                }
            }
        } else {
            if (empty($department) || !in_array($department, ['CSKH', 'KyThuat'])) {
                header('Location: ' . BASE_URL . '?action=admin-contacts&department=CSKH');
                exit;
            }
        }

        $keyword = trim($_GET['keyword'] ?? '');
        $status = $_GET['status'] ?? '';
        $startDate = $_GET['start_date'] ?? '';
        $endDate = $_GET['end_date'] ?? '';
        
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 10;
        if (!in_array($limit, [10, 20, 50, 100])) $limit = 10;
        $offset = ($page - 1) * $limit;

        $contacts = $contactModel->getAllContacts($limit, $offset, $keyword, $status, $startDate, $endDate, $department);
        $totalContacts = $contactModel->countTotalContactsFiltered($keyword, $status, $startDate, $endDate, $department);
        $totalPages = ceil($totalContacts / $limit);

        $view = 'admin/contacts';
        require_once PATH_VIEW . 'layouts/admin_layout.php';
    }

    public function changeContactStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once PATH_MODEL . 'ContactModel.php';
            $contactModel = new ContactModel();
            
            $id = $_POST['contact_id'] ?? 0;
            $status = $_POST['status'] ?? '';
            $note = $_POST['note'] ?? '';
            $userId = $_SESSION['user']['user_id'] ?? null;
            
            if ($id && in_array($status, ['pending', 'rejected', 'processing', 'resolved', 'closed', 'reprocess'])) {
                $contactModel->updateStatus($id, $status);
                $contactModel->addLog($id, $userId, "change_status: $status", $note);
                $_SESSION['success'] = 'Cập nhật trạng thái thành công!';
            } else {
                $_SESSION['error'] = 'Cập nhật trạng thái thất bại. Thông tin không hợp lệ.';
            }
            
            header('Location: ' . BASE_URL . '?action=admin-contacts');
            exit;
        }
    }

    public function changeContactDepartment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once PATH_MODEL . 'ContactModel.php';
            $contactModel = new ContactModel();
            
            $id = $_POST['contact_id'] ?? 0;
            $department = $_POST['department'] ?? '';
            $note = $_POST['note'] ?? '';
            $userId = $_SESSION['user']['user_id'] ?? null;
            
            if ($id && in_array($department, ['CSKH', 'KyThuat'])) {
                $contactModel->updateDepartment($id, $department);
                $contactModel->addLog($id, $userId, "change_department: $department", $note);
                $_SESSION['success'] = 'Chuyển phòng ban thành công!';
            } else {
                $_SESSION['error'] = 'Chuyển phòng ban thất bại.';
            }
            
            header('Location: ' . BASE_URL . '?action=admin-contacts');
            exit;
        }
    }

    public function bulkUpdateContacts()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once PATH_MODEL . 'ContactModel.php';
            $contactModel = new ContactModel();
            
            $ids = $_POST['contact_ids'] ?? [];
            $action = $_POST['bulk_action'] ?? '';
            $userId = $_SESSION['user']['user_id'] ?? null;
            
            if (!empty($ids) && in_array($action, ['pending', 'processing', 'rejected', 'resolved', 'closed', 'reprocess'])) {
                foreach ($ids as $id) {
                    $contactModel->updateStatus($id, $action);
                    $contactModel->addLog($id, $userId, "bulk_change_status: $action", "Cập nhật hàng loạt");
                }
                $_SESSION['success'] = 'Cập nhật hàng loạt thành công!';
            } else {
                $_SESSION['error'] = 'Vui lòng chọn ít nhất 1 dòng và hành động hợp lệ.';
            }
            
            header('Location: ' . BASE_URL . '?action=admin-contacts');
            exit;
        }
    }
    
    public function getContactLogsAjax()
    {
        if (isset($_GET['id'])) {
            require_once PATH_MODEL . 'ContactModel.php';
            $contactModel = new ContactModel();
            $logs = $contactModel->getLogsByContactId($_GET['id']);
            header('Content-Type: application/json');
            echo json_encode($logs);
            exit;
        }
    }

    // --- ADMIN REVIEW MANAGEMENT ---
    public function reviews()
    {
        list($keyword, $page, $limit, $offset) = $this->getPaginationParams();

        require_once 'models/ReviewModel.php';
        $reviewModel = new ReviewModel();
        
        $reviews = $reviewModel->getAllReviewsPaginated($limit, $offset);
        $totalReviews = $reviewModel->countTotalReviews();
        $totalPages = ceil($totalReviews / $limit);

        $title = 'Quản lý đánh giá - DGENTECH Admin';
        $pageTitle = 'Quản lý đánh giá';
        $action = 'admin-reviews';
        $view = 'admin/reviews';
        require_once PATH_VIEW_ADMIN;
    }

    public function deleteReview()
    {
        if (isset($_GET['id'])) {
            require_once 'models/ReviewModel.php';
            $reviewModel = new ReviewModel();
            if ($reviewModel->deleteReview($_GET['id'])) {
                $_SESSION['success'] = "Xóa đánh giá thành công!";
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi xóa đánh giá!";
            }
        }
        header("Location: ?action=admin-reviews");
        exit();
    }

    public function replyReview()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review_id']) && isset($_POST['reply_content'])) {
            require_once 'models/ReviewModel.php';
            $reviewModel = new ReviewModel();
            
            $review_id = $_POST['review_id'];
            $content = trim($_POST['reply_content']);
            $user_id = $_SESSION['user']['user_id'];
            
            if ($content !== '') {
                if ($reviewModel->addReply($review_id, $user_id, $content, 1)) {
                    $_SESSION['success'] = "Đã gửi phản hồi thành công!";
                } else {
                    $_SESSION['error'] = "Có lỗi xảy ra khi gửi phản hồi!";
                }
            }
        }
    }
    
    // --- MÃ GIẢM GIÁ (DISCOUNTS) ---

    public function discounts()
    {
        require_once PATH_MODEL . 'DiscountModel.php';
        $discountModel = new DiscountModel();

        list($keyword, $page, $limit, $offset) = $this->getPaginationParams();

        $discounts = $discountModel->getAllDiscounts($keyword, $limit, $offset);
        $totalRecords = $discountModel->countTotalDiscountsFiltered($keyword);
        $totalPages = ceil($totalRecords / $limit);

        $title = 'Quản lý Mã Giảm Giá - DGENTECH Admin';
        $pageTitle = 'Mã Giảm Giá';
        $action = 'admin-discounts';
        $view = 'admin/discounts/index';
        require_once PATH_VIEW_ADMIN;
    }

    public function discountDetail()
    {
        require_once PATH_MODEL . 'DiscountModel.php';
        $discountModel = new DiscountModel();

        $id = $_GET['id'] ?? 0;
        $discount = null;
        $isDetail = true;

        if ($id > 0) {
            $discount = $discountModel->getDiscountById($id);
            if (!$discount) {
                $_SESSION['error'] = "Không tìm thấy mã giảm giá!";
                header("Location: ?action=admin-discounts");
                exit();
            }
        } else {
            header("Location: ?action=admin-discounts");
            exit();
        }

        $title = 'Chi tiết Mã Giảm Giá - DGENTECH Admin';
        $pageTitle = 'Mã Giảm Giá';
        $action = 'admin-discounts';
        $view = 'admin/discounts/form';
        require_once PATH_VIEW_ADMIN;
    }

    public function discountForm()
    {
        require_once PATH_MODEL . 'DiscountModel.php';
        $discountModel = new DiscountModel();

        $id = $_GET['id'] ?? 0;
        $discount = null;
        $isDetail = false; // Add for compatibility with forms if needed

        if ($id > 0) {
            $discount = $discountModel->getDiscountById($id);
            if (!$discount) {
                $_SESSION['error'] = "Không tìm thấy mã giảm giá!";
                header("Location: ?action=admin-discounts");
                exit();
            }
        }

        $title = ($id > 0 ? 'Sửa' : 'Thêm') . ' Mã Giảm Giá - DGENTECH Admin';
        $pageTitle = 'Mã Giảm Giá';
        $action = 'admin-discounts';
        $view = 'admin/discounts/form';
        require_once PATH_VIEW_ADMIN;
    }

    public function discountCreate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once PATH_MODEL . 'DiscountModel.php';
            $discountModel = new DiscountModel();

            $code = trim($_POST['code']);
            $discount_type = $_POST['discount_type'];
            $discount_value = $_POST['discount_value'];
            $max_discount = $_POST['max_discount'] ?? null;
            $minimum_order_value = $_POST['minimum_order_value'] ?? 0;
            $quantity = $_POST['quantity'] ?? null;
            $max_usage_per_user = $_POST['max_usage_per_user'] ?? null;
            $start_date = !empty($_POST['start_date']) ? $_POST['start_date'] : null;
            $end_date = !empty($_POST['end_date']) ? $_POST['end_date'] : null;
            $status = $_POST['status'] ?? 'active';

            // Check duplicate code
            $existing = $discountModel->getDiscountByCode($code);
            if ($existing) {
                $_SESSION['error'] = "Mã giảm giá này đã tồn tại!";
                header("Location: ?action=admin-discount-form");
                exit();
            }

            if ($discountModel->insertDiscount($code, $discount_type, $discount_value, $max_discount, $minimum_order_value, $quantity, $max_usage_per_user, $start_date, $end_date, $status)) {
                $_SESSION['success'] = "Thêm mã giảm giá thành công!";
                header("Location: ?action=admin-discounts");
                exit();
            } else {
                $_SESSION['error'] = "Thêm thất bại!";
            }
        }
        header("Location: ?action=admin-discounts");
        exit();
    }

    public function discountUpdate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once PATH_MODEL . 'DiscountModel.php';
            $discountModel = new DiscountModel();

            $id = $_POST['id'];
            $code = trim($_POST['code']);
            $discount_type = $_POST['discount_type'];
            $discount_value = $_POST['discount_value'];
            $max_discount = $_POST['max_discount'] ?? null;
            $minimum_order_value = $_POST['minimum_order_value'] ?? 0;
            $quantity = $_POST['quantity'] ?? null;
            $max_usage_per_user = $_POST['max_usage_per_user'] ?? null;
            $start_date = !empty($_POST['start_date']) ? $_POST['start_date'] : null;
            $end_date = !empty($_POST['end_date']) ? $_POST['end_date'] : null;
            $status = $_POST['status'] ?? 'active';

            // Check duplicate code (excluding current ID)
            $existing = $discountModel->getDiscountByCode($code);
            if ($existing && $existing['discount_id'] != $id) {
                $_SESSION['error'] = "Mã giảm giá này đã tồn tại ở mục khác!";
                header("Location: ?action=admin-discount-form&id=" . $id);
                exit();
            }

            if ($discountModel->updateDiscount($id, $code, $discount_type, $discount_value, $max_discount, $minimum_order_value, $quantity, $max_usage_per_user, $start_date, $end_date, $status)) {
                $_SESSION['success'] = "Cập nhật mã giảm giá thành công!";
                header("Location: ?action=admin-discounts");
                exit();
            } else {
                $_SESSION['error'] = "Cập nhật thất bại!";
            }
        }
        header("Location: ?action=admin-discounts");
        exit();
    }

    public function discountDelete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            require_once PATH_MODEL . 'DiscountModel.php';
            $discountModel = new DiscountModel();
            
            if ($discountModel->deleteDiscount($_POST['id'])) {
                $_SESSION['success'] = "Xóa mã giảm giá thành công!";
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi xóa!";
            }
        }
        header("Location: ?action=admin-discounts");
        exit();
    }

    // --- ADMIN FLASH SALE MANAGEMENT ---
    public function flashSales()
    {
        require_once PATH_MODEL . 'FlashSaleModel.php';
        $flashSaleModel = new FlashSaleModel();
        $flashSales = $flashSaleModel->getAllFlashSales();

        $title = 'Quản lý Flash Sale - DGENTECH Admin';
        $pageTitle = 'Quản lý Flash Sale';
        $action = 'admin-flash-sales';
        $view = 'admin/flash_sales/index';
        require_once PATH_VIEW_ADMIN;
    }

    public function flashSaleForm()
    {
        require_once PATH_MODEL . 'FlashSaleModel.php';
        $flashSaleModel = new FlashSaleModel();
        
        $flashSale = null;
        if (isset($_GET['id'])) {
            $flashSale = $flashSaleModel->getFlashSaleById($_GET['id']);
        }

        $title = ($flashSale ? 'Chỉnh sửa' : 'Thêm') . ' Flash Sale - DGENTECH Admin';
        $pageTitle = ($flashSale ? 'Chỉnh sửa' : 'Thêm') . ' Flash Sale';
        $action = 'admin-flash-sales';
        $view = 'admin/flash_sales/form';
        require_once PATH_VIEW_ADMIN;
    }

    public function flashSaleSave()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once PATH_MODEL . 'FlashSaleModel.php';
            $flashSaleModel = new FlashSaleModel();
            
            $id = $_POST['id'] ?? null;
            $title = $_POST['title'] ?? '';
            $start_time = $_POST['start_time'] ?? '';
            $end_time = $_POST['end_time'] ?? '';
            $status = $_POST['status'] ?? 'active';

            if (empty($title) || empty($start_time) || empty($end_time)) {
                $_SESSION['error'] = "Vui lòng nhập đầy đủ thông tin!";
                header("Location: " . ($id ? "?action=admin-flash-sale-form&id=$id" : "?action=admin-flash-sale-form"));
                exit();
            }

            if ($id) {
                if ($flashSaleModel->updateFlashSale($id, $title, $start_time, $end_time, $status)) {
                    $_SESSION['success'] = "Cập nhật Flash Sale thành công!";
                } else {
                    $_SESSION['error'] = "Có lỗi xảy ra khi cập nhật!";
                }
            } else {
                if ($flashSaleModel->createFlashSale($title, $start_time, $end_time, $status)) {
                    $_SESSION['success'] = "Thêm mới Flash Sale thành công!";
                } else {
                    $_SESSION['error'] = "Có lỗi xảy ra khi thêm mới!";
                }
            }
        }
        header("Location: ?action=admin-flash-sales");
        exit();
    }

    public function flashSaleDelete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            require_once PATH_MODEL . 'FlashSaleModel.php';
            $flashSaleModel = new FlashSaleModel();
            
            if ($flashSaleModel->deleteFlashSale($_POST['id'])) {
                $_SESSION['success'] = "Xóa Flash Sale thành công!";
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi xóa!";
            }
        }
        header("Location: ?action=admin-flash-sales");
        exit();
    }

    public function flashSaleItems()
    {
        if (!isset($_GET['id'])) {
            header("Location: ?action=admin-flash-sales");
            exit();
        }
        $flashSaleId = $_GET['id'];

        require_once PATH_MODEL . 'FlashSaleModel.php';
        $flashSaleModel = new FlashSaleModel();
        $flashSale = $flashSaleModel->getFlashSaleById($flashSaleId);
        if (!$flashSale) {
            header("Location: ?action=admin-flash-sales");
            exit();
        }
        
        $items = $flashSaleModel->getFlashSaleItems($flashSaleId);
        
        require_once PATH_MODEL . 'ProductModel.php';
        $productModel = new ProductModel();
        // Fetch all active products for the dropdown
        $products = $productModel->getAllProducts('', 1000, 0, 'active');

        $title = 'Sản phẩm Flash Sale - DGENTECH Admin';
        $pageTitle = 'Sản phẩm Flash Sale';
        $action = 'admin-flash-sales';
        $view = 'admin/flash_sales/items';
        require_once PATH_VIEW_ADMIN;
    }

    public function flashSaleItemSave()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['flash_sale_id'])) {
            require_once PATH_MODEL . 'FlashSaleModel.php';
            $flashSaleModel = new FlashSaleModel();
            
            $flashSaleId = $_POST['flash_sale_id'];
            $productId = $_POST['product_id'];
            $flashPrice = $_POST['flash_price'];
            $quantity = empty($_POST['quantity']) ? null : $_POST['quantity'];

            if ($flashSaleModel->saveFlashSaleItem($flashSaleId, $productId, $flashPrice, $quantity)) {
                $_SESSION['success'] = "Thêm/cập nhật sản phẩm thành công!";
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra!";
            }
            header("Location: ?action=admin-flash-sale-items&id=" . $flashSaleId);
            exit();
        }
    }

    public function flashSaleItemDelete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            require_once PATH_MODEL . 'FlashSaleModel.php';
            $flashSaleModel = new FlashSaleModel();
            $flashSaleId = $_POST['flash_sale_id'];
            
            if ($flashSaleModel->deleteFlashSaleItem($_POST['id'])) {
                $_SESSION['success'] = "Đã xóa sản phẩm khỏi Flash Sale!";
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra!";
            }
            header("Location: ?action=admin-flash-sale-items&id=" . $flashSaleId);
            exit();
        }
    }
}
