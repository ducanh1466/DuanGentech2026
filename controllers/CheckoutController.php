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
    private $discountModel;

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

        require_once PATH_MODEL . 'DiscountModel.php';
        $this->discountModel = new DiscountModel();
        $this->discountModel->pdo = $sharedPdo;
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
        $subTotal = $totalAmount; // Lưu lại để tính phí ship

        // Lấy danh sách mã giảm giá
        $activeDiscounts = $this->discountModel->getActiveDiscounts();
        
        // Kiểm tra mã đang áp dụng
        $appliedDiscount = null;
        $discountAmount = 0;
        if (isset($_SESSION['discount'])) {
            $validation = $this->discountModel->validateDiscount($_SESSION['discount']['code'], $totalAmount, $userId);
            if ($validation['status']) {
                $appliedDiscount = $validation['discount'];
                $discountAmount = $validation['discount_amount'];
                $totalAmount = $validation['new_total'];
            } else {
                unset($_SESSION['discount']);
            }
        }

        // Tính phí vận chuyển (dựa trên $subTotal ban đầu)
        $shippingFee = ($subTotal >= 1000000) ? 0 : 30000;
        // Cập nhật tổng tiền cuối cùng
        $totalAmount += $shippingFee;

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
            $subTotal = $totalAmount; // Lưu lại để tính phí ship

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
            
            // Xử lý mã giảm giá
            $discountId = null; 
            if (isset($_SESSION['discount'])) {
                $validation = $this->discountModel->validateDiscount($_SESSION['discount']['code'], $totalAmount, $userId);
                if ($validation['status']) {
                    $discountId = $validation['discount']['discount_id'];
                    $totalAmount = $validation['new_total'];
                } else {
                    unset($_SESSION['discount']);
                }
            }
            
            // Tính phí vận chuyển (dựa trên $subTotal ban đầu)
            $shippingFee = ($subTotal >= 1000000) ? 0 : 30000;
            $totalAmount += $shippingFee;
            
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
                    'unpaid',
                    $shippingFee
                );

                if (!$orderId) {
                    throw new Exception("Lỗi: Không thể tạo đơn hàng!");
                }

                // Ghi lại việc sử dụng mã giảm giá
                if ($discountId) {
                    $this->discountModel->recordUsage($discountId, $userId, $orderId);
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
                    
                    // Trừ tồn kho biến thể
                    $this->productModel->reduceVariantStock($variantId, $quantityToBuy);

                    // Trừ tồn kho sản phẩm gốc
                    $productId = $item['product_id'];
                    $this->productModel->reduceProductStock($productId, $quantityToBuy);

                    // Thêm vào chi tiết đơn hàng
                    $this->orderDetailModel->insertOrderDetail(
                        $orderId, 
                        $variantId, 
                        $variantId, 
                        $quantityToBuy, 
                        $item['price']
                    );
                    
                    // Nếu là sản phẩm Flash Sale, tăng số lượng đã bán (sold)
                    if (isset($item['is_flash_sale']) && $item['is_flash_sale']) {
                        require_once PATH_MODEL . 'FlashSaleModel.php';
                        $flashSaleModel = new FlashSaleModel();
                        $flashSaleModel->incrementFlashSaleSold($item['product_id'], $quantityToBuy);
                    }

                    // Xóa sản phẩm ĐÃ MUA khỏi giỏ hàng
                    $this->cartModel->removeItem($item['cart_item_id']);
                }
                
                // COMMIT TRANSACTION
                $pdo->commit();

                // Xóa session selected_items sau khi mua thành công
                unset($_SESSION['selected_items']);

                // 4. Chuyển hướng tới trang thành công hoặc cổng thanh toán
                if ($paymentMethod === 'vnpay') {
                    $this->createVnPayUrl($orderId, $totalAmount);
                } else if (in_array($paymentMethod, ['momo', 'zalopay', 'applepay'])) {
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

    private function createVnPayUrl($orderId, $amount)
    {
        // VNPAY yêu cầu thời gian phải theo múi giờ Việt Nam
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        
        $vnp_TxnRef = $orderId; 
        $vnp_OrderInfo = 'Thanh toan don hang: ' . $orderId;
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $amount * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = '';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        if ($vnp_IpAddr == '::1' || $vnp_IpAddr == 'localhost') {
            $vnp_IpAddr = '127.0.0.1'; // VNPAY không chấp nhận định dạng IPv6 ::1 ở môi trường test
        }
        
        $startTime = date("YmdHis");
        $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));
        
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => VNP_TMN_CODE,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => $startTime,
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => VNP_RETURN_URL,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $expire
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = VNP_URL . "?" . $query;
        if (VNP_HASH_SECRET) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, VNP_HASH_SECRET);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        
        header('Location: ' . $vnp_Url);
        exit();
    }

    public function vnpayReturn()
    {
        $vnp_SecureHash = $_GET['vnp_SecureHash'] ?? '';
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, VNP_HASH_SECRET);
        $orderId = $_GET['vnp_TxnRef'] ?? 0;
        $vnp_ResponseCode = $_GET['vnp_ResponseCode'] ?? '';
        $amount = ($_GET['vnp_Amount'] ?? 0) / 100;

        if ($secureHash == $vnp_SecureHash) {
            if ($vnp_ResponseCode == '00') {
                // Thanh toán thành công
                $this->orderModel->updatePaymentStatus($orderId, 'paid');
                $this->orderModel->updateOrderStatus($orderId, 'processing');
                
                require_once PATH_MODEL . 'PaymentModel.php';
                $paymentModel = new PaymentModel();
                $paymentModel->pdo = $this->orderModel->getPdo();
                $paymentModel->insertPayment($orderId, 'vnpay', $amount, 'success');
                
                header('Location: ?action=checkout-success&id=' . $orderId);
                exit;
            } else {
                // Thanh toán lỗi hoặc bị hủy
                $_SESSION['error'] = "Thanh toán VNPAY thất bại hoặc bị hủy.";
                header('Location: ?action=cart');
                exit;
            }
        } else {
            $_SESSION['error'] = "Lỗi bảo mật: Sai chữ ký VNPAY.";
            header('Location: ?action=cart');
            exit;
        }
    }

    public function applyDiscountAjax()
    {
        header('Content-Type: application/json');
        if (!isset($_SESSION['user'])) {
            echo json_encode(['error' => 1, 'message' => 'Bạn cần đăng nhập để dùng mã giảm giá!']);
            return;
        }

        $code = trim($_POST['code'] ?? '');
        if (empty($code)) {
            echo json_encode(['error' => 1, 'message' => 'Vui lòng nhập mã giảm giá!']);
            return;
        }

        // Tính tổng tiền giỏ hàng hiện tại (chỉ những món được chọn)
        $userId = $_SESSION['user']['user_id'];
        $cartId = $this->cartModel->getOrCreateCartId($userId);
        $allCartItems = $this->cartModel->getCartItems($cartId);
        $selectedItems = $_SESSION['selected_items'] ?? [];
        
        $cartItems = array_filter($allCartItems, function($item) use ($selectedItems) {
            return in_array($item['cart_item_id'], $selectedItems);
        });

        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        if ($totalAmount == 0) {
            echo json_encode(['error' => 1, 'message' => 'Giỏ hàng trống!']);
            return;
        }

        $validation = $this->discountModel->validateDiscount($code, $totalAmount, $userId);

        if (!$validation['status']) {
            echo json_encode(['error' => 1, 'message' => $validation['message']]);
            return;
        }

        // Lưu vào session
        $_SESSION['discount'] = [
            'code' => $code,
            'discount_amount' => $validation['discount_amount']
        ];

        echo json_encode([
            'error' => 0,
            'message' => 'Áp dụng mã giảm giá thành công!',
            'discount_amount' => $validation['discount_amount'],
            'new_total' => $validation['new_total']
        ]);
    }

    public function removeDiscountAjax()
    {
        header('Content-Type: application/json');
        if (isset($_SESSION['discount'])) {
            unset($_SESSION['discount']);
        }
        echo json_encode([
            'error' => 0,
            'message' => 'Đã gỡ mã giảm giá!'
        ]);
    }
}
