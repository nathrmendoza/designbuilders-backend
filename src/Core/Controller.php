<?php

declare(strict_types=1);

namespace App\Core;

abstract class Controller
{
    protected function render(string $view, array $params = []): string {
        return (new View($view, $params))->render();
    }
}