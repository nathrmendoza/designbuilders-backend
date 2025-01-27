<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Application;
use App\Core\Controller;
use App\Models\User;

class AuthController extends Controller
{
    private User $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function login(): string {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userModel->findByEmail($email);

            if ($user && $this->userModel->verifyPassword($password, $user['password_hash'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];

                Application::getInstance()
                    ->getResponse()
                    ->redirect('/dashboard');
                exit;
            }

            $error = 'Invalid email or password';
            return $this->render('auth/login', ['error' => $error]);
        }

        return $this->render('auth/login');
    }

    public function register(): string {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           $data = [
            'username' => $_POST['username'] ?? '',
            'email' => $_POST['email'] ?? '',
            'password' => $_POST['password'] ?? '',
            'role' => 'user'
           ];

            // ERROR HANDLING
            if (empty($data['username']) || empty($data['email']) || empty($data['password'])) {
                $error = 'Username, email and password fields are required';
                return $this->render('auth/register', ['error' => $error]);
            }

            if ($this->userModel->findByEmail($data['email'])) {
                $error = 'Email already exists';
                return $this->render('auth/register', ['error' => $error]);
            }

            // CREATE NEW USER
            if ($this->userModel->create($data)) {
                Application::getInstance()
                    ->getResponse()
                    ->redirect('/login');
                exit;
            }

            $error = 'Registration failed';
            return $this->render('auth/register', ['error' => $error]);
        }

        return $this->render('auth/register');
    }

    public function logout(): void {
        session_start();
        session_destroy();
        Application::getInstance()
            ->getResponse()
            ->redirect('/login');
        exit;
    }
}