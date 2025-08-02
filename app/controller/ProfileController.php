<?php

namespace App\Controller;

use App\Models\Detail;
use config\View;

class ProfileController
{
    // Kiểm tra xem người dùng đã đăng nhập chưa
    private function checkAuth()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . $_ENV['APP_URL'] . '/' . $_ENV['APP_NAME'] . '/' . $_ENV['APP_PUBLIC'] . '/login');
            exit();
        }
    }

    // Hiển thị thông tin người dùng
    public function showProfile()
    {
        $this->checkAuth();

        // Lấy thông tin người dùng từ bảng details
        $user = Detail::find($_SESSION['user']['id']);  

        if (!$user) {
            // Nếu không tìm thấy người dùng, chuyển hướng tới trang lỗi
            header('Location: /error');
            exit();
        }

        // Render trang profile
        $twig = View::getView();
        echo $twig->render('profile.twig', [
            'user' => $user
        ]);
    }

    // Cập nhật thông tin người dùng
    public function updateProfile()
    {
        $this->checkAuth();

        // Lấy thông tin người dùng từ bảng details
        $user = Detail::find($_SESSION['user']['id']);  // Sử dụng Detail thay vì User

        if (!$user) {
            // Nếu không tìm thấy người dùng, chuyển hướng tới trang lỗi
            header('Location: /error');
            exit();
        }

        // Lấy dữ liệu từ POST và thực hiện kiểm tra tính hợp lệ
        $full_name = $_POST['full_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $address = $_POST['address'] ?? '';

        // Kiểm tra tính hợp lệ của dữ liệu
        $errors = [];
        
        if (empty($full_name)) {
            $errors[] = 'Tên không được để trống.';
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email không hợp lệ.';
        }

        if (!preg_match('/^\d{10}$/', $phone)) {
            $errors[] = 'Số điện thoại phải gồm 10 chữ số.';
        }

        // Nếu có lỗi, quay lại trang profile và hiển thị lỗi
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: /profile');
            exit();
        }

        // Cập nhật thông tin người dùng
        $user->full_name = $full_name;
        $user->email = $email;
        $user->phone = $phone;
        $user->address = $address;
        $user->save();

        // Chuyển hướng tới trang profile với trạng thái thành công
        header('Location: /profile?status=success');
    }
}
