<?php 

require "vendor/autoload.php";


use Config\Router;

$router = new Router();


$router->addRoute('/' , 'HomeController', 'index');


$router->handleRequest();

?>

