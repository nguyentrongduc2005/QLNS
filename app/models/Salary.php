<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $table = 'salaries';
    protected $primaryKey = 'id_salary';
    public $timestamps = true;
    protected $fillable = ['details_id', 'month', 'base_salary', 'allowance', 'overtime_pay', 'deduction', 'net_salary'];

    // Quan hệ với bảng details
    public function detail() {
        return $this->belongsTo(Detail::class, 'details_id');
    }
}

