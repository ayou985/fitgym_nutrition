<?php

namespace App\Controllers;

class AboutController
{
    public function about()
    {
        require_once(__DIR__ . '/../Views/about.view.php');
    }
}
