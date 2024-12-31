<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class KpiAspect extends Model
{
    use SoftDeletes;

    protected $table = 'performance_kpi_name';

    protected $fillable = [
        'name'
    ];
    protected $dates = ['deleted_at']; 
    
    public function kpis()
    {
        return $this->hasMany(PerformanceKpi::class, 'kpi_id', 'id');
    }

}
