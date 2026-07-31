<?php

$action = $_GET['action'] ?? '/';


match ($action) {
    '/' => (new HomeController)->index(),

    'admin' => (new AdminController)->dashboard(),
    'admin-categories' => (new AdminController)->categories(),
    'admin-category-form' => (new AdminController)->categoryForm(),
    'admin-category-detail' => (new AdminController)->categoryDetail(),
    'admin-category-create' => (new AdminController)->categoryCreate(),
    'admin-category-update' => (new AdminController)->categoryUpdate(),
    'admin-category-delete' => (new AdminController)->categoryDelete(),
    'admin-brands' => (new AdminController)->brands(),
    'admin-brand-form' => (new AdminController)->brandForm(),
    'admin-brand-detail' => (new AdminController)->brandDetail(),
    'admin-brand-create' => (new AdminController)->brandCreate(),
    'admin-brand-update' => (new AdminController)->brandUpdate(),
    'admin-brand-delete' => (new AdminController)->brandDelete(),
    'admin-products' => (new AdminController)->products(),
    'admin-product-create' => (new AdminController)->createProduct(),
    'admin-product-edit' => (new AdminController)->editProduct(),
    'admin-product-delete' => (new AdminController)->deleteProduct(),
    'admin-users'         => (new AdminController)->users(),
    'admin-user-create'   => (new AdminController)->createUser(),
    'admin-user-store'    => (new AdminController)->storeUser(),
    'admin-user-edit'     => (new AdminController)->editUser(),
    'admin-user-update'   => (new AdminController)->updateUser(),
    'admin-user-delete'   => (new AdminController)->deleteUser(),
    'admin-user-status'   => (new AdminController)->changeUserStatus(),
};
