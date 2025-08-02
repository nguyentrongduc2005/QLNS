<?php

namespace App\Controller;

use App\Models\Detail;
use config\View;

class ProfileController
{
    private function checkAuth()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . $_ENV['APP_URL'] . '/' . $_ENV['APP_NAME'] . '/' . $_ENV['APP_PUBLIC'] . '/login');
            exit();
        }
    }

    public function showProfile()
    {
        $this->checkAuth();

        // Lấy thông tin người dùng từ bảng details
        $user = Detail::find($_SESSION['user']['id']);  // Sử dụng Detail thay vì User

        $twig = View::getView();
        echo $twig->render('profile.twig', [
            'user' => $user
        ]);
    }

    public function updateProfile()
    {
        $this->checkAuth();

        // Lấy thông tin người dùng từ bảng details
        $user = Detail::find($_SESSION['user']['id']);  // Sử dụng Detail thay vì User

        // Lấy dữ liệu từ POST
        $full_name = $_POST['full_name'] ?? ''; // Cập nhật tên người dùng
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $address = $_POST['address'] ?? ''; // Có thể thêm thêm các trường khác từ bảng `details`

        // Cập nhật thông tin người dùng
        $user->full_name = $full_name;
        $user->email = $email;
        $user->phone = $phone;
        $user->address = $address;
        $user->save();

        // Chuyển hướng đến trang profile với trạng thái thành công
        header('Location: /profile?status=success');
    }
}
