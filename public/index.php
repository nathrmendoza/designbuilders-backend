<?php
declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/../vendor/autoload.php';

//load env variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Initialize application
$app = new App\Core\Application();

$router = $app->getRouter();

//auth routes
$router->get('/login', [App\Controllers\AuthController::class, 'login']);
$router->post('/login', [App\Controllers\AuthController::class, 'login']);
$router->get('/register', [App\Controllers\AuthController::class, 'register']);
$router->post('/register', [App\Controllers\AuthController::class, 'register']);
$router->get('/logout', [App\Controllers\AuthController::class, 'logout']);

//protected routes
$router->get('/dashboard', [App\Controllers\DashboardController::class, 'index'],
    [App\Middleware\AuthMiddleware::class]
);

$app->run();