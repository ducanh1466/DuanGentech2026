<?php

$action = $_GET['action'] ?? '/';


match ($action) {
    '/' => (new HomeController)->index(),
    'about' => (new HomeController)->about(),
    'news'  => (new HomeController)->news(),
    'news-detail' => (new HomeController)->newsDetail(),
    'support' => (new HomeController)->support(),
    'products' => (new HomeController)->products(),
    'product-detail' => (new HomeController)->productDetail(),
    'cart' => (new CartController)->index(),
    'cart-add' => (new CartController)->add(),
    'cart-update' => (new CartController)->update(),
    'cart-remove' => (new CartController)->remove(),

    'checkout' => (new CheckoutController)->index(),
    'checkout-process' => (new CheckoutController)->process(),
    'checkout-success' => (new CheckoutController)->success(),
    'payment-mock' => (new CheckoutController)->paymentMock(),
    'payment-process' => (new CheckoutController)->paymentProcess(),
    'vnpay-return' => (new CheckoutController)->vnpayReturn(),
    'profile' => (new HomeController)->profile(),
    'order-history' => (new HomeController)->orderHistory(),
    'order-detail' => (new HomeController)->orderDetail(),

    'login'         => (new AuthController)->login(),
    'post-login'    => (new AuthController)->postLogin(),
    'register'      => (new AuthController)->register(),
    'post-register' => (new AuthController)->postRegister(),
    'logout'        => (new AuthController)->logout(),

    'admin'                 => (new AdminController)->dashboard(),
    'admin-categories'      => (new AdminController)->categories(),
    'admin-category-form'   => (new AdminController)->categoryForm(),
    'admin-category-detail' => (new AdminController)->categoryDetail(),
    'admin-category-create' => (new AdminController)->categoryCreate(),
    'admin-category-update' => (new AdminController)->categoryUpdate(),
    'admin-category-delete' => (new AdminController)->categoryDelete(),
    'admin-brands'          => (new AdminController)->brands(),
    'admin-brand-form'      => (new AdminController)->brandForm(),
    'admin-brand-detail'    => (new AdminController)->brandDetail(),
    'admin-brand-create'    => (new AdminController)->brandCreate(),
    'admin-brand-update'    => (new AdminController)->brandUpdate(),
    'admin-brand-delete'    => (new AdminController)->brandDelete(),
    'admin-products'        => (new AdminController)->products(),
    'admin-product-create'  => (new AdminController)->createProduct(),
    'admin-product-edit'    => (new AdminController)->editProduct(),
    'admin-product-delete'  => (new AdminController)->deleteProduct(),
    'admin-users'           => (new AdminController)->users(),
    'admin-user-create'     => (new AdminController)->createUser(),
    'admin-user-store'      => (new AdminController)->storeUser(),
    'admin-user-edit'       => (new AdminController)->editUser(),
    'admin-user-update'     => (new AdminController)->updateUser(),
    'admin-user-delete'     => (new AdminController)->deleteUser(),
    'admin-user-status'     => (new AdminController)->changeUserStatus(),
    'admin-orders'          => (new AdminController)->orders(),
    'admin-order-detail'    => (new AdminController)->orderDetail(),
    'admin-contacts'        => (new AdminController)->contacts(),
    'admin-contact-status'  => (new AdminController)->changeContactStatus(),
    'admin-contact-department' => (new AdminController)->changeContactDepartment(),
    'admin-contact-bulk'    => (new AdminController)->bulkUpdateContacts(),
    'admin-contact-logs'    => (new AdminController)->getContactLogsAjax(),
    
    // --- ATTRIBUTES ROUTING ---
    'admin-attributes'      => (new AdminController)->attributes(),
    'admin-attribute-create' => (new AdminController)->attributeCreate(),
    'admin-attribute-update' => (new AdminController)->attributeUpdate(),
    'admin-attribute-delete' => (new AdminController)->attributeDelete(),
    'admin-attribute-detail'       => (new AdminController)->attributeDetail(),
    'admin-attribute-value-create' => (new AdminController)->attributeValueCreate(),
    'admin-attribute-value-delete' => (new AdminController)->attributeValueDelete(),
    
    // --- BANNERS ROUTING ---
    'admin-banners'         => (new AdminController)->banners(),
    'admin-banner-form'     => (new AdminController)->bannerForm(), // Form dùng chung cho Create & Update
    'admin-banner-create'   => (new AdminController)->bannerCreate(),
    'admin-banner-update'   => (new AdminController)->bannerUpdate(),
    'admin-banner-delete'   => (new AdminController)->bannerDelete(),

    'admin-profile'         => (new AdminController)->profile(),
    'admin-update-profile'  => (new AdminController)->updateProfile(),
    'admin-change-password' => (new AdminController)->changePassword(),
    'admin-update-password' => (new AdminController)->updatePassword(),

    // --- NEWS ROUTING ---
    'admin-news'            => (new AdminController)->news(),
    'admin-news-form'       => (new AdminController)->newsForm(),
    'admin-news-create'     => (new AdminController)->newsCreate(),
    'admin-news-update'     => (new AdminController)->newsUpdate(),
    'admin-news-delete'     => (new AdminController)->newsDelete(),

    // --- NEWS CATEGORIES ROUTING ---
    'admin-news-categories' => (new AdminController)->newsCategories(),
    'admin-news-category-form' => (new AdminController)->newsCategoryForm(),
    'admin-news-category-create' => (new AdminController)->newsCategoryCreate(),
    'admin-news-category-update' => (new AdminController)->newsCategoryUpdate(),
    'admin-news-category-delete' => (new AdminController)->newsCategoryDelete(),
};
