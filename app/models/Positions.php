<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'positions';
    protected $primaryKey = 'position_id';
    public $timestamps = true;
    protected $fillable = ['name', 'base_salary', 'description', 'created_at'];

    // Quan hệ với bảng details
    public function details() {
        return $this->hasMany(Detail::class, 'position_id');
    }
}

