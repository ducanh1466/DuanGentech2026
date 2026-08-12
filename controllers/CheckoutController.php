<?php
require_once PATH_MODEL . 'CartModel.php';
require_once PATH_MODEL . 'OrderModel.php';
require_once PATH_MODEL . 'OrderDetailModel.php';

class CheckoutController
{
    private $cartModel;
    private $orderModel;
    private $orderDetailModel;

    private $productModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        
        // Share the SAME database connection across models to prevent transaction deadlocks/foreign key issues
        $sharedPdo = $this->orderModel->getPdo();
        
        $this->cartModel = new CartModel();
        $this->cartModel->pdo = $sharedPdo;
        
        $this->orderDetailModel = new OrderDetailModel();
        $this->orderDetailModel->pdo = $sharedPdo;
        
        // Cần thêm ProductModel để lấy và trừ tồn kho
        require_once PATH_MODEL . 'ProductModel.php';
        $this->productModel = new ProductModel();
        $this->productModel->pdo = $sharedPdo;
    }

    // Hiển thị trang thanh toán
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ?action=login');
            exit;
        }

        $user = $_SESSION['user'];
        $userId = $user['user_id'];
        
        $cartId = $this->cartModel->getOrCreateCartId($userId);
        $allCartItems = $this->cartModel->getCartItems($cartId);

        // Xử lý các item được chọn từ giỏ hàng
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_items'])) {
            $_SESSION['selected_items'] = $_POST['selected_items'];
        }

        $selectedItems = $_SESSION['selected_items'] ?? [];

        if (empty($selectedItems)) {
            // Không có món nào được chọn, quay lại giỏ
            header('Location: ?action=cart');
            exit;
        }

        // Lọc giỏ hàng chỉ lấy những món được chọn
        $cartItems = array_filter($allCartItems, function($item) use ($selectedItems) {
            return in_array($item['cart_item_id'], $selectedItems);
        });

        if (empty($cartItems)) {
            header('Location: ?action=cart');
            exit;
        }

        // Tính tổng tiền
        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        $view = 'client/checkout';
        $title = 'Thanh Toán - Gentech';
        require_once PATH_VIEW . 'layouts/client_layout.php';
    }

    // Xử lý submit đặt hàng
    public function process()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ?action=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user']['user_id'];
            
            $cartId = $this->cartModel->getOrCreateCartId($userId);
            $allCartItems = $this->cartModel->getCartItems($cartId);

            $selectedItems = $_SESSION['selected_items'] ?? [];
            if (empty($selectedItems)) {
                header('Location: ?action=cart');
                exit;
            }

            // Lọc giỏ hàng chỉ lấy những món được chọn
            $cartItems = array_filter($allCartItems, function($item) use ($selectedItems) {
                return in_array($item['cart_item_id'], $selectedItems);
            });

            if (empty($cartItems)) {
                header('Location: ?action=cart');
                exit;
            }

            // Tính tổng tiền
            $totalAmount = 0;
            foreach ($cartItems as $item) {
                $totalAmount += $item['price'] * $item['quantity'];
            }

            // Nhận dữ liệu từ form
            $recipientName = trim($_POST['recipient_name'] ?? '');
            $recipientPhone = trim($_POST['recipient_phone'] ?? '');
            
            // Xử lý địa chỉ nối chuỗi
            $street = trim($_POST['street_address'] ?? '');
            $ward = trim($_POST['ward_name'] ?? '');
            $district = trim($_POST['district_name'] ?? '');
            $province = trim($_POST['province_name'] ?? '');
            
            $shippingAddressArray = array_filter([$street, $ward, $district, $province]);
            $shippingAddress = implode(', ', $shippingAddressArray);
            
            $note = trim($_POST['note'] ?? '');
            $paymentMethod = $_POST['payment_method'] ?? 'cod';
            
            // Lưu địa chỉ cho lần mua kế tiếp
            if (isset($_POST['save_address']) && $_POST['save_address'] == '1') {
                require_once PATH_MODEL . 'UserModel.php';
                $userModel = new UserModel();
                $userModel->updateUserCheckoutProfile($userId, $recipientName, $recipientPhone, $shippingAddress);
                
                // Cập nhật lại session để lần sau reload không bị mất
                $_SESSION['user']['full_name'] = $recipientName;
                $_SESSION['user']['phone'] = $recipientPhone;
                $_SESSION['user']['address'] = $shippingAddress;
            }
            
            // Xử lý mã giảm giá (ở phiên bản này để trống phần xử lý giảm giá phức tạp)
            $discountId = null; 
            
            // Bắt đầu TRANSACTION
            $pdo = $this->orderModel->getPdo();
            try {
                $pdo->beginTransaction();

                // 1. Tạo đơn hàng
                $orderId = $this->orderModel->insertOrder(
                    $userId, 
                    $discountId, 
                    $totalAmount, 
                    'pending', 
                    $recipientName, 
                    $recipientPhone, 
                    $shippingAddress, 
                    $note, 
                    $paymentMethod, 
                    'unpaid'
                );

                if (!$orderId) {
                    throw new Exception("Lỗi: Không thể tạo đơn hàng!");
                }

                // 2. Kiểm tra tồn kho và chuyển từ giỏ hàng sang chi tiết đơn hàng
                foreach ($cartItems as $item) {
                    $variantId = $item['variant_id'];
                    $quantityToBuy = $item['quantity'];
                    
                    // Kiểm tra tồn kho lần cuối
                    $currentStock = $this->productModel->getVariantStock($variantId);
                    if ($currentStock < $quantityToBuy) {
                        throw new Exception("Rất tiếc! Sản phẩm '" . htmlspecialchars($item['product_name']) . "' hiện chỉ còn " . $currentStock . " sản phẩm trong kho. Vui lòng quay lại giỏ hàng để cập nhật số lượng.");
                    }
                    
                    // Trừ tồn kho
                    $this->productModel->reduceVariantStock($variantId, $quantityToBuy);

                    // Thêm vào chi tiết đơn hàng
                    $this->orderDetailModel->insertOrderDetail(
                        $orderId, 
                        $variantId, 
                        $variantId, 
                        $quantityToBuy, 
                        $item['price']
                    );
                    
                    // Xóa sản phẩm ĐÃ MUA khỏi giỏ hàng
                    $this->cartModel->removeItem($item['cart_item_id']);
                }
                
                // COMMIT TRANSACTION
                $pdo->commit();

                // Xóa session selected_items sau khi mua thành công
                unset($_SESSION['selected_items']);

                // 4. Chuyển hướng tới trang thành công hoặc cổng thanh toán
                if (in_array($paymentMethod, ['vnpay', 'momo', 'zalopay', 'applepay'])) {
                    header('Location: ?action=payment-mock&method=' . $paymentMethod . '&order_id=' . $orderId);
                } else {
                    header('Location: ?action=checkout-success&id=' . $orderId);
                }
                exit;

            } catch (Exception $e) {
                // Hủy transaction nếu có lỗi
                $pdo->rollBack();
                
                // Lưu lỗi vào session và chuyển về giỏ hàng
                $_SESSION['error'] = $e->getMessage();
                header('Location: ?action=cart');
                exit;
            }
        }
    }

    public function success()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ?action=login');
            exit;
        }

        $orderId = $_GET['id'] ?? 0;
        
        $view = 'client/checkout_success';
        $title = 'Đặt hàng thành công - Gentech';
        require_once PATH_VIEW . 'layouts/client_layout.php';
    }

    // Giao diện cổng thanh toán online (Mock) chung cho tất cả các ví
    public function paymentMock()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ?action=login');
            exit;
        }

        $orderId = $_GET['order_id'] ?? 0;
        $method = $_GET['method'] ?? 'vnpay'; // mặc định là vnpay
        
        if (!$orderId) {
            header('Location: ?action=cart');
            exit;
        }

        $order = $this->orderModel->getOrderById($orderId);
        
        $view = 'client/payment_mock';
        $title = 'Cổng thanh toán Online';
        // Trang mock nên ta không cần layout chuẩn của client, có thể include trực tiếp hoặc dùng layout rỗng.
        // Để đơn giản, ta vẫn gán view nhưng lát trong file payment_mock.php ta sẽ viết full HTML và exit luôn.
        require_once PATH_VIEW . 'client/payment_mock.php';
        exit; // Dừng luôn để không load layout
    }

    // Xử lý xác nhận thanh toán giả lập chung
    public function paymentProcess()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ?action=login');
            exit;
        }

        $orderId = $_POST['order_id'] ?? 0;
        
        if ($orderId) {
            // Cập nhật trạng thái thanh toán thành công
            $this->orderModel->updatePaymentStatus($orderId, 'paid');
            // Cập nhật trạng thái đơn hàng sang chờ lấy hàng (processing)
            $this->orderModel->updateOrderStatus($orderId, 'processing');
        }

        header('Location: ?action=checkout-success&id=' . $orderId);
        exit;
    }
}
