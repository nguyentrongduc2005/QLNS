<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $table = 'leave_requests'; // Tên bảng trong DB
    protected $primaryKey = 'id_leave'; // Khóa chính của bảng
    public $timestamps = true; // Nếu bảng không có cột created_at, updated_at
    protected $fillable = ['details_id', 'from_date', 'to_date', 'note', 'status'];

    // Quan hệ với bảng `details`:
    public function detail()
    {
        return $this->belongsTo(Detail::class, 'details_id', 'details_id');
    }
}
