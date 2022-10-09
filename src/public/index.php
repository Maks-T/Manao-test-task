<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Controllers\LoginController;
use App\Exceptions\AppException;
use App\Router;
use App\ConfigApp;

session_start();

new AppException();

new ConfigApp();

$router = new Router();

$router->get('/', [HomeController::class, 'index']);
$router->get('/registration', [HomeController::class, 'registration']);
$router->get('/login', [HomeController::class, 'login']);

$router->get('/user', [UserController::class, 'get', 'application/json']);
$router->post('/user', [UserController::class, 'create', 'application/json']);
$router->put('/user', [UserController::class, 'update', 'application/json']);
$router->delete('/user', [UserController::class, 'delete', 'application/json']);

$router->post('/user/login', [LoginController::class, 'login', 'application/json']);

$router->resolve($_SERVER['REQUEST_URI'], strtolower($_SERVER['REQUEST_METHOD']));




