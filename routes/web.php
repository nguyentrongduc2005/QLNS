<?php

use Bramus\Router\Router;
use App\Controller\HomeController;
use App\Controller\AuthController;

$router = new Router();


$router->before('GET|POST', '/((?!^\/(login|api)).*)', function () {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit;
    }
});

$router->before('GET', '/.*', function () {
    echo "dsfsdfdsfsdfsd";
});
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
    header('Location: /login');
});

$router->set404('\App\Controllers\Error@notFound');

$router->run();
