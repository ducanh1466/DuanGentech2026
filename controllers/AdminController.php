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
        list($keyword, $page, $limit, $offset) = $this->getPaginationParams();

        $products = $productModel->getAllProducts($keyword, $limit, $offset);
        $totalRecords = $productModel->countTotalProducts($keyword);
        $totalPages = ceil($totalRecords / $limit);

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

        $brands = $brandModel->getAllBrands($keyword, $limit, $offset);
        $totalRecords = $brandModel->countTotalBrands($keyword);
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

        $users = $userModel->getAllUsers($keyword, $limit, $offset);
        $totalRecords = $userModel->countTotalUsersFiltered($keyword);
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
    public function orders()
    {
        // Kiểm tra quyền, chỉ admin chính (role 1) mới được quản lý đơn hàng
        if ($_SESSION['user']['role'] != 1) {
            header('Location: ' . BASE_URL . '?action=admin-products');
            exit;
        }
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

        $orders = $orderModel->getOrdersPaginated($limit, $offset, $keyword);
        $totalRecords = $orderModel->countTotalOrdersFiltered($keyword);
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
        // Kiểm tra quyền
        if ($_SESSION['user']['role'] != 1) {
            header('Location: ' . BASE_URL . '?action=admin-products');
            exit;
        }
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
        $banners = $bannerModel->getAllBanners();

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
        $attributes = $attrModel->getAllAttributesWithValues();

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
}
