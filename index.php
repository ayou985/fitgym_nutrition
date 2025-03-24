<?php

require "vendor/autoload.php";

session_start();

use Config\Router;

// Créer une instance du routeur
$router = new Router();

// 🌍 Routes principales
$router->addRoute('/', 'HomeController', 'index'); // Page d'accueil
$router->addRoute('/products', 'ProductController', 'product'); // Page des produits
$router->addRoute('/about', 'AboutController', 'about'); // Page à propos
$router->addRoute('/services', 'ServicesController', 'services'); // Page de services
$router->addRoute('/pourquoinous', 'PourquoinousController', 'pourquoinous'); // Page de pourquoi nous
$router->addRoute('/contact', 'ContactController', 'contact'); // Page de contact
$router->addRoute('/mentionlegale', 'MentionlegaleController', 'mentionlegale'); // Page des mentions légales
$router->addRoute('/cgv', 'CGVController', 'cgv'); // Page de CGV


// 🔐 Routes d'inscription et de connexion
$router->addRoute('/register', 'RegisterController', 'register'); // Inscription
$router->addRoute('/login', 'LoginController', 'login'); // Connexion
$router->addRoute('/logout', 'LogoutController', 'logout'); // Déconnexion

// 🔑 Routes AuthController
$router->addRoute('/auth/suggest-password', 'AuthController', 'suggestPassword'); // Suggérer un mot de passe
$router->addRoute('/auth/verify', 'AuthController', 'verifyAuth'); // Vérification d'authentification

// 🛒 Routes pour le CRUD AllProduct (Produits)
$router->addRoute('/createProduct', 'AllProductController', 'createProduct');
$router->addRoute('/editProduct', 'AllProductController', 'editProduct');
$router->addRoute('/deleteProduct', 'AllProductController', 'deleteProduct');
$router->addRoute('/store', 'AllProductController', 'store');
$router->addRoute('/read', 'AllProductController', 'index');
$router->addRoute('/produitdetail', 'ProduitdetailController', 'produitdetail');
$router->addRoute('/cart', 'CartController', 'showCart');
$router->addRoute('/cart/add', 'CartController', 'addToCart');
$router->addRoute('/cart/update', 'CartController', 'updateCart');
$router->addRoute('/cart/remove', 'CartController', 'removeFromCart');


// 🧑‍💼 Routes pour la gestion du profil utilisateur
$router->addRoute('/profile', 'UserController', 'profile'); // Voir le profil
$router->addRoute('/profile/update', 'UserController', 'updateProfile'); // Modifier les infos
$router->addRoute('/profile/change-password', 'UserController', 'changePassword'); // Modifier le mot de passe
$router->addRoute('/profile/delete', 'UserController', 'deleteAccount'); // Supprimer le compte


$router->addRoute('/listUsers', 'UserController', 'listUsers');  // Liste des utilisateurs
$router->addRoute('/editUser', 'UserController', 'editUser'); // Modifier un utilisateur
$router->addRoute('/deleteUser', 'UserController', 'deleteUser'); // Supprimer un utilisateur
$router->addRoute('/updateUser', 'UserController', 'updateUser'); // Traiter la mise à jour d'un utilisateur


$router->addRoute('/paiement', 'PaiementController', 'showPaiement'); // Affichage
$router->addRoute('/paiement/process', 'PaiementController', 'processPaiement'); // Traitement


// 🚀 Gérer la requête actuelle
$router->handleRequest();

