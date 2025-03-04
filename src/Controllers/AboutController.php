<?php

namespace App\Controllers;

class AboutController
{
    public function about()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        require_once(__DIR__ . '/../Views/about.view.php');
    }
}
