<?php
declare(strict_types=1);

namespace App\Core;

class Application
{
    private Router $router;
    private Database $database;
    private Response $response;
    private static Application $instance;

    public function __construct() {
        self::$instance = $this;
        $this->router = new Router();
        $this->database = new Database();
        $this->response = new Response();
    }

    public function run(): void {
        try {
            $content = $this->router->resolve();
            $this->response->send($content);
        } catch (\Exception $e) {
            $this->response->setStatusCode(500);
            $this->response->send($e->getMessage());
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

    public function getResponse(): Response {
        return $this->response;
    }
}