<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendance'; // Tên bảng trong DB
    protected $primaryKey = 'id_attendance'; // Khóa chính của bảng
    public $timestamps = true; // Nếu bảng không có cột created_at, updated_at
    protected $fillable = ['details_id', 'date', 'check_in', 'check_out', 'note'];

    // Quan hệ với bảng `details`:
    public function detail()
    {
        return $this->belongsTo(Detail::class, 'details_id', 'details_id');
    }
}
