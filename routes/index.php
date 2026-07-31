<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    '/'         => (new HomeController)->index(),
    
    'admin'                => (new AdminController)->dashboard(),
    'admin-categories'     => (new AdminController)->categories(),
    'admin-category-form'  => (new AdminController)->categoryForm(),
    'admin-category-detail'=> (new AdminController)->categoryDetail(),
    'admin-category-create'=> (new AdminController)->categoryCreate(),
    'admin-category-update'=> (new AdminController)->categoryUpdate(),
    'admin-category-delete'=> (new AdminController)->categoryDelete(),
    'admin-brands'         => (new AdminController)->brands(),
    'admin-brand-form'     => (new AdminController)->brandForm(),
    'admin-brand-detail'   => (new AdminController)->brandDetail(),
    'admin-brand-create'   => (new AdminController)->brandCreate(),
    'admin-brand-update'   => (new AdminController)->brandUpdate(),
    'admin-brand-delete'   => (new AdminController)->brandDelete(),
    'admin-products'       => (new AdminController)->products(),
    'admin-product-create' => (new AdminController)->productForm(),
    'admin-product-edit'   => (new AdminController)->productForm(),
};
