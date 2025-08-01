<?php

// helpers/auth.php
function authorize(array $roles = [])
{
    if (!isset($_SESSION['user'])) {
        http_response_code(401);
        header('Location: ' . $_ENV['APP_URL'] . '/' . $_ENV['APP_NAME'] . '/' . $_ENV['APP_PUBLIC'] . '/login');
        exit;
    }

    $user = $_SESSION['user'];

    if (!in_array($user['role'], $roles)) {
        http_response_code(403);
        renderView('ErrorCustom.twig', [
            'error' => 'Không có quyền truy cập.',
            'code' => 'forbidden',
            'http_code' => 403,
        ]);
        exit;
    }
}

function renderView($view, $data = [])
{
    $twig = \Config\View::getView();
    echo $twig->render($view, array_merge(['env' => $_ENV], $data));
}
