<?php
require_once '../app/helper/auth.php';

use Bramus\Router\Router;
use App\Controller\HomeController;
use App\Controller\AuthController;
use App\Controller\EmployeesController;
use App\Controller\DepartmentController;
use App\Controller\PositionController;
use App\Controller\Error;

$router = new Router();


$router->before('GET|POST', '/.*', function () {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
});


$router->before('GET', '/.*', function () {});
//////////////////////////////////////////////////////////////////////////////////////////
// Home
$router->get('/', function () {
    authorize(['admin', 'boss', 'user']);
    (new HomeController())->index();
});

// hr
$router->get('/employees', function () {
    authorize(['admin', 'boss']);
    (new EmployeesController())->index();
});

$router->get('/departments', function () {
    authorize(['admin', 'boss']);
    (new DepartmentController())->index();
});

$router->get('/positions', function () {
    authorize(['admin', 'boss']);
    (new PositionController())->index();
});




///////////////////////////////////////////////////////////////////////////////////////////////
//login 
$router->get('/login', function () {
    (new AuthController())->showLogin();
});

// login 
// $router->post('/login', function () {
//     (new AuthController())->login();
// });

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
