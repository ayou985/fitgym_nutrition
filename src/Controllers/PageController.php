<?php

namespace App\Controllers;

class PageController
{
    public function home()
    {
        include_once __DIR__ . "/../Views/home.view.php";
    }

    public function product()
    {
        (require_once __DIR__ . "/../Views/product.view.php");
    }
    
    public function about() {  
        include_once __DIR__ . "/../Views/about.view.php"; 
    }

    public function contact()
    {
        include_once __DIR__ . "/../Views/contact.view.php";
    }

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
        require_once(__DIR__ . '/../Views/home.view.php');
    }
}

