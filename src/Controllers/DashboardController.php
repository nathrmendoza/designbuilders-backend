<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;

class DashboardController extends Controller
{
    public function index(): string {
        $userData = [
            'email' => $_SESSION['user_email'] ?? 'Not logged in',
            'role' => $_SESSION['user_role'] ?? 'None'
        ];

        return $this->render('dashboard/index', [
            'user' => $userData
        ]);
    }
}