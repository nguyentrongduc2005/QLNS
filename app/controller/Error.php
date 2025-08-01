<?php

namespace App\Controller;

use Config\View;

class Error
{
    public function notFound()
    {
        http_response_code(404);
        $twig = View::getView();
        echo $twig->render('error.twig', [
            'env' => $_ENV
        ]);
        // Hoặc bạn có thể render view ở đây
        // include '../views/errors/404.php';
    }
}
