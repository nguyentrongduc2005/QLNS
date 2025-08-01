<?php

namespace App\Controller;

// use App\Models\User;
use Config\View;


class DepartmentController
{


    public function index()
    {
        $twig = View::getView();


        echo $twig->render('hr/departments.twig', [
            'env' => $_ENV,
            'currentRoute' => 'departments',
            'role' => $_SESSION['user']['role'] ?? ''
        ]);
    }
}
