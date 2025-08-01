<?php

namespace App\Controller;

use App\Models\User;
use Config\View;
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception;

class AuthController
{   
    // Kiểm tra nếu người dùng đã đăng nhập
    private function checkAuth()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit();
        }
    }

    public function showLogin()
    {
        $twig = View::getView();
        echo $twig->render('login.twig', [
            "env" => $_ENV
        ]);
    }

    // Phương thức gửi OTP qua email
    private function sendOtp($email)
    {
        $otp = rand(100000, 999999); // Tạo OTP ngẫu nhiên
        $_SESSION['otp'] = $otp; // Lưu OTP vào session để so sánh

        $mail = new PHPMailer(true);

        try {
            // Cấu hình SMTP
            $mail->isSMTP();                                           
            $mail->Host       = 'smtp.example.com';                       
            $mail->SMTPAuth   = true;                                    
            $mail->Username   = 'your-email@example.com';                
            $mail->Password   = 'your-email-password';                   
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          
            $mail->Port       = 587;                                     

            // Người gửi và người nhận
            $mail->setFrom('no-reply@yourdomain.com', 'Hệ thống quản lý');
            $mail->addAddress($email);

            // Nội dung email
            $mail->isHTML(true);                                  
            $mail->Subject = 'Mã OTP Xác Thực Đổi Mật Khẩu';
            $mail->Body    = 'Mã OTP của bạn là: ' . $otp;

            // Gửi email
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    // Yêu cầu OTP gửi qua email cho người dùng
    public function requestChangePassword()
    {
        $this->checkAuth();  // Kiểm tra nếu người dùng đã đăng nhập

        // Lấy dữ liệu từ request
        $json = json_decode(file_get_contents("php://input"), true);
        $email = $json['email'] ?? '';

        if (empty($email)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Thiếu email']);
            return;
        }

        // Tìm người dùng theo email
        $user = User::where('email', $email)->first();

        if ($user) {
            if ($this->sendOtp($email)) {
                echo json_encode(['status' => 'success', 'message' => 'OTP đã được gửi']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Không thể gửi OTP']);
            }
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Email không tồn tại']);
        }
    }

    // Phương thức login API
    public function apiLogin()
    {
        header('Content-Type: application/json');

        $json = json_decode(file_get_contents("php://input"), true);
        $username = $json['username'] ?? '';
        $password = $json['password'] ?? '';

        if (empty($username) || empty($password)) {
            http_response_code(400); // Bad Request
            echo json_encode([
                'status' => 'error',
                'message' => 'Thiếu tài khoản hoặc mật khẩu'
            ]);
            return;
        }

        $user = User::where('username', $username)->first();

        if ($user && password_verify($password, $user->password)) {
            $_SESSION['user'] = [
                'id' => $user->user_id,
                'username' => $user->username,
                'name' => $user->name,
                'role' => $user->role
            ];
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

    // Phương thức thay đổi mật khẩu
    public function changePassword()
    {
        $this->checkAuth();  // Kiểm tra nếu người dùng đã đăng nhập
        header('Content-Type: application/json');

        $json = json_decode(file_get_contents("php://input"), true);
        $current_password = $json['current_password'] ?? '';
        $new_password = $json['new_password'] ?? '';
        $otp = $json['otp'] ?? '';  // OTP nhập từ người dùng
        $user_id = $_SESSION['user']['id'];

        // Kiểm tra nếu thiếu mật khẩu hoặc OTP
        if (empty($current_password) || empty($new_password) || empty($otp)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Thiếu mật khẩu hoặc OTP']);
            return;
        }

        // Kiểm tra xem OTP có khớp với OTP đã gửi không
        if ($otp !== $_SESSION['otp']) {
            http_response_code(401);
            echo json_encode(['status' => 'error', 'message' => 'OTP không đúng']);
            return;
        }

        // Kiểm tra mật khẩu hiện tại
        $user = User::find($user_id);
        if (!password_verify($current_password, $user->password)) {
            http_response_code(401);
            echo json_encode(['status' => 'error', 'message' => 'Mật khẩu hiện tại không đúng']);
            return;
        }

        // Thực hiện thay đổi mật khẩu
        $user->password = password_hash($new_password, PASSWORD_BCRYPT);
        $user->save();

        // Xóa OTP đã lưu trong session
        unset($_SESSION['otp']);

        echo json_encode([
            'status' => 'success',
            'message' => 'Đổi mật khẩu thành công'
        ]);
    }

    // Phương thức hiển thị trang đổi mật khẩu
    public function showChangePassword()
    {
        $this->checkAuth(); 

        $twig = View::getView();
        echo $twig->render('change-password.twig');
    }
}
