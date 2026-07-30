<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    '/'         => (new HomeController)->index(),

        //admin
    'admin'                 => (new AdminController)->dashboard(),
    'admin-categories'      => (new AdminController)->categories(),
    'admin-brands'          => (new AdminController)->brands(),
    'admin-products'        => (new AdminController)->products(),
    'admin-product-create'  => (new AdminController)->productForm(),
    'admin-product-edit'    => (new AdminController)->productForm(),
    

};