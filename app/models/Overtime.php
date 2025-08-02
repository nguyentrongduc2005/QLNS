<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    protected $table = 'overtime';
    protected $primaryKey = 'id_overtime';
    public $timestamps = true;
    protected $fillable = ['details_id', 'date', 'hours', 'note'];

    // Quan hệ với bảng details
    public function detail() {
        return $this->belongsTo(Detail::class, 'details_id');
    }
}

