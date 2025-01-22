<?php

declare(strict_types=1);

namespace App\Core;

class Router
{
    private array $routes = [];
    /**
     * STRUCTURE
     * first level: http method e.g. 'get' or 'post'
     * second level: paths e.g. '/about' '/contact'
     * third level:  controller & method e.g. [AboutController::class, 'index']
     *
     * EXAMPLE
     * $routes = [
     *  'get' => [
     *      '/' => [HomeController::class, 'index'],
     *      '/about' => [AboutController::class, 'index']
     *  ],
     *   'post' => [
     *      '/login' => [AuthController::class, 'login']
     *  ]
     * ]
     */


    //ROUTES REGISTER
    public function get(string $path, array $callback): void {
        $this->routes['get'][$path] = $callback;
    }

    public function post(string $path, array $callback): void {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve(): mixed {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        $callback = $this->routes[$method][$path] ?? false;

        if (!$callback) {
            throw new \Exception('Page not found', 404);
        }

        if (is_array($callback)) {
            $controller = new $callback[0]();
            return call_user_func([$controller, $callback[1]]);
        }

        return call_user_func($callback);
    }

}