<?php

declare(strict_types=1);

namespace App\Services;

use ReallySimpleJWT\Token;

class ServiceJWT
{
    public function createTokenByPassword(string $password): string
    {
        $user = '';
        $secret = $_ENV['SECRET_JWT'].$password;
        $expiration = time() + 3600;
        $issuer = 'localhost';

        return Token::create($user, $secret, $expiration, $issuer);
    }

    public function validatePasswordByToken(string $password, string $token):bool
    {
        $secret = $_ENV['SECRET_JWT'].$password;

       return Token::validate($token, $secret);
    }
}