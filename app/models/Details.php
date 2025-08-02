<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $table = 'details'; // Tên bảng trong DB
    protected $primaryKey = 'details_id'; // Khóa chính của bảng
    public $timestamps = true; // Nếu bảng không có cột created_at, updated_at
    protected $fillable = [
        'full_name', 'dob', 'gender', 'phone', 'email', 'address', 'department_id',
        'position_id', 'date_joined', 'status', 'created_at', 'avataa', 'otp'
    ];
}
