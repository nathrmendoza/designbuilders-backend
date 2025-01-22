<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

//load env variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Initialize application
$app = new App\Core\Application();
$app->run();