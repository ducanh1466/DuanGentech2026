<?php

class HomeController
{
    public function index()
    {
        require_once PATH_MODEL . 'ProductModel.php';
        require_once PATH_MODEL . 'BannerModel.php';
        require_once PATH_MODEL . 'CategoryModel.php';
        
        $productModel = new ProductModel();
        $bannerModel = new BannerModel();
        $categoryModel = new CategoryModel();

        $homeCategories = $categoryModel->getAllCategories();
        
        $latestProducts = $productModel->getLatestProducts(8);
        $bestSellers = $productModel->getBestSellingProducts(8);
        
        // Fetch banners
        $heroBanners = $bannerModel->getActiveBannersByPosition('hero_slider');
        $promoBanners = $bannerModel->getActiveBannersByPosition('promo_banner', 2);
        
        // Fetch Active Flash Sale
        require_once PATH_MODEL . 'FlashSaleModel.php';
        $flashSaleModel = new FlashSaleModel();
        $activeFlashSale = $flashSaleModel->getActiveFlashSale();
        $flashSaleItems = [];
        if ($activeFlashSale) {
            $flashSaleItems = $flashSaleModel->getFlashSaleItems($activeFlashSale['id']);
        }
        
        $view = 'client/home';
        require_once PATH_VIEW . 'layouts/client_layout.php';
    }

    public function about()
    {
        $view = 'client/about';
        $title = 'Về Chúng Tôi - Gentech';
        require_once PATH_VIEW . 'layouts/client_layout.php';
    }

    public function news()
    {
        require_once PATH_MODEL . 'NewsModel.php';
        require_once PATH_MODEL . 'NewsCategoryModel.php';
        
        $newsModel = new NewsModel();
        $categoryModel = new NewsCategoryModel();

        $featuredNews = $newsModel->getFeaturedNews();
        $activeNews = $newsModel->getActiveNews(6); // Get latest 6 news
        $categories = $categoryModel->getActiveCategories();

        $view = 'client/news';
        $title = 'Tin Tức - Gentech';
        require_once PATH_VIEW . 'layouts/client_layout.php';
    }

    public function newsDetail()
    {
        $slug = $_GET['slug'] ?? '';
        if (!$slug) {
            header('Location: ?action=news');
            exit;
        }

        require_once PATH_MODEL . 'NewsModel.php';
        $newsModel = new NewsModel();
        $article = $newsModel->getNewsBySlug($slug);

        if (!$article) {
            header('Location: ?action=news');
            exit;
        }

        // Increment views
        $newsModel->incrementViews($article['id']);

        $view = 'client/news_detail';
        $title = $article['title'] . ' - Gentech Tin Tức';
        require_once PATH_VIEW . 'layouts/client_layout.php';
    }

