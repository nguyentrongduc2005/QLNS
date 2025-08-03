<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $table = 'leave_requests';
    protected $primaryKey = 'id_leave';
    public $timestamps = true;
    protected $fillable = ['details_id', 'from_date', 'to_date', 'note', 'status'];

    // Quan hệ với bảng details
    public function detail()
    {
        return $this->belongsTo(Detail::class, 'details_id');
    }
}
