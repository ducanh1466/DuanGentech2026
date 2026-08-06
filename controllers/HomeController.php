<?php

class HomeController
{
    public function index()
    {
        $view = 'client/home';
        require_once PATH_VIEW . 'layouts/client_layout.php';
    }
}