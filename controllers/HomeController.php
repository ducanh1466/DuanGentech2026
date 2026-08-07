<?php

class HomeController
{
    public function index()
    {
        require_once PATH_MODEL . 'ProductModel.php';
        $productModel = new ProductModel();
        
        $latestProducts = $productModel->getLatestProducts(8);
        $bestSellers = $productModel->getBestSellingProducts(8);
        
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
        $view = 'client/products';
        $title = 'Tất Cả Sản Phẩm - Gentech';
        require_once PATH_VIEW . 'layouts/client_layout.php';
    }

    public function productDetail()
    {
        $view = 'client/product_detail';
        $title = 'Chi Tiết Sản Phẩm - Gentech';
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