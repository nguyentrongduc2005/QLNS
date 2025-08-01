<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'positions'; // Tên bảng trong DB
    protected $primaryKey = 'position_id'; // Khóa chính của bảng
    public $timestamps = true; // Nếu bảng không có cột created_at, updated_at
    protected $fillable = ['name', 'base_salary', 'description', 'created_at'];
}
