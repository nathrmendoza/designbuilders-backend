<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Core\IMiddleware;
use App\Core\Application;

class AuthMiddleware implements IMiddleware
{
    public function execute(): bool {
        session_start();

        //not logged in
        if(!isset($_SESSION['user_id'])) {
            Application::getInstance()
                ->getResponse()
                ->redirect('/login');
            return false;
        }

        return true;
    }
}