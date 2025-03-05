<?php

require "vendor/autoload.php";

session_start();

use Config\Router;

// Créer une instance du routeur
$router = new Router();

// 🌍 Routes principales
$router->addRoute('/', 'HomeController', 'index'); // Page d'accueil
$router->addRoute('/product', 'ProductController', 'product'); // Page des produits
$router->addRoute('/about', 'AboutController', 'about'); // Page à propos
$router->addRoute('/contact', 'ContactController', 'contact'); // Page de contact

// 🔐 Routes d'inscription et de connexion
$router->addRoute('/register', 'RegisterController', 'index'); // Inscription
$router->addRoute('/login', 'LoginController', 'login'); // Connexion
$router->addRoute('/logout', 'LogoutController', 'logout'); // Déconnexion

// 🔑 Routes AuthController
$router->addRoute('/auth/suggest-password', 'AuthController', 'suggestPassword'); // Suggérer un mot de passe
$router->addRoute('/auth/verify', 'AuthController', 'verifyAuth'); // Vérification d'authentification

// 🛒 Routes pour le CRUD AllProduct (Produits)
$router->addRoute('/create', 'AllProductController', 'createProduct');
$router->addRoute('/edit', 'AllProductController', 'updateProduct');
$router->addRoute('/delete', 'AllProductController', 'deleteProduct');
$router->addRoute('/store', 'AllProductController', 'store');
$router->addRoute('/read', 'AllProductController', 'index');


// 🚀 Gérer la requête actuelle
$router->handleRequest();

