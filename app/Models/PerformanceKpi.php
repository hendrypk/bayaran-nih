<?php

namespace App\Models;

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PerformanceKpi extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = ('performance_kpis');

    protected $fillable = [
        'kpi_id',
        'aspect',
        'description',
        'target',
        'weight',
    ];
    protected $dates = ['deleted_at']; 

    protected $casts = [
        'target' => 'decimal:2', // Cast to decimal with 2 decimal places
        'weight' => 'decimal:2',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'position_id');
    }

    public function grade_kpi()
    {
        return $this->hasMany(GradeKpi::class, 'position_id');
    }

}
