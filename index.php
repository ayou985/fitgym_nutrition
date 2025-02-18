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

// 📝 Routes pour le CRUD AllArticle
$router->addRoute('/articles', 'AllArticlesController', 'index'); // Afficher tous les articles
$router->addRoute('/articles/show/{id}', 'AllArticlesController', 'show'); // Afficher un article par ID
$router->addRoute('/articles/create', 'AllArticlesController', 'create'); // Afficher le formulaire de création
$router->addRoute('/articles/store', 'AllArticlesController', 'store'); // Ajouter un article (POST)
$router->addRoute('/articles/edit/{id}', 'AllArticlesController', 'edit'); // Afficher le formulaire d'édition
$router->addRoute('/articles/update/{id}', 'AllArticlesController', 'update'); // Mettre à jour un article (POST)
$router->addRoute('/articles/delete/{id}', 'AllArticlesController', 'delete'); // Supprimer un article

// 🚀 Gérer la requête actuelle
$router->handleRequest();
