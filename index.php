<?php

require "vendor/autoload.php";


session_start();


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

// 📝 Routes pour le CRUD AllArticle
$router->addRoute('/create', 'AllArticlesController', 'create');
$router->addRoute('/edit', 'AllArticlesController', 'edit');
$router->addRoute('/delete', 'AllArticlesController', 'delete');

// 🚀 Gérer la requête actuelle
$router->handleRequest();