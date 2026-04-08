<?php

// 1. CHARGER LES VARIABLES D'ENVIRONNEMENT
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            [$key, $value] = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

// 2. AFFICHER LES ERREURS UNIQUEMENT EN DÉVELOPPEMENT
if (($_ENV['APP_ENV'] ?? 'production') === 'development') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}

// 3. CHARGER L'AUTOLOADER (Nécessaire pour trouver tes classes)
require __DIR__ . '/vendor/autoload.php';

// 3. DÉMARRAGE DE LA SESSION (Sécurisé)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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
$router->addRoute('/product', 'ProduitdetailController', 'produitdetail');
$router->addRoute('/cart', 'CartController', 'showCart');
$router->addRoute('/cart/add', 'CartController', 'addToCart');
$router->addRoute('/cart/update', 'CartController', 'updateCart');
$router->addRoute('/cart/remove', 'CartController', 'removeFromCart');

// 🧑‍💼 Routes pour la gestion du profil utilisateur
$router->addRoute('/profile', 'UserController', 'profile'); // Voir le profil
$router->addRoute('/profile/update', 'UserController', 'updateProfile'); // Modifier les infos
$router->addRoute('/profile/change-password', 'UserController', 'changePassword'); // Modifier le mot de passe
$router->addRoute('/profile/delete', 'UserController', 'deleteAccount'); // Supprimer le compte

$router->addRoute('/admin', 'AdminController', 'dashboard');       // Dashboard admin
$router->addRoute('/listUsers', 'UserController', 'listUsers');  // Liste des utilisateurs
$router->addRoute('/editUser', 'UserController', 'editUser'); // Modifier un utilisateur
$router->addRoute('/deleteUser', 'UserController', 'deleteUser'); // Supprimer un utilisateur
$router->addRoute('/updateUser', 'UserController', 'updateUser'); // Traiter la mise à jour d'un utilisateur

$router->addRoute('/paiement', 'PaiementController', 'showPaiement'); // Affichage
$router->addRoute('/paiement/process', 'PaiementController', 'processPaiement'); // Traitement

$router->addRoute('/submitReviews', 'ProductController', 'submitReviews');
$router->addRoute('/deleteReviews', 'ProductController', 'deleteReviews');
$router->addRoute('/updateReviews', 'ProductController', 'updateReviews');
$router->addRoute('/review/delete', 'ReviewController', 'delete');

// --- ASTUCE XAMPP : Cacher le nom du dossier au routeur ---
// Cela permet au routeur de comprendre que '/fitgym_nutrition-main/' équivaut à '/' (l'accueil)
$_SERVER['REQUEST_URI'] = str_replace('/fitgym_nutrition-main', '', $_SERVER['REQUEST_URI']);

// Si l'URL devient vide après le nettoyage, on force un slash "/" pour la route d'accueil
if (empty($_SERVER['REQUEST_URI'])) {
    $_SERVER['REQUEST_URI'] = '/';
}
// -----------------------------------------------------------

// 🚀 Gérer la requête actuelle
try {
    $router->handleRequest();
} catch (Exception $e) {
    // Affiche une erreur propre au lieu d'une page blanche si une route plante
    echo "<h1>Erreur de routage :</h1><p>" . $e->getMessage() . "</p>";
}