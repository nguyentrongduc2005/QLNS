<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendance';
    protected $primaryKey = 'id_attendance';
    public $timestamps = true;
    protected $fillable = ['details_id', 'date', 'check_in', 'check_out', 'note'];

    // Quan hệ với bảng details
    public function detail() {
        return $this->belongsTo(Detail::class, 'details_id');
    }
}

