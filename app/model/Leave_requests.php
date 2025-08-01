<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $table = 'leave_requests'; // Tên bảng trong DB
    protected $primaryKey = 'id_leave'; // Khóa chính của bảng
    public $timestamps = true; // Nếu bảng không có cột created_at, updated_at
    protected $fillable = ['employee_id', 'from_date', 'to_date', 'note', 'status'];

    // Quan hệ với bảng `detail`:
    public function detail()
    {
        return $this->belongsTo(Detail::class, 'employee_id', 'employees_id');
    }
}
