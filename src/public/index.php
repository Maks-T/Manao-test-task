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

header('Content-Type: application/json');

$router = new Router();

$router->get('/', [HomeController::class, 'index']);
$router->get('/registration', [HomeController::class, 'registration']);
$router->get('/login', [HomeController::class, 'login']);

$router->get('/user', [UserController::class, 'get']);
$router->post('/user', [UserController::class, 'create']);
$router->put('/user', [UserController::class, 'update']);
$router->delete('/user', [UserController::class, 'delete']);

$router->post('/user/login', [LoginController::class, 'login']);

$router->resolve($_SERVER['REQUEST_URI'], strtolower($_SERVER['REQUEST_METHOD']));




