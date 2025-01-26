<?php

require_once __DIR__ . '/vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Run migrations
$migration = new App\Database\Migration();
$migration->applyMigrations();

echo "Migrations applied successfully!\n";