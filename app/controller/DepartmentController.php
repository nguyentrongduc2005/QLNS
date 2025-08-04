<?php

namespace App\Controller;

use App\Models\User;
use Config\View;
use App\Models\Department;


class DepartmentController
{


    public function index()
    {
        $twig = View::getView();

        $departments = Department::all(); // [{ id: 1, ten_phongban: "Phòng IT", mo_ta: "..." }]
        $all_employees = User::all();
        echo $twig->render('hr/departments.twig', [
            'env' => $_ENV,
            'currentRoute' => 'departments',
            'role' => $_SESSION['user']['role'] ?? '',
            'departments' => $departments,
            'all_employees' => $all_employees
        ]);
    }
}