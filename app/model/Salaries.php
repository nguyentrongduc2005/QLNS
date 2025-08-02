<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $table = 'salaries'; // Tên bảng trong DB
    protected $primaryKey = 'id_salary'; // Khóa chính của bảng
    public $timestamps = true; // Nếu bảng không có cột created_at, updated_at
    protected $fillable = ['details_id', 'month', 'base_salary', 'allowance', 'overtime_pay', 'deduction', 'net_salary'];

    // Quan hệ với bảng `details`:
    public function detail()
    {
        return $this->belongsTo(Detail::class, 'details_id', 'details_id');
    }
}
