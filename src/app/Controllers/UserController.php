<?php

declare(strict_types=1);

namespace App\Controllers;

use App\DB\Model\User;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create(): void
    {
        $userData = $this->request->getData();

        if ($this->checkUserData($userData)) return;

        if (isset($userData['id'])) {
            unset($userData['id']);
        }

        $userData['password'] = $this->serviceJWT->createTokenByPassword($userData['password']);

        $userModel = new User($userData);
        $user = $this->userRepository->createUser($userModel);

        if ($user) {
            http_response_code(200);

            setcookie("login", $user->login, strtotime("+30 days"), '/');
            setcookie("id", $user->id, strtotime("+30 days"), '/');
            setcookie("email", $user->email, strtotime("+30 days"), '/');
            setcookie("name", $user->name, strtotime("+30 days"), '/');

            echo json_encode([
                'status'=>'success'
            ]);
            return;
        }

        http_response_code(500);
        echo json_encode([
            'status'=>'fatal'
        ]);
    }

    public function get(): void
    {
        $user = $this->userRepository->getUserById($_GET['id']);

        header('Content-Type: application/json');

        if (!$user) {
            http_response_code(404);
            echo json_encode(['message' => "User with id='{$_GET['id']}' hasn't exist"]);
            return;
        }

        http_response_code(200);
        echo json_encode($user);
    }

    public function update(): void
    {
        $userData = $this->$this->request->getData();
        $userModel = new User($userData);
        $user = $this->userRepository->updateUserById($userModel->id, $userModel);
        header('Content-Type: application/json');

        if (!$user) {
            http_response_code(404);
            echo json_encode(['message' => "User with id='{$_GET['id']}' hasn't exist"]);
            return;
        }

        http_response_code(200);
        echo json_encode($user);
    }

    public function delete(): void
    {
        $user = $this->userRepository->deleteUserById($_GET['id']);

        header('Content-Type: application/json');

        if (!$user) {
            http_response_code(404);
            echo json_encode(['message' => "User with id='{$_GET['id']}' hasn't exist"]);
            return;
        }

        http_response_code(204);
        echo $user;
    }

    private function checkUserData($data): bool
    {
        $errors = [];

        //Check login
        if (!isset($data['login']) || (strlen($data['login']) < 6)) {
            $errors['login'] = 'Login is empty or its length is less than 6 characters';
        } else {
            $user = $this->userRepository->getUserByLogin($data['login']);

            if ($user) {
                $errors['login'] = 'A user with this login already exists';
            }
        }

        //check password
        if (!isset($data['password']) || (strlen($data['password']) < 6)) {
            $errors['password'] = 'Password is empty or its length is less than 6 characters';
        } else {
            $regexPassword = '/(?:[а-яёa-z]\d|\d[в-яёa-z])/i';

            if (!preg_match($regexPassword, $data['password'])) {
                $errors['password'] = 'Your password must contain both letters and numbers';
            }

        }

        //check email
        $regexEmail = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';

        if (!isset($data['email']) || !preg_match($regexEmail, strtolower($data['email']))) {
            $errors['email'] = 'Email is invalid';
        }

        $user = $this->userRepository->getUserByEmail($data['email']);

        if ($user) {
            $errors['email'] = 'A user with this email already exists';
        }

        //check name
        if (!isset($data['name']) || (strlen($data['name']) < 2)) {
            $errors['name'] = 'The name must contain at least two letters';
        } else {
            $regexName = '/^[a-zA-Z]+$/';

            if (!preg_match($regexName, $data['name'])) {

                $errors['name'] = 'The name must contain only letters';
            }
        }

        if (count($errors)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'errors' => $errors]);
            return true;
        }

        return false;
    }

}