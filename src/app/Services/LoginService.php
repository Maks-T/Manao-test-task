<?php

namespace App\Services;

use App\DB\Repository\UserRepository;

class LoginService
{

    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    function isUserLogin()
    {
        if (isset($_COOKIE["PHPSESSID"]) && isset($_COOKIE["id"])) {
            $user = $this->userRepository->getUserById($_COOKIE["id"]);

            if ($user && $user->session === $_COOKIE["PHPSESSID"]) {

                return true;
            }
        }

        return false;
    }
}