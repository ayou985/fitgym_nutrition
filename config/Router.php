<?php

namespace Config;


use App\Controllers\ErrorController;


class Router
{
  private array $routes = [];

  public function getUri()
  {
    return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  }

  public function addRoute($pattern, $controllerClass, $method)
  {
    $this->routes[$pattern] = [
      'controller' => $controllerClass,
      'method' => $method
    ];
  }

  public function handleRequest()
  {
    $uri = $this->getUri();
    $routeFound = false;

    foreach ($this->routes as $pattern => $routeInfo) {
      if ($uri === $pattern) {
        $routeFound = true;

        $controllerClass = "App\\Controllers\\" . $routeInfo['controller'];
        $method = $routeInfo['method'];

        $controller = new $controllerClass(); 

        if (method_exists($controller, $method)) {
          $controller->$method();
        } else {
          echo "Erreur : La méthode '$method' n'existe pas dans '$controllerClass'.";
        }
        return; 
      }
    }

    if (!$routeFound) {
      echo ErrorController::notFound();
    }
  }
}
