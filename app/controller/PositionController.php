<?php

namespace App\Controller;

// use App\Models\User;
use Config\View;


class PositionController
{


    public function index()
    {
        $twig = View::getView();


        echo $twig->render('hr/positions.twig', [
            'env' => $_ENV,
            'currentRoute' => 'positions',
            'role' => $_SESSION['user']['role'] ?? ''
        ]);
    }
}
