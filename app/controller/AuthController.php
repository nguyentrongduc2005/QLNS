<?php

namespace App\controller;

use App\model\User;
use Config\View;

class AuthController
{
    public function showLogin()
    {
        $twig = View::getView();
        echo $twig->render('login.twig');
    }

    public function login()
{
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = User::where('username', $username)->first();

    if ($user && password_verify($password, $user->password)) {
        $_SESSION['user_id'] = $user->user_id;
        header("Location: /");
    } else {
        $twig = View::getView();
        echo $twig->render('login.twig', ['error' => 'Sai tài khoản hoặc mật khẩu']);
    }
}

   
   public function apiLogin()
{
    header('Content-Type: application/json');

    $json = json_decode(file_get_contents("php://input"), true);
    $username = $json['username'] ?? '';
    $password = $json['password'] ?? '';

    $user = User::where('username', $username)->first();

    if ($user && password_verify($password, $user->password)) {
        echo json_encode([
            'status' => 'success',
            'user' => [
                'id' => $user->user_id,
                'username' => $user->username,
                'role' => $user->role,
                'status' => $user->status
            ]
        ]);
    } else {
        http_response_code(401);
        echo json_encode([
            'status' => 'error',
            'message' => 'Sai tài khoản hoặc mật khẩu'
        ]);
    }
}

}
