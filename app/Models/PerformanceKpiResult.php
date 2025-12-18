<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PerformanceKpiResult extends Model
{
    use SoftDeletes;

    protected $table = 'performance_kpi_results';
    protected $fillable =[
        'user_created',
        'user_updated',
        'employee_id',
        'kpi_id',
        'month',
        'year',
        'grade'
    ];

    public function employees()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function kpiName()
    {
        return $this->belongsTo(PerformanceKpiName::class, 'kpi_id');
    }

    public function details()
    {
        return $this->hasMany(PerformanceKpiResultDetail::class, 'kpi_results_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_created');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'user_updated');
    }

}
