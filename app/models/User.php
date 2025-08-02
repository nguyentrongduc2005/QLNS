<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user'; // Tên bảng trong DB
    protected $primaryKey = 'user_id'; // Khóa chính của bảng
    public $timestamps = true; // Nếu bảng không có cột created_at, updated_at
    protected $fillable = ['username', 'name', 'password', 'role', 'details_id', 'status'];

    // Quan hệ với bảng `details`:
    public function detail()
    {
        return $this->belongsTo(Detail::class, 'details_id', 'details_id');
    }
}
