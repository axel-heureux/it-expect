<?php

namespace Core;

class Router
{
    private array $routes = [];

    public function add(
        string $method,
        string $path,
        string $action
    ): void {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'action' => $action,
        ];
    }

    public function dispatch(
        string $uri,
        string $method
    ): void {
        // On garde uniquement le chemin
        $path = parse_url($uri, PHP_URL_PATH);

        // Supprime le "/" final
        if ($path !== '/') {
            $path = rtrim($path, '/');
        }

        foreach ($this->routes as $route) {

            // Vérification de la méthode HTTP
            if ($route['method'] !== $method) {
                continue;
            }

            // Vérification de l'URL
            if ($route['path'] !== $path) {
                continue;
            }

            // Exemple :
            // ItemController@index
            [$controllerName, $methodName] = explode(
                '@',
                $route['action']
            );

            // Namespace du contrôleur
            $controllerClass = 'Controller\\' . $controllerName;

            // Vérification de l'existence du contrôleur
            if (!class_exists($controllerClass)) {
                http_response_code(500);
                echo 'Contrôleur introuvable : ' . $controllerClass;
                return;
            }

            // Création du contrôleur
            $controller = new $controllerClass();

            // Vérification de la méthode
            if (!method_exists($controller, $methodName)) {
                http_response_code(500);
                echo 'Méthode introuvable : ' . $methodName;
                return;
            }

            // Exécution
            $controller->$methodName();

            return;
        }

        // Aucune route trouvée
        http_response_code(404);
        echo '404 - Page non trouvée';
    }
}
