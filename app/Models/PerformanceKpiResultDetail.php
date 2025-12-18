<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PerformanceKpiResultDetail extends Model
{

    use SoftDeletes;

    protected $table = 'performance_kpi_result_details';
    protected $fillable =[
        'kpi_result_id',
        'aspect',
        'description',
        'target',
        'weight',
        'unit',
        'achievement',
        'result',
    ];

    public function master()
    {
        return $this->belongsTo(PerformanceKpiResult::class, 'kpi_results_id');
    }
}
