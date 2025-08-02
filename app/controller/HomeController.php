<?php

namespace App\Controller;

use Config\View;
use App\Models\User;

class HomeController
{


    public function index()
    {
        $twig = View::getView();

        if ($_SESSION['user']['role'] == 'admin' || $_SESSION['user']['role'] == 'boss') {
            // Redirect to login if user role is not set
            echo $twig->render('home/home.twig', [
                'currentRoute' => 'dashboard',
                'role' => $_SESSION['user']['role'] ?? '',
                'env' => $_ENV,
                'total_employee' => 123,
                'total_department' => 6,
                'total_position' => 15,
                'on_leave_today' => 2,
                'expiring_contracts' => [
                    ['code' => 'NV001', 'name' => 'Nguyễn A', 'department' => 'Kế toán', 'expiry_date' => '2025-09-15'],
                    ['code' => 'NV002', 'name' => 'Trần B', 'department' => 'Kỹ thuật', 'expiry_date' => '2025-10-01'],
                    ['code' => 'NV003', 'name' => 'Lê C', 'department' => 'Nhân sự', 'expiry_date' => '2025-10-20']
                ],
                'chart_labels' => ['Kế toán', 'Kỹ thuật', 'Nhân sự'],
                'chart_data' => [12, 25, 10],
                'months' => ['Tháng 1', 'Tháng 2', 'Tháng 3'],
                'employee_by_month' => [5, 10, 8],
                'attendance_labels' => ['01/08', '02/08', '03/08'],
                'attendance_data' => [32, 28, 35],
            ]);
        } else {
            // Redirect to login if user role is not admin or boss
            header('Location: ' . $_ENV['APP_URL'] . '/' . $_ENV['APP_NAME'] . '/' . $_ENV['APP_PUBLIC'] . '/profile');
        }
    }
}
