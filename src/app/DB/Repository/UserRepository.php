<?php

declare(strict_types=1);

namespace App\DB\Repository;

use App\DB\Model\User;
use App\DB\DataBase\JsonDB;

class UserRepository
{
    const FILE_PATH =  __DIR__ . './../../Store/users.json';

    private JsonDb $jsonDB;

    public function __construct()
    {
        $this->jsonDB = new JsonDB(self::FILE_PATH, User::class);
    }

    public function createUser(User $user): ?User {
        $findUser = $this->getUserByLogin($user->login);

        if (!$findUser) {
            return $this->jsonDB->create($user);
        }

       return null;
    }

    public function getUserById(string $id): ?User {
        return $this->jsonDB->getByField('id', $id);
    }


    public function getUserByLogin(string $login): ?User {
        return $this->jsonDB->getByField('login', $login);
    }

    public function getUserByEmail(string $email): ?User {
        return $this->jsonDB->getByField('email', $email);
    }

    public function updateUserById(string $id, User $user): ?User {
        $findUser = $this->getUserById($id);

        if ($findUser) {
            return $this->jsonDB->updateByField('id', $id, $user);
        }

        return null;
    }

    public function deleteUserById(string $id): ?User {
        return $this->jsonDB->deleteByField('id', $id);
    }

}