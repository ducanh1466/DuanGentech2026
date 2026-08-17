<?php
require_once PATH_MODEL . 'CartModel.php';
require_once PATH_MODEL . 'ProductModel.php';

class CartController
{
    private $cartModel;
    private $productModel;

    public function __construct()
    {
        $this->cartModel = new CartModel();
        $this->productModel = new ProductModel();
    }

    // Hiển thị giỏ hàng
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ?action=login');
            exit;
        }

        $userId = $_SESSION['user']['user_id'];
        $cartId = $this->cartModel->getOrCreateCartId($userId);
        $cartItems = $this->cartModel->getCartItems($cartId);

        // Tính tổng tiền
        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        $view = 'client/cart';
        $title = 'Giỏ Hàng - Gentech';
        require_once PATH_VIEW . 'layouts/client_layout.php';
    }

    // Thêm sản phẩm vào giỏ
    public function add()
    {
        if (!isset($_SESSION['user'])) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode([
                    'status' => 'error', 
                    'message' => 'Vui lòng đăng nhập để thêm vào giỏ hàng!'
                ]);
                exit;
            }
            header('Location: ?action=login');
            exit;
        }

        $userId = $_SESSION['user']['user_id'];
        $variantId = $_POST['variant_id'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;

        if (!$variantId || $quantity <= 0) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode([
                    'status' => 'error', 
                    'message' => 'Sản phẩm không hợp lệ hoặc chưa có phiên bản!'
                ]);
                exit;
            }
            $_SESSION['error'] = 'Sản phẩm không hợp lệ!';
            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '?action=products'));
            exit;
        }

        $addedItemId = 0;
        // Kiểm tra số lượng tồn kho
        $stock = $this->productModel->getVariantStock($variantId);
        $cartId = $this->cartModel->getOrCreateCartId($userId);
        
        // Tính tổng số lượng dự kiến sau khi thêm (có thể đã có trong giỏ hàng)
        // Tuy nhiên, logic hiện tại addItem sẽ tự cộng thêm quantity. 
        // Ta tạm kiểm tra quantity có vượt stock hiện tại hay không trước
        if ($quantity > $stock) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode([
                    'status' => 'error', 
                    'message' => 'Số lượng sản phẩm trong kho không đủ!'
                ]);
                exit;
            } else {
                $_SESSION['error'] = 'Số lượng sản phẩm trong kho không đủ!';
                header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '?action=products'));
                exit;
            }
        }
        
        $addedItemId = $this->cartModel->addItem($cartId, $variantId, $quantity);

        // Tính lại số lượng sản phẩm trong giỏ để trả về cho AJAX cập nhật badge
        $cartItems = $this->cartModel->getCartItems($cartId ?? 0);
        $totalItems = count($cartItems);

        // Nếu là request ajax thì trả về JSON, nếu không thì redirect
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            echo json_encode([
                'status' => 'success', 
                'message' => 'Đã thêm vào giỏ hàng',
                'cart_count' => $totalItems
            ]);
            exit;
        }

        $actionType = $_POST['action_type'] ?? 'add_to_cart';

        if ($actionType === 'buy_now') {
            header('Location: ?action=cart&tick=' . $addedItemId);
            exit;
        } else {
            // "add_to_cart" -> Quay lại trang chi tiết sản phẩm
            $referer = $_SERVER['HTTP_REFERER'] ?? '?action=products';
            header('Location: ' . $referer);
            exit;
        }
    }

    // Cập nhật số lượng
    public function update()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ?action=login');
            exit;
        }

        $cartItemId = $_POST['cart_item_id'] ?? null;
        $quantity = $_POST['quantity'] ?? null;
        $variantId = $_POST['variant_id'] ?? null;

        if ($cartItemId && $quantity > 0 && $variantId) {
            $stock = $this->productModel->getVariantStock($variantId);
            if ($quantity > $stock) {
                $_SESSION['error'] = 'Số lượng sản phẩm trong kho không đủ!';
                // Giới hạn quantity về mức tối đa
                $quantity = $stock;
            }
            if ($quantity > 0) {
                $this->cartModel->updateItemQuantity($cartItemId, $quantity);
            }
        }

        header('Location: ?action=cart');
        exit;
    }

    // Xóa sản phẩm khỏi giỏ
    public function remove()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ?action=login');
            exit;
        }

        $cartItemId = $_POST['cart_item_id'] ?? null;

        if ($cartItemId) {
            $this->cartModel->removeItem($cartItemId);
        }

        header('Location: ?action=cart');
        exit;
    }
}
