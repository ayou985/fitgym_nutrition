<?php

namespace Config;

use App\Controllers\ErrorController;

class Router
{
    private array $routes = [];

    public function getUri(): string
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        return $uri ?? '/'; // Éviter un retour null
    }

    public function addRoute(string $pattern, string $controllerClass, string $method): void
    {
        $this->routes[$pattern] = [
            'controller' => $controllerClass,
            'method' => $method
        ];
    }

    public function handleRequest(): void
    {
        $uri = $this->getUri();
        $routeFound = false;

        // 🔹 Vérifier si c'est une requête POST pour "/edit"
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $uri === '/edit') {
            $controllerClass = "App\\Controllers\\AllProductController";
            $controller = new $controllerClass();

            $controller->editProduct(
                $_POST['id'] ?? null,
                $_POST['name'] ?? '',
                $_POST['description'] ?? '',
                $_POST['price'] ?? 0,
                $_POST['stock'] ?? 0,
                $_POST['category'] ?? '',
                $_FILES['image']['name'] ?? ''
            );
            return; // Arrête l'exécution ici après avoir appelé la méthode
        }

        // 🔹 Parcourir les routes définies
        foreach ($this->routes as $pattern => $routeInfo) {
            if (!is_string($uri)) {
                $uri = ''; // Assurer que $uri est toujours une chaîne
            }

            if (!is_string($pattern)) {
                continue; // Passer les routes non valides
            }

            if (preg_match("#^" . preg_quote($pattern, '#') . "$#", $uri, $matches)) {
                $routeFound = true;

                $controllerClass = "App\\Controllers\\" . $routeInfo['controller'];
                $method = $routeInfo['method'];

                if (!class_exists($controllerClass)) {
                    echo "Erreur : Contrôleur `$controllerClass` introuvable.";
                    return;
                }

                $controller = new $controllerClass();

                // Ignorer la première correspondance et appeler la méthode avec les arguments trouvés
                array_shift($matches);

                if (!method_exists($controller, $method)) {
                    echo "Erreur : Méthode `$method` introuvable dans `$controllerClass`.";
                    return;
                }

                call_user_func_array([$controller, $method], $matches);
                break;
            }
        }

        if (!$routeFound) {
            echo ErrorController::notFound();
        }
    }
}
