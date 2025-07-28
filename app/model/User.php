<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user'; // Tên bảng trong DB
    protected $primaryKey = 'user_id';
    public $timestamps = true; // Nếu bảng không có cột created_at, updated_at
}
