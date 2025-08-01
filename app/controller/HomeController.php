<?php

namespace App\Controller;
use Config\View;
use App\Models\User;
class HomeController
{


    public function index()
    {
        $twig = View::getView();

        $users = User::all()->toArray();
        echo $twig->render('home.twig', [
            'currentRoute' => 'dashboard',
            'users' => $users,
            'role' => $_SESSION['user']['role'] ?? '',
            'env' => $_ENV
        ]);
    }
}