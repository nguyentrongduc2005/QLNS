<?php
require_once '../app/helper/auth.php';

use Bramus\Router\Router;
use App\Controller\HomeController;
use App\Controller\AuthController;
use App\Controller\EmployeesController;
use App\Controller\DepartmentController;
use App\Controller\PositionController;
use App\Controller\Error;
use App\Controller\ProfileController;
use App\Controller\DetailsController;
use App\Models\Detail;


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
$router->get('/details', function () {
    authorize(['admin', 'boss']);
    (new DetailsController())->index();
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

$router->get('/profile', function () {
    authorize(['admin', 'user']);  // Chỉ cho phép admin và user truy cập
    (new ProfileController())->showProfile();
});
//Update thông tin cá nhân
$router->post('/profile/update', function () {
    authorize(['admin', 'user']);
    (new ProfileController())->updateProfile();
});
// đổi password
$router->post('/api/change-password', function () {
    (new AuthController())->changePassword();
});
//yêu cầu OTP để đổi mật khẩu
$router->post('/request-change-password', function () {
    (new AuthController())->requestChangePassword();
});

//xử lý đổi mật khẩu
$router->post('/api/change-password', function () {
    (new AuthController())->changePassword();
});


$router->run();

//trang cá nhân 