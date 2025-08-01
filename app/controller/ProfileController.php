<?php

namespace App\Controller;

use App\Models\User;
use Config\View;

class ProfileController
{   
      private function checkAuth()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit();
        }
    }
    
    public function showProfile()
    {   
        $this->checkAuth();
        $user = User::find($_SESSION['user']['id']); 
        $twig = View::getView();
        echo $twig->render('profile.twig', [
            'user' => $user
        ]);
    }

    
    public function updateProfile()
    {
        $this->checkAuth();
        $user = User::find($_SESSION['user']['id']);  

       
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';

        
        $user->name = $name;
        $user->email = $email;
        $user->phone = $phone;
        $user->save();

        
        header('Location: /profile?status=success');
    }
}
