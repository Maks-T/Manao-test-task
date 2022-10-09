<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\UserService;

class LoginController extends Controller
{
    private UserService $userService;

    public function __construct()
    {
        parent::__construct();
        $this->userService = new UserService();
    }

    public function login(): void
    {
        $loginData = $this->request->getData();

        $user = $this->userRepository->getUserByLogin($loginData['login']);

        $this->userService->isUserNotFoundByLogin($user);

        $isValidatePassword = $this->serviceJWT->validatePasswordByToken($loginData['password'], $user->password);

        if (!$isValidatePassword) {
            $this->userService->isPasswordInvalid();
        }

        $this->userService->setUserCookies($user);
        $user->session = session_id();
        $this->userRepository->updateUserById($user->id, $user);
        $this->userService->sendSuccessMessage($user);
    }

}