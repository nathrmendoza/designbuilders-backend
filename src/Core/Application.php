<?php
declare(strict_types=1);

namespace App\Core;

class Application
{
    private Router $router;
    private Database $database;
    private static Application $instance;

    public function __construct() {
        self::$instance = $this;
        $this->router = new Router();
        $this->database = new Database();
    }

    public function run(): void {
        try {
            $this->router->resolve();
        } catch(\Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function getInstance(): self {
        return self::$instance;
    }

    public function getRouter(): Router {
        return $this->router;
    }

    public function getDatabase(): Database {
        return $this->database;
    }
}