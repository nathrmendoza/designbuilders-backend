<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Core\IMiddleware;
use App\Core\Application;

class RoleMiddleware implements IMiddleware {
    private array $allowedRoles;

    public function __construct(array $allowedRoles) {
        $this->allowedRoles = $allowedRoles;
    }

    public function execute(): bool {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userRole = $_SESSION['user_role'];

        if (!in_array($userRole, $this->allowedRoles)) {
            Application::getInstance()
                ->getResponse()
                ->redirect('/unauthorized');

            return false;
        }

        return true;
    }
}