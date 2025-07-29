<?php

use Bramus\Router\Router;
use App\Controller\HomeController;
use App\Controller\AuthController;
use App\Controller\Error;

$router = new Router();


$router->before('GET|POST', '/.*', function () {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
});

$router->before('GET|POST', '/.*', function () {
    $uri = $_SERVER['REQUEST_URI'];

    $publicRoutes = '#^/QLDA/public/(login|api|register)#';

    if (!isset($_SESSION['user_id']) && !preg_match($publicRoutes, $uri)) {
        header("Location: {$_ENV['APP_URL']}/{$_ENV['APP_NAME']}/{$_ENV['APP_PUBLIC']}/login");
        exit;
    }
});

$router->before('GET', '/.*', function () {});
// Home
$router->get('/', function () {
    (new HomeController())->index();
});

//login 
$router->get('/login', function () {
    (new AuthController())->showLogin();
});

// login 
$router->post('/login', function () {
    (new AuthController())->login();
});

// login trả json
$router->post('/api/login', function () {
    (new AuthController())->apiLogin();
});

// logout
$router->get('/logout', function () {
    session_start();
    session_destroy();
    header("Location: {$_ENV['APP_URL']}/{$_ENV['APP_NAME']}/{$_ENV['APP_PUBLIC']}/");
});

$router->set404(function () {
    (new Error())->notFound();
});

$router->run();
