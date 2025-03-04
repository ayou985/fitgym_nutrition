<?php

require "vendor/autoload.php";

session_start();

use Config\Router;

$router = new Router();

// 🌍 Routes principales
$router->addRoute('/', 'HomeController', 'index');
$router->addRoute('/product', 'ProductController', 'product');
$router->addRoute('/about', 'AboutController', 'about');
$router->addRoute('/contact', 'ContactController', 'contact');

// 🔐 Routes d'inscription et de connexion
$router->addRoute('/register', 'RegisterController', 'index');
$router->addRoute('/login', 'LoginController', 'login');
$router->addRoute('/logout', 'LogoutController', 'logout');

// 🔑 Routes AuthController
$router->addRoute('/auth/suggest-password', 'AuthController', 'suggestPassword');
$router->addRoute('/auth/verify', 'AuthController', 'verifyAuth');

// 🛒 Routes pour le CRUD AllProduct (Produits)
$router->addRoute('/create', 'AllProductController', 'createProduct'); // Formulaire de création
$router->addRoute('/edit', 'AllProductController', 'updateProduct'); // Modifier un produit
$router->addRoute('/delete', 'AllProductController', 'deleteProduct'); // Suppression
$router->addRoute('/store', 'AllProductController', 'store'); // Enregistrement du produit
$router->addRoute('/admin/products', 'AllProductController', 'index'); // Affichage de tous les produits

// 🚀 Gérer la requête actuelle
$router->handleRequest();
