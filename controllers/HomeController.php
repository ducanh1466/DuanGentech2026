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
        require_once PATH_MODEL . 'CategoryModel.php';
        require_once PATH_MODEL . 'BrandModel.php';
        
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();
        $brandModel = new BrandModel();
        
        // Setup pagination
        $limit = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
        
        // Parse filters from URL
        $filters = [
            'keyword' => $_GET['keyword'] ?? '',
            'categories' => isset($_GET['categories']) && is_array($_GET['categories']) ? $_GET['categories'] : [],
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