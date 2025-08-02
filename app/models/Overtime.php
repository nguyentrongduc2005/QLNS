<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    protected $table = 'overtime'; // Tên bảng trong DB
    protected $primaryKey = 'id_overtime'; // Khóa chính của bảng
    public $timestamps = true; // Nếu bảng không có cột created_at, updated_at
    protected $fillable = ['details_id', 'date', 'hours', 'note'];

    // Quan hệ với bảng `details`:
    public function detail()
    {
        return $this->belongsTo(Detail::class, 'details_id', 'details_id');
    }
}
