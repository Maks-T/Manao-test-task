<?php

declare(strict_types=1);

namespace App\DB\Model;

use \Ramsey\Uuid\Uuid;

class User
{
    public string $id;
    public string $login;
    public string $password;
    public string $email;
    public string $name;
    public string $session;

    public function __construct(array $userData)
    {

        $this->id =
            !isset($userData['id'])
                ? (string)Uuid::uuid4()
                : $userData['id'];

        $this->login = $userData['login'];
        $this->password = $userData['password'];
        $this->email = $userData['email'];
        $this->name = $userData['name'];

        $this->session =
            !isset($userData['session'])
                ? session_id()
                : $userData['session'];
    }

    public function response() {
        return [
            'id'=>$this->id,
            'login'=>$this->login,
            'email'=>$this->email,
            'name'=>$this->name
        ];
    }
}