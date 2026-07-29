<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    '/'         => (new HomeController)->index(),

        //admin
    'admin'                 => (new AdminController)->dashboard(),
    'admin-users' => (new AdminController())->users(),
    'admin-user-create',
    'admin-user-edit' => (new AdminController())->userForm(),
    
};