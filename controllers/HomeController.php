<?php

class HomeController
{
    public function index()
    {
        require_once PATH_MODEL . 'ProductModel.php';
        require_once PATH_MODEL . 'BannerModel.php';
        
        $productModel = new ProductModel();
        $bannerModel = new BannerModel();
        
        $latestProducts = $productModel->getLatestProducts(8);
        $bestSellers = $productModel->getBestSellingProducts(8);
        
        // Fetch banners
        $heroBanners = $bannerModel->getActiveBannersByPosition('hero_slider');
        $promoBanners = $bannerModel->getActiveBannersByPosition('promo_banner', 2);
        
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
        $view = 'client/news';
        $title = 'Tin Tức - Gentech';
        require_once PATH_VIEW . 'layouts/client_layout.php';
    }

    public function support()
    {
        $view = 'client/support';
        $title = 'Hỗ Trợ - Gentech';
        require_once PATH_VIEW . 'layouts/client_layout.php';
    }

    public function products()
    {
        require_once PATH_MODEL . 'ProductModel.php';
        $productModel = new ProductModel();
        
        // Setup pagination
        $limit = 12;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
        
        $products = $productModel->getProductsFiltered('', [], [], [], 0, 0, '', $limit, $offset);
        $totalProducts = $productModel->countProductsFiltered('', [], [], [], 0, 0);
        
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
        $productModel = new ProductModel();
        
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
        $view = 'client/profile';
        $title = 'Hồ Sơ Cá Nhân - Gentech';
        require_once PATH_VIEW . 'layouts/client_layout.php';
    }
}