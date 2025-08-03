<?php

namespace App\Controller;

use App\Models\Detail;
use App\Models\User;
use Config\View;


class EmployeesController
{


    public function index()
    {
        $twig = View::getView();
        $users = User::with(['detail.department', 'detail.position'])->get();

        echo $twig->render('hr/employees.twig', [
            'env' => $_ENV,
            'currentRoute' => 'employees',
            'role' => $_SESSION['user']['role'] ?? '',
            'employees' => $users,
            'departments' => \App\Models\Department::all(),
            'positions' => \App\Models\Position::all(),
        ]);
    }

    public function create()
    {
        // Lấy dữ liệu từ request JSON
        $data = $_POST;

        if (!$data || !isset($data['full_name']) || !isset($data['email'])) {
            http_response_code(400);
            echo json_encode([
                "success" => false,
                'message' => 'Thiếu thông tin bắt buộc'
            ]);
            return;
        }

        // Kiểm tra email đã tồn tại chưa
        if (Detail::where('email', $data['email'])->exists()) {
            http_response_code(409); // Conflict
            echo json_encode([
                "success" => false,
                'message' => 'Email đã tồn tại'
            ]);
            return;
        }
        // Tạo chi tiết
        $detail = new Detail();
        $detail->full_name = $data['full_name'];
        $detail->email = $data['email'];
        $detail->phone = $data['phone'] ?? '';
        $detail->gender = $data['gender'] ?? '';
        $detail->address = $data['address'] ?? '';
        $detail->dob = $data['birthday'] ?? null;
        $detail->date_joined = $data['start_work'] ?? date('Y-m-d');
        $detail->department_id = $data['department_id'] ?? null;
        $detail->position_id = $data['position_id'] ?? null;
        $detail->save();
        // Tạo mới user
        $user = new User();
        $user->username = $this->generateUsername($data['full_name'], $detail->details_id);
        $user->name = $data['full_name'];
        $user->details_id = $detail->details_id; // Liên kết với chi tiết
        $user->password = password_hash('123456', PASSWORD_DEFAULT); // mật khẩu mặc định
        $user->role =  'user';
        $user->status = 'active';
        $user->save();


        echo json_encode([
            'success' => true,
            'message' => 'Thêm mới nhân viên thành công'
        ]);
    }


    public function update($id)
    {
        // Lấy dữ liệu JSON từ request
        $data = $_POST;

        // Tìm user
        $user = User::with('detail')->find($id);

        if (!$user) {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => 'Nhân viên không tồn tại'
            ]);
            return;
        }

        // Cập nhật dữ liệu cơ bản
        $user->name = $data['full_name'] ?? $user->name;

        $user->save();

        // Cập nhật chi tiết
        if ($user->detail) {
            $user->detail->phone = $data['phone'] ?? $user->detail->phone;
            $user->detail->gender = $data['gender'] ?? $user->detail->gender;
            $user->detail->address = $data['address'] ?? $user->detail->address;
            $user->detail->dob = $data['birthday'] ?? $user->detail->dob;
            $user->detail->date_joined = $data['start_work'] ?? $user->detail->date_joined;
            $user->detail->department_id = $data['department_id'] ?? $user->detail->department_id;
            $user->detail->position_id = $data['position_id'] ?? $user->detail->position_id;
            $user->detail->save();
        }

        echo json_encode([
            'success' => true,
            'message' => 'Cập nhật thành công'
        ]);
    }


    public function delete($id)
    {
        // Tìm user theo ID
        $user = User::find($id);

        if (!$user) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Nhân viên không tồn tại']);
            return;
        }

        // Sử dụng transaction để đảm bảo tính toàn vẹn dữ liệu
        try {
            // Bắt đầu transaction
            $this->db->beginTransaction();

            // Bước 1: Xóa các bản ghi liên quan khác trước (nếu có)
            if ($user->detail) {
                // Xóa chấm công
                if (method_exists($user->detail, 'attendances')) {
                    $user->detail->attendances()->delete();
                }

                // Xóa các liên kết khác nếu có
                // $user->detail->otherRelations()->delete();

                // Xóa detail
                $user->detail->delete();
            }

            // Bước 2: Xóa user
            $user->delete();

            // Commit transaction
            $this->db->commit();

            echo json_encode(['success' => true, 'message' => 'Xóa nhân viên thành công']);
        } catch (Exception $e) {
            // Rollback nếu có lỗi
            $this->db->rollback();

            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Lỗi khi xóa nhân viên: ' . $e->getMessage()]);
        }
    }

    function generateUsername($name, $id)
    {
        // Bỏ dấu tiếng Việt
        $name = $this->removeAccents($name);

        // Chuyển thành chữ thường, loại bỏ ký tự đặc biệt và khoảng trắng
        $name = strtolower($name);
        $name = preg_replace('/[^a-z0-9]/', '', $name);

        return $name . "_" . $id;
    }

    function removeAccents($str)
    {
        $unicode = [
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd' => 'đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ'
        ];
        foreach ($unicode as $nonAccent => $accent) {
            $str = preg_replace("/$accent/i", $nonAccent, $str);
        }
        return $str;
    }
}
