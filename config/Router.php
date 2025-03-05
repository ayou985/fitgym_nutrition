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

    public function addRoute(string $pattern, string $controllerClass, string $method)
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

        // 🔹 Vérifier si c'est une requête POST pour "/edit"
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $uri === '/edit') {
            $controllerClass = "App\\Controllers\\AllProductController";
            $controller = new $controllerClass();

            $controller->updateProduct(
                $_POST['id'] ?? null,
                $_POST['name'] ?? '',
                $_POST['price'] ?? 0,
                $_POST['description'] ?? '',
                $_POST['category'] ?? '',
                $_POST['stock'] ?? 0,
                $_FILES['image']['name'] ?? ''
            );
            return; // Arrête l'exécution ici après avoir appelé la méthode
        }

        // 🔹 Parcourir les routes définies
        foreach ($this->routes as $pattern => $routeInfo) {
            if (preg_match("#^" . $pattern . "$#", $uri, $matches)) {
                $routeFound = true;

                $controllerClass = $routeInfo['controller'];
                $method = $routeInfo['method'];

                $controllerClass = "App\\Controllers\\" . $controllerClass;
                $controller = new $controllerClass();

                // Ignorer la première correspondance et appeler la méthode avec les arguments trouvés
                array_shift($matches);
                call_user_func_array([$controller, $method], $matches);

                break;
            }
        }

        if (!$routeFound) {
            echo ErrorController::notFound();
        }
    }
}
