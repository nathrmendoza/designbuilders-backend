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
    private array $middlewares = [];


    //ROUTES REGISTER
    public function get(string $path, array $callback, array $middlewares = []): void {
        $this->routes['get'][$path] = $callback;
        $this->middlewares['get'][$path] = $middlewares;
    }

    public function post(string $path, array $callback, array $middlewares = []): void {
        $this->routes['post'][$path] = $callback;
        $this->middlewares['post'][$path] = $middlewares;
    }

    public function resolve(): mixed {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        $callback = $this->routes[$method][$path] ?? false;
        $middlewares = $this->middlewares[$method][$path] ?? [];

        if (!$callback) {
            throw new \Exception('Page not found', 404);
        }

        foreach ($middlewares as $middleware) {
            $instance = new $middleware();
            if (!$instance->execute()) {
                return '';
            }
        }

        if (is_array($callback)) {
            $controller = new $callback[0]();
            return call_user_func([$controller, $callback[1]]);
        }

        return call_user_func($callback);
    }

}