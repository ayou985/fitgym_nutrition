<?php

require "vendor/autoload.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use Config\Router;

$router = new Router();

// 🌍 Routes principales
$router->addRoute('/', 'HomeController', 'index');
$router->addRoute('/product', 'PageController', 'product');
$router->addRoute('/about', 'PageController', 'about');
$router->addRoute('/contact', 'PageController', 'contact');

// 🔐 Routes d'inscription et de connexion
$router->addRoute('/register', 'RegisterController', 'index');
$router->addRoute('/login', 'LoginController', 'login');
$router->addRoute('/logout', 'LogoutController', 'logout');

// 🔑 Routes AuthController
$router->addRoute('/auth/suggest-password', 'AuthController', 'suggestPassword');
$router->addRoute('/auth/verify', 'AuthController', 'verifyAuth');


// 🚀 Gérer la requête actuelle
$router->handleRequest();
