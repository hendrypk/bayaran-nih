<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GradeKpi extends Model
{
    use HasFactory;

    protected $table = 'grade_kpis';
    protected $fillable =[
        'employee_id',
        'indicator_id',
        'month',
        'year',
        'achievement',
        'grade',
    ];

    protected $casts = [
        'achievement' => 'decimal:2', // Cast to decimal with 2 decimal places
        'grade' => 'decimal:2',
    ];

    public function indicator()
    {
        return $this->belongsTo(PerformanceKpi::class, 'indicator_id', );
    }

    public function employees()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
