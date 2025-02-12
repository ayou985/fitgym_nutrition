<?php

namespace App\Controllers;

class HomeController
{
  public function index()
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
  }
    require_once(__DIR__ . '/../Views/home.view.php');
  }
}
