<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PerformanceAppraisalResultDetail extends Model
{
    use SoftDeletes;

    protected $table = 'performance_appraisal_result_details';
    protected $fillable =[
        'appraisal_result_id',
        'aspect',
        'description',
        'achievement',
    ];

    public function master()
    {
        return $this->belongsTo(PerformanceAppraisalResult::class, 'appraisal_result_id');
    }
}
