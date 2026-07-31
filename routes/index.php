<?php

$action = $_GET['action'] ?? '/';


match ($action) {
    '/'         => (new HomeController)->index(),
    
    'admin'                => (new AdminController)->dashboard(),
    'admin-categories'     => (new AdminController)->categories(),
    'admin-brands'         => (new AdminController)->brands(),
    'admin-products'       => (new AdminController)->products(),
    'admin-product-create' => (new AdminController)->createProduct(),
    'admin-product-edit'   => (new AdminController)->editProduct(),
    'admin-product-delete' => (new AdminController)->deleteProduct(),
};
