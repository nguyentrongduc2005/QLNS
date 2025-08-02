<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $table = 'details'; // Tên bảng trong DB
    protected $primaryKey = 'details_id'; // Khóa chính của bảng
    public $timestamps = true; // Nếu bảng không có cột created_at, updated_at
    protected $fillable = [
        'full_name', 'dob', 'gender', 'phone', 'email', 'address', 
        'department_id', 'position_id', 'date_joined', 'status', 
        'created_at', 'avataa', 'otp'
    ]; // Các cột có thể được gán hàng loạt

    // Quan hệ với bảng departments
    public function department() {
        return $this->belongsTo(Department::class, 'department_id');
    }

    // Quan hệ với bảng positions
    public function position() {
        return $this->belongsTo(Position::class, 'position_id');
    }

    // Quan hệ với bảng attendance
    public function attendances() {
        return $this->hasMany(Attendance::class, 'details_id');
    }

    // Quan hệ với bảng evaluation
    public function evaluations() {
        return $this->hasMany(Evaluation::class, 'details_id');
    }

    // Quan hệ với bảng leave_requests
    public function leaveRequests() {
        return $this->hasMany(LeaveRequest::class, 'details_id');
    }

    // Quan hệ với bảng overtime
    public function overtimes() {
        return $this->hasMany(Overtime::class, 'details_id');
    }

    // Quan hệ với bảng salaries
    public function salaries() {
        return $this->hasMany(Salary::class, 'details_id');
    }
}
