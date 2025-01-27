<?php

declare(strict_types=1);

namespace App\Core;

class View
{
    private string $view;
    private array $params;

    public function __construct(string $view, array $params = []) {
        $this->view = $view;
        $this->params = $params;
    }

    public function render(): string {
        $viewPath = $this->getViewPath();
        $layoutPath = $this->getLayoutPath();

        if (!file_exists($viewPath)) {
            throw new \Exception("View {$this->view} not found");
        }

        extract($this->params);

        ob_start();
        include $viewPath;
        $content = ob_get_clean();

        if (!file_exists($layoutPath)) {
            return $content;
        }

        ob_start();
        include $layoutPath;
        return ob_get_clean();
    }

    private function getViewPath(): string {
        return __DIR__ . '/../Views/' . $this->view . '.php';
    }

    private function getLayoutPath(): string {
        return __DIR__ . '/../Views/layouts/main.php';
    }
}