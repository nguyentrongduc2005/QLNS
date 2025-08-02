<?php

namespace App\Controller;

use Config\View;

class DetailsController
{
    public function index()
    {
        $twig = View::getView();

        echo $twig->render('hr/details.twig', [ 
            'env' => $_ENV,
            'currentRoute' => 'details', 
            'role' => $_SESSION['user']['role'] ?? ''
        ]);
    }
}
