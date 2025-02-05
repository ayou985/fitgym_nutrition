<?php

require "vendor/autoload.php";

use Config\Router;

$router = new Router();

// Routes principales
$router->addRoute('/', 'HomeController', 'index');
$router->addRoute('/product', 'PageController', 'product');
$router->addRoute('/about', 'PageController', 'about');
$router->addRoute('/contact', 'PageController', 'contact');

// Routes du tableau de bord
$router->addRoute('/dashboard/user', 'DashboardController', 'userDashboard');
$router->addRoute('/dashboard/admin', 'DashboardController', 'adminDashboard');

// Routes d'inscription et de connexion
$router->addRoute('/register', 'RegisterController', 'index');
$router->addRoute('/login', 'LoginController', 'login');

// Route de déconnexion
$router->addRoute('/logout', 'LogoutController', 'logout');

$router->handleRequest();

?>
