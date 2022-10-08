<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Controllers\LoginController;
use App\Router;
use App\ConfigApp;

session_start();

if (isset($_SESSION["visit_count"])) {
    $visit_count = $_SESSION["visit_count"] + 1;
}
setcookie("visit_count", $visit_count, strtotime("+30 days"));
$_SESSION["visit_count"] = $visit_count;


new ConfigApp();

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


