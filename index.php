<?php 

require "vendor/autoload.php";

use Config\Router;
use Controllers\AuthController;
use Controllers\HomeController;
use Controllers\DashboardController;

$router = new Router();

$router->addRoute('/', 'HomeController', 'index');
$router->addRoute('/product', 'PageController', 'product');
$router->addRoute('/about', 'PageController', 'about');
$router->addRoute('/contact', 'PageController', 'contact');

$router->addRoute('/login', 'AuthController', 'login');
$router->addRoute('/logout', 'AuthController', 'logout');

$router->addRoute('/dashboard/user', 'DashboardController', 'userDashboard');
$router->addRoute('/dashboard/admin', 'DashboardController', 'adminDashboard');

$router->handleRequest();
?>
