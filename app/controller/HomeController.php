<?php

namespace App\Controller;

use Config\View;
use App\Models\User;
use App\Models\Department;
use App\Models\Detail;
use App\Models\Position;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;

class HomeController
{


    public function index()
    {
        $twig = View::getView();

        if ($_SESSION['user']['role'] == 'admin' || $_SESSION['user']['role'] == 'boss') {
            // Redirect to login if user role is not set
            echo $twig->render('home/home.twig', [
                'currentRoute' => 'dashboard',
                'role' => $_SESSION['user']['role'] ?? '',
                'env' => $_ENV,
                'total_employee' => $this->getEmployeeData(),
                'total_department' => $this->getDepartmentData(),
                'total_position' => $this->getPositionData(),
                'on_leave_today' => $this->getAmountOfEmployeesLeaveToday(),
                'expiring_contracts' => [
                    ['code' => 'NV001', 'name' => 'Nguyễn A', 'department' => 'Kế toán', 'expiry_date' => '2025-09-15'],
                    ['code' => 'NV002', 'name' => 'Trần B', 'department' => 'Kỹ thuật', 'expiry_date' => '2025-10-01'],
                    ['code' => 'NV003', 'name' => 'Lê C', 'department' => 'Nhân sự', 'expiry_date' => '2025-10-20']
                ],
                'chart_labels' => $this->getChartLabels(),
                'chart_data' => $this->getChartData(), //[10, 20, 30, 40, 50],
                'months' => $this->getRecent3MonthsChartData()['months'], // ['Tháng 6', 'Tháng 7', 'Tháng 8']
                'employee_by_month' => $this->getRecent3MonthsChartData()['employee_by_month'],
                'attendance_labels' => $this->getOnTimeAttendanceData()['attendance_labels'],
                'attendance_data' => $this->getOnTimeAttendanceData()['attendance_data'],
            ]);
        } else {
            // Redirect to login if user role is not admin or boss
            header('Location: ' . $_ENV['APP_URL'] . '/' . $_ENV['APP_NAME'] . '/' . $_ENV['APP_PUBLIC'] . '/profile');
        }
    }

    public function getEmployeeData()
    {
        $employees = User::where('role', '!=', 'admin')->get();
        return count($employees);
    }

    public function getDepartmentData()
    {
        $departments = Department::all();
        return count($departments);
    }

    public function getPositionData()
    {
        $positions = Position::all();
        return count($positions);
    }

    public function getAmountOfEmployeesLeaveToday()
    {
        $today = date('Y-m-d');
        $leaveRequests = LeaveRequest::whereDate('from_date', '<=', $today)
            ->whereDate('to_date', '>=', $today)
            ->where('status', 'approved')
            ->get();
        return count($leaveRequests);
    }
    public function getChartLabels()
    {
        $departments = Department::all();
        $labels = [];
        foreach ($departments as $department) {
            $labels[] = $department->name;
        }
        return $labels;
    }

    public function getChartData()
    {
        $labels = $this->getChartLabels(); // danh sách tên phòng ban theo thứ tự mong muốn

        // Lấy số lượng nhân viên theo department_id
        $employees = Detail::selectRaw('department_id, COUNT(*) as count')
            ->groupBy('department_id')
            ->pluck('count', 'department_id'); // kết quả: [1 => 10, 2 => 20, ...]

        // Lấy danh sách ID phòng ban tương ứng với từng tên
        $id_department = Department::whereIn('name', $labels)->pluck('department_id', 'name'); // [name => id]

        // Tạo mảng kết quả theo đúng thứ tự labels
        $chartData = [];
        foreach ($labels as $label) {
            $deptId = $id_department[$label] ?? 0;
            $chartData[] = $employees[$deptId] ?? 0;
        }

        return $chartData; // VD: [10, 20, 30, 0, 5]
    }

    public function getRecent3MonthsChartData()
    {
        // Lấy 3 tháng gần nhất (bao gồm tháng hiện tại)
        $now = Carbon::now();
        $months = [];

        for ($i = 2; $i >= 0; $i--) {
            $months[] = $now->copy()->subMonths($i);
        }

        // Tạo mảng map [month_number => 0] ví dụ: [6 => 0, 7 => 0, 8 => 0]
        $monthMap = [];
        foreach ($months as $month) {
            $monthMap[$month->month] = 0;
        }

        // Lấy dữ liệu tuyển dụng theo tháng trong 3 tháng gần nhất
        $data = Detail::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereBetween('created_at', [$months[0]->startOfMonth(), $months[2]->endOfMonth()])
            ->groupBy('month')
            ->pluck('total', 'month'); // [6 => 5, 8 => 2]

        // Gán số lượng vào map
        foreach ($data as $month => $count) {
            if (isset($monthMap[$month])) {
                $monthMap[$month] = $count;
            }
        }

        // Trả dữ liệu về theo thứ tự thời gian [tháng 6, 7, 8]
        $labels = [];
        $chartData = [];

        foreach ($months as $month) {
            $labels[] = 'Tháng ' . $month->month;
            $chartData[] = $monthMap[$month->month];
        }

        return [
            'months' => $labels,            // ['Tháng 6', 'Tháng 7', 'Tháng 8']
            'employee_by_month' => $chartData  // [5, 3, 8]

        ];
    }

    public function getOnTimeAttendanceData()
    {
        // Ngày hiện tại
        $today = Carbon::today();

        // Ngày bắt đầu (5 ngày trước)
        $startDate = $today->copy()->subDays(4); // Lấy đủ 5 ngày

        // Lấy dữ liệu chấm công đúng giờ theo từng ngày
        $data = Attendance::selectRaw('DATE(date) as date_only, COUNT(*) as total')
            ->whereBetween('date', [$startDate, $today])
            ->whereTime('check_in', '<=', '07:30:00') // Chấm công đúng giờ
            ->groupBy('date_only')
            ->orderBy('date_only')
            ->pluck('total', 'date_only'); // [2025-07-30 => 10, 2025-08-01 => 32, ...]

        // Tạo danh sách ngày và gán mặc định = 0 nếu không có
        $labels = [];
        $counts = [];

        for ($i = 0; $i < 5; $i++) {
            $date = $startDate->copy()->addDays($i);
            $formatted = $date->format('d/m'); // dạng 01/08

            $labels[] = $formatted;
            $counts[] = $data[$date->toDateString()] ?? 0;
        }

        return [
            'attendance_labels' => $labels,
            'attendance_data' => $counts,
        ];
    }
}
