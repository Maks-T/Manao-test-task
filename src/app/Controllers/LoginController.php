<?php

declare(strict_types=1);

namespace App\Controllers;


class LoginController extends Controller
{

    public function login(): void
    {
        $loginData = $this->request->getData();

        $user = $this->userRepository->getUserByLogin($loginData['login']);

        header('Content-Type: application/json');

        if (!$user) {
            http_response_code(400);
            echo json_encode([
                'status'=>'error',
                'errors' => [
                    'login'=>"User with login={$loginData['login']} doesn't exist",
                ]
            ]);
            return;
        }

        $isValidatePassword = $this->serviceJWT->validatePasswordByToken($loginData['password'], $user->password);

        if ($isValidatePassword) {
            http_response_code(200);

            setcookie("login", $user->login, strtotime("+30 days"), '/');
            setcookie("id", $user->id, strtotime("+30 days"), '/');
            setcookie("email", $user->email, strtotime("+30 days"), '/');
            setcookie("name", $user->name, strtotime("+30 days"), '/');

            $user->session = session_id();

            $this->userRepository->updateUserById($user->id, $user);

            echo json_encode([
                'status'=>'success'
            ]);
            return;
        }

        http_response_code(400);
        echo json_encode([
            'status'=>'error',
            'errors' => [
                'password'=>"Password is invalid!",
            ]
        ]);

    }

}