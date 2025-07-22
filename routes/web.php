<?php

use Bramus\Router\Router;
use App\Controller\HomeController;

$router = new Router();


$router->before('GET', '/.*', function () {
    echo "dsfsdfdsfsdfsd";
});
// Home
$router->get('/', function () {
    (new HomeController())->index();
});

$router->set404('\App\Controllers\Error@notFound');

$router->run();
