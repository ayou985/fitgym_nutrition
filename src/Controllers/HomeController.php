<?php

namespace App\Controllers;

class HomeController
{
  public function index()
  {
  session_start();
    require_once(__DIR__ . '/../Views/home.view.php');
  }
}
