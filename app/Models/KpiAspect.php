<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KpiAspect extends Model
{
    protected $table = 'performance_kpi_name';

    protected $fillable = [
        'name'
    ];

    public function kpis()
    {
        return $this->hasMany(PerformanceKpi::class, 'kpi_id', 'id');
    }

}
