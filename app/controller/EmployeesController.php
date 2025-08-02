<?php

namespace App\Controller;

use Config\View;

class EmployeesController
{
    public function index()
    {
        $twig = View::getView();

        echo $twig->render('hr/employees.twig', [
            'env' => $_ENV,
            'currentRoute' => 'employees',
            'role' => $_SESSION['user']['role'] ?? ''
        ]);
    }
}
