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
$router->addRoute('/create', 'AllArticlesController', 'createArticle');
$router->addRoute('/edit', 'AllArticlesController', 'editArticle');
$router->addRoute('/delete', 'AllArticlesController', 'deleteArticle');
$router->addRoute('/admin/article/store', 'AllArticlesController', 'store');
$router->addRoute('/articles', 'AllArticlesController', 'index');


// 🚀 Gérer la requête actuelle
$router->handleRequest();