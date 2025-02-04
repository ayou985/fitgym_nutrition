<?php 

require "vendor/autoload.php";

use Config\Router;


$router = new Router();

$router->addRoute('/', 'HomeController', 'index');
$router->addRoute('/product', 'PageController', 'product');
$router->addRoute('/about', 'PageController', 'about');
$router->addRoute('/contact', 'PageController', 'contact');



$router->addRoute('/dashboard/user', 'DashboardController', 'userDashboard');
$router->addRoute('/dashboard/admin', 'DashboardController', 'adminDashboard');

$router->addRoute('/register', 'RegisterController', 'index');
$router->addRoute('/login', 'LoginController', 'login');

$router->handleRequest();

?>
