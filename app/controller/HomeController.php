<?php

namespace App\Controller;

// use App\Models\User;
use Config\View;

class HomeController
{
    public function index()
    {
        $twig = View::getView();


        $name  = "nguye trọng dc";
        echo $twig->render('home.twig', [
            'name' => 'Nguyễn Trọng Đức'
        ]);
        // $users = User::all();
        // echo $twig->render('home.twig', ['users' => $users]);
    }
}
