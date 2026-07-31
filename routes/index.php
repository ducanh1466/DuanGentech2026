<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    '/'         => (new HomeController)->index(),

    //admin
    'admin'                 => (new AdminController)->dashboard(),
    'admin-users'         => (new AdminController)->users(),
    'admin-user-create'   => (new AdminController)->createUser(),
    'admin-user-store'    => (new AdminController)->storeUser(),
    'admin-user-edit'     => (new AdminController)->editUser(),
    'admin-user-update'   => (new AdminController)->updateUser(),
    'admin-user-delete'   => (new AdminController)->deleteUser(),
    'admin-user-status'   => (new AdminController)->changeUserStatus(),
};