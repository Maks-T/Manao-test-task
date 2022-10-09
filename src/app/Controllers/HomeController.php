<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\LoginService;

class HomeController extends Controller
{
    private LoginService $loginService;

    public function __construct()
    {
        $this->loginService = new LoginService();
    }

    public function index(): void
    {
        if ($this->loginService->isUserLogin()) {
            include 'home.html';
            return;
        }

        foreach ($_COOKIE as $param => $value) {
            setcookie($value, '', time() - 3600);
        }

        header('Location: /login');
    }

    public function registration(): void
    {
        if ($this->loginService->isUserLogin()) {
            include 'home.html';
            return;
        }
        include_once 'registration.html';
    }

    public function login(): void
    {
        if ($this->loginService->isUserLogin()) {
            include 'home.html';
            return;
        }
        include_once 'login.html';
    }
}