<?php

declare(strict_types=1);

namespace App\Services;

use App\DB\Model\User;
use App\Exceptions\AppException;

class UserService
{
    public function sendSuccessMessage(User $user, $code = 200)
    {
        http_response_code($code);

        echo json_encode([
            'status' => 'success',
            'user' => $user->response()
        ]);
    }

    public function isUserNotFound(?User $user)
    {
        if (!$user) {
            throw new \Exception(
                json_encode(['status' => 'error', 'message' => "User with id='{$_GET['id']}' doesn't exist"]),
                AppException::NOT_FOUND
            );
        }
    }

    public function isUserNotFoundByLogin(?User $user)
    {
        if (!$user) {
            throw new \Exception(
                json_encode([
                    'status' => 'error',
                    'errors' => [
                        'login' => "A user with this login does not exist!",
                    ]]),
                AppException::NOT_FOUND
            );
        }
    }

    public function setUserCookies(User $user): void
    {
        setcookie("login", $user->login, strtotime("+30 days"), '/');
        setcookie("id", $user->id, strtotime("+30 days"), '/');
        setcookie("email", $user->email, strtotime("+30 days"), '/');
        setcookie("name", $user->name, strtotime("+30 days"), '/');
    }

    public function isPasswordInvalid()
    {
        throw new \Exception(
            json_encode([
                'status' => 'error',
                'errors' => [
                    'password' => "Password is invalid!",
                ]]),
            AppException::BAD_REQUEST
        );
    }


}