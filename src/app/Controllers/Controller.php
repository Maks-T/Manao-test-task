<?php

declare(strict_types=1);

namespace App\Controllers;

use App\DB\Repository\UserRepository;
use App\Services\RequestService;
use App\Services\ServiceJWT;

abstract class Controller
{
    protected UserRepository $userRepository;

    protected ServiceJWT $serviceJWT;

    protected RequestService $request;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->serviceJWT = new ServiceJWT();
        $this->request = new RequestService();
    }
}