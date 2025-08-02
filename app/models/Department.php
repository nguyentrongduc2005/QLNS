<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';
    protected $primaryKey = 'department_id';
    public $timestamps = true;
    protected $fillable = ['name', 'description', 'created_at'];

    // Quan hệ với bảng details
    public function details() {
        return $this->hasMany(Detail::class, 'department_id');
    }
}
