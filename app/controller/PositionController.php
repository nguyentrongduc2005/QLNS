<?php

namespace App\Controller;

// use App\Models\User;
use Config\View;


class PositionController
{


    public function index()
    {
        $twig = View::getView();

        $positions = \App\Models\Position::all(); // [{ id: 1, ten_chucvu: "Quản lý", mo_ta: "..." }]
        echo $twig->render('hr/positions.twig', [
            'env' => $_ENV,
            'currentRoute' => 'positions',
            'role' => $_SESSION['user']['role'] ?? '',
            'positions' => $positions
        ]);
    }
}