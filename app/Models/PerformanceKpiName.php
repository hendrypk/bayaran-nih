<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PerformanceKpiName extends Model
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

    public function indicators()
    {
        return $this->hasMany(PerformanceKpi::class, 'kpi_id', 'id');
    }

}
