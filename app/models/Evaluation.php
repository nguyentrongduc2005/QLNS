<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $table = 'evaluation';
    protected $primaryKey = 'id_evaluation';
    public $timestamps = true;
    protected $fillable = ['details_id', 'month', 'kpi_score', 'evaluator_id', 'note'];

    // Quan hệ với bảng details (Nhân viên được đánh giá)
    public function detail() {
        return $this->belongsTo(Detail::class, 'details_id');
    }

    // Quan hệ với bảng evaluator (Người đánh giá)
    public function evaluator() {
        return $this->belongsTo(Detail::class, 'evaluator_id');
    }
}