    public function support()
    {
        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once PATH_MODEL . 'ContactModel.php';
            $contactModel = new ContactModel();

            $data = [
                'fullname' => $_POST['fullname'] ?? '',
                'phone' => $_POST['phone'] ?? '',
                'order_id' => !empty($_POST['order_id']) ? $_POST['order_id'] : null,
                'product_model' => !empty($_POST['product_model']) ? $_POST['product_model'] : null,
                'serial_number' => !empty($_POST['serial_number']) ? $_POST['serial_number'] : null,
                'type' => $_POST['type'] ?? '',
                'priority' => $_POST['priority'] ?? 'normal',
                'message' => $_POST['message'] ?? '',
                'attached_file' => null
            ];

            // Handle file upload
            if (isset($_FILES['attached_file']) && $_FILES['attached_file']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'assets/uploads/supports/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = time() . '_' . basename($_FILES['attached_file']['name']);
                $targetFilePath = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['attached_file']['tmp_name'], $targetFilePath)) {
                    $data['attached_file'] = $fileName;
                }
            }

            // Basic validation
            if (empty($data['fullname']) || empty($data['phone']) || empty($data['message'])) {
                $_SESSION['error'] = 'Vui lòng điền đầy đủ Họ tên, Số điện thoại và Nội dung.';
            } else {
                if ($contactModel->addContact($data)) {
                    $_SESSION['success'] = 'Cảm ơn bạn! Yêu cầu hỗ trợ đã được gửi thành công. Chúng tôi sẽ liên hệ lại sớm nhất.';
                } else {
                    $_SESSION['error'] = 'Có lỗi xảy ra khi gửi yêu cầu. Vui lòng thử lại sau.';
                }
            }
            
            header('Location: ?action=support');
            exit;
        }

        $view = 'client/support';
        $title = 'Hỗ Trợ - Gentech';
        require_once PATH_VIEW . 'layouts/client_layout.php';
    }

    public function products()
    {
        require_once PATH_MODEL . 'ProductModel.php';
        require_once PATH_MODEL . 'CategoryModel.php';
        require_once PATH_MODEL . 'BrandModel.php';
        
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();
        $brandModel = new BrandModel();
        
        // Setup pagination
        $limit = 12; // Lấy 12 sản phẩm
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
        
        // Handle category_id from menu links
        $cats = isset($_GET['categories']) && is_array($_GET['categories']) ? $_GET['categories'] : [];
        if (isset($_GET['category_id']) && !in_array($_GET['category_id'], $cats)) {
            $cats[] = $_GET['category_id'];
            $_GET['categories'] = $cats; // Sync back to $_GET for the view
        }

        // Parse filters from URL
        $filters = [
            'keyword' => $_GET['keyword'] ?? '',
            'categories' => $cats,
            'brands' => isset($_GET['brands']) && is_array($_GET['brands']) ? $_GET['brands'] : [],
            'attributeValues' => isset($_GET['attributes']) && is_array($_GET['attributes']) ? $_GET['attributes'] : [], // Changed from attributeValues to attributes in GET for shorter URL
            'minPrice' => isset($_GET['price_min']) ? (float)$_GET['price_min'] : 0,
            'maxPrice' => isset($_GET['price_max']) ? (float)$_GET['price_max'] : 0,
            'minRating' => isset($_GET['min_rating']) ? (int)$_GET['min_rating'] : 0,
            'inStock' => isset($_GET['in_stock']) ? true : false,
            'minWarranty' => isset($_GET['min_warranty']) ? (int)$_GET['min_warranty'] : 0,
            'sort' => $_GET['sort'] ?? ''
        ];

        // Ensure grouped attribute array if submitted as group (e.g. attributes[attr_id][]=value_id)
        // If it's a flat array, the model handles it gracefully as AND condition.
        
        $products = $productModel->getProductsFiltered($filters, $limit, $offset);
        $totalProducts = $productModel->countProductsFiltered($filters);
        
        // Fetch data for filter sidebar
        $allCategories = $categoryModel->getAllCategories();
        $allBrands = $brandModel->getAllBrands();
        $allAttributes = $productModel->getAttributesForFilter();
        
        // Fetch Banner for product page
        require_once PATH_MODEL . 'BannerModel.php';
        $bannerModel = new BannerModel();
        $productBanners = $bannerModel->getActiveBannersByPosition('product_page_banner');
        
        $view = 'client/products';
        $title = 'Tất Cả Sản Phẩm - Gentech';
        require_once PATH_VIEW . 'layouts/client_layout.php';
    }

    public function productDetail()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id <= 0) {
            header('Location: ?action=products');
            exit;
        }

        require_once PATH_MODEL . 'ProductModel.php';
        require_once PATH_MODEL . 'ReviewModel.php';
        $productModel = new ProductModel();
        $reviewModel = new ReviewModel();
        
        $product = $productModel->getProductById($id);
        if (!$product) {
            header('Location: ?action=products');
            exit;
        }

        $images = $productModel->getProductImages($id);
        $attributes = $productModel->getProductAttributes($id);
        $variantsData = $productModel->getVariantsByProductId($id);
        $specs = $productModel->getProductSpecs($id);
        $relatedProducts = $productModel->getProductsByCategory($product['category_id'], 4, $id);

        // --- Reviews Data ---
        $reviews = $reviewModel->getReviewsByProductId($id);
        $ratingData = $reviewModel->getAverageRating($id);
        $avgRating = $ratingData['avg_rating'] ? round($ratingData['avg_rating'], 1) : 0;
        $totalReviews = $ratingData['total_reviews'] ?? 0;
        
        $isEligibleToReview = false;
        $eligibleOrderId = null;
        if (isset($_SESSION['user'])) {
            $eligibleOrderId = $reviewModel->checkEligibilityToReview($_SESSION['user']['user_id'], $id);
            if ($eligibleOrderId) {
                $isEligibleToReview = true;
            }
        }

        $view = 'client/product_detail';
        $title = $product['product_name'] . ' - Gentech';
        require_once PATH_VIEW . 'layouts/client_layout.php';
    }

    public function cart()
    {
        $view = 'client/cart';
        $title = 'Giỏ Hàng - Gentech';
        require_once PATH_VIEW . 'layouts/client_layout.php';
    }

    public function checkout()
    {
        $view = 'client/checkout';
        $title = 'Thanh Toán - Gentech';
        require_once PATH_VIEW . 'layouts/client_layout.php';
    }

    public function profile()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ?action=login');
            exit;
        }

        require_once PATH_MODEL . 'OrderModel.php';
        $orderModel = new OrderModel();
        
        $userId = $_SESSION['user']['user_id'];
        
        // Lấy 1 đơn hàng gần nhất
        $recentOrdersList = $orderModel->getOrdersByUserId($userId);
        $recentOrders = array_slice($recentOrdersList, 0, 1); // Lấy 1 đơn mới nhất
        
        $view = 'client/profile';
        $title = 'Hồ Sơ Cá Nhân - Gentech';
        require_once PATH_VIEW . 'layouts/client_layout.php';
    }

    public function orderHistory()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ?action=login');
            exit;
        }

        require_once PATH_MODEL . 'OrderModel.php';
        $orderModel = new OrderModel();
        
        $userId = $_SESSION['user']['user_id'];
        $statusFilter = $_GET['status'] ?? 'all';
        
        $orders = $orderModel->getOrdersByUserIdAndStatus($userId, $statusFilter);
        
        $view = 'client/order_history';
        $title = 'Lịch Sử Mua Hàng - Gentech';
        require_once PATH_VIEW . 'layouts/client_layout.php';
    }

    public function orderDetail()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ?action=login');
            exit;
        }

        $orderId = $_GET['id'] ?? 0;
        if (!$orderId) {
            header('Location: ?action=order-history');
            exit;
        }

        require_once PATH_MODEL . 'OrderModel.php';
        require_once PATH_MODEL . 'OrderDetailModel.php';
        
        $orderModel = new OrderModel();
        $orderDetailModel = new OrderDetailModel();
        
        $order = $orderModel->getOrderById($orderId);
        
        // Kiểm tra xem đơn hàng có thuộc về user hiện tại không
        if (!$order || $order['user_id'] != $_SESSION['user']['user_id']) {
            header('Location: ?action=order-history');
            exit;
        }
        
        $orderDetails = $orderDetailModel->getDetailsByOrderId($orderId);
        
        $view = 'client/order_detail';
        $title = 'Chi Tiết Đơn Hàng - Gentech';
        require_once PATH_VIEW . 'layouts/client_layout.php';
    }

    public function orderCancel()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ?action=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderId = $_POST['order_id'] ?? 0;
            $cancelReason = $_POST['cancel_reason'] ?? '';

            if (!$orderId || empty($cancelReason)) {
                $_SESSION['error'] = 'Vui lòng cung cấp lý do hủy.';
                header('Location: ?action=order-detail&id=' . $orderId);
                exit;
            }

            require_once PATH_MODEL . 'OrderModel.php';
            $orderModel = new OrderModel();
            
            $order = $orderModel->getOrderById($orderId);
            
            // Validate ownership and status
            if ($order && $order['user_id'] == $_SESSION['user']['user_id']) {
                $allowedCancelStatuses = ['pending', 'confirmed', 'processing'];
                if (in_array($order['status'], $allowedCancelStatuses)) {
                    $orderModel->updateOrderStatus($orderId, 'cancelled', $cancelReason);
                    $orderModel->rollbackOrderInventoryAndDiscount($orderId);
                    $_SESSION['success'] = 'Hủy đơn hàng thành công.';
                } else {
                    $_SESSION['error'] = 'Đơn hàng này không thể hủy do đang được giao hoặc đã hoàn thành.';
                }
            } else {
                $_SESSION['error'] = 'Không tìm thấy đơn hàng.';
            }

            header('Location: ?action=order-detail&id=' . $orderId);
            exit;
        }
        
        header('Location: ?action=order-history');
        exit;
    }

    public function orderReturn()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ?action=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderId = $_POST['order_id'] ?? 0;
            $returnReason = $_POST['return_reason'] ?? '';

            if (!$orderId || empty($returnReason)) {
                $_SESSION['error'] = 'Vui lòng cung cấp lý do yêu cầu trả hàng.';
                header('Location: ?action=order-detail&id=' . $orderId);
                exit;
            }
            
            // Handle file uploads
            $uploadedImages = [];
            if (isset($_FILES['return_images']) && !empty($_FILES['return_images']['name'][0])) {
                $files = $_FILES['return_images'];
                $totalFiles = count($files['name']);
                
                if ($totalFiles > 4) {
                    $_SESSION['error'] = 'Chỉ được phép tải lên tối đa 4 ảnh.';
                    header('Location: ?action=order-detail&id=' . $orderId);
                    exit;
                }
                
                $uploadDir = PATH_ROOT . 'assets/uploads/returns/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
                
                for ($i = 0; $i < $totalFiles; $i++) {
                    if ($files['error'][$i] === UPLOAD_ERR_OK) {
                        $tmpName = $files['tmp_name'][$i];
                        $fileName = $files['name'][$i];
                        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                        
                        if (in_array($fileExt, $allowedExtensions)) {
                            $newFileName = uniqid('return_') . '_' . time() . '.' . $fileExt;
                            $destination = $uploadDir . $newFileName;
                            
                            if (move_uploaded_file($tmpName, $destination)) {
                                $uploadedImages[] = 'assets/uploads/returns/' . $newFileName;
                            }
                        }
                    }
                }
            }
            
            $cancelImagesJson = !empty($uploadedImages) ? json_encode($uploadedImages) : null;

            require_once PATH_MODEL . 'OrderModel.php';
            $orderModel = new OrderModel();
            
            $order = $orderModel->getOrderById($orderId);
            
            // Validate ownership and status
            if ($order && $order['user_id'] == $_SESSION['user']['user_id']) {
                if ($order['status'] === 'completed') {
                    // Cập nhật trạng thái thành return_requested và lưu lý do, ảnh vào db
                    $orderModel->updateOrderStatus($orderId, 'return_requested', $returnReason, $cancelImagesJson);
                    $_SESSION['success'] = 'Gửi yêu cầu trả hàng thành công. Vui lòng chờ quản trị viên phê duyệt.';
                } else {
                    $_SESSION['error'] = 'Chỉ có thể yêu cầu trả hàng đối với các đơn hàng đã hoàn thành.';
                }
            } else {
                $_SESSION['error'] = 'Không tìm thấy đơn hàng.';
            }

            header('Location: ?action=order-detail&id=' . $orderId);
            exit;
        }
        
        header('Location: ?action=order-history');
        exit;
    }

    public function postReview()
    {
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        
        if (!isset($_SESSION['user']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            if ($isAjax) { echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập!']); exit; }
            header('Location: ?action=/');
            exit;
        }

        $userId = $_SESSION['user']['user_id'];
        $productId = $_POST['product_id'] ?? 0;
        $rating = $_POST['rating'] ?? 5;
        $content = trim($_POST['content'] ?? '');

        if (!$productId || empty($content)) {
            if ($isAjax) { echo json_encode(['success' => false, 'message' => 'Vui lòng điền nội dung đánh giá.']); exit; }
            $_SESSION['error'] = 'Vui lòng điền nội dung đánh giá.';
            header("Location: ?action=product-detail&id={$productId}");
            exit;
        }

        require_once PATH_MODEL . 'ReviewModel.php';
        $reviewModel = new ReviewModel();

        $orderId = $reviewModel->checkEligibilityToReview($userId, $productId);
        
        if ($orderId) {
            $reviewModel->insertReview($orderId, $productId, $rating, $content);
            if ($isAjax) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Cảm ơn bạn đã đánh giá sản phẩm!',
                    'review' => [
                        'full_name' => htmlspecialchars($_SESSION['user']['full_name']),
                        'content' => nl2br(htmlspecialchars($content)),
                        'rating' => (int)$rating,
                        'review_date' => date('d/m/Y')
                    ]
                ]);
                exit;
            }
            $_SESSION['success'] = 'Cảm ơn bạn đã đánh giá sản phẩm!';
        } else {
            if ($isAjax) { echo json_encode(['success' => false, 'message' => 'Bạn không có quyền đánh giá sản phẩm này.']); exit; }
            $_SESSION['error'] = 'Bạn không có quyền đánh giá sản phẩm này (Chưa mua hoặc đã đánh giá rồi).';
        }

        header("Location: ?action=product-detail&id={$productId}#reviews");
        exit;
    }

    public function clientReplyReview()
    {
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        
        if (!isset($_SESSION['user']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            if ($isAjax) { echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập!']); exit; }
            header('Location: ?action=/');
            exit;
        }

        $userId = $_SESSION['user']['user_id'];
        $reviewId = $_POST['review_id'] ?? 0;
        $productId = $_POST['product_id'] ?? 0;
        $content = trim($_POST['reply_content'] ?? '');

        if (!$reviewId || !$productId || empty($content)) {
            if ($isAjax) { echo json_encode(['success' => false, 'message' => 'Vui lòng nhập nội dung trả lời.']); exit; }
            $_SESSION['error'] = 'Vui lòng nhập nội dung trả lời.';
            header("Location: ?action=product-detail&id={$productId}#reviews");
            exit;
        }

        require_once PATH_MODEL . 'ReviewModel.php';
        $reviewModel = new ReviewModel();

        if ($reviewModel->addReply($reviewId, $userId, $content, 0)) {
            if ($isAjax) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Gửi trả lời thành công!',
                    'reply' => [
                        'full_name' => htmlspecialchars($_SESSION['user']['full_name']),
                        'content' => nl2br(htmlspecialchars($content)),
                        'created_at' => date('H:i - d/m/Y')
                    ]
                ]);
                exit;
            }
            $_SESSION['success'] = 'Gửi trả lời thành công!';
        } else {
            if ($isAjax) { echo json_encode(['success' => false, 'message' => 'Gửi trả lời thất bại, vui lòng thử lại.']); exit; }
            $_SESSION['error'] = 'Gửi trả lời thất bại, vui lòng thử lại.';
        }

        header("Location: ?action=product-detail&id={$productId}#reviews");
        exit;
    }
}