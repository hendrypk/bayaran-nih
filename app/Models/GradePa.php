<?php

namespace App\Models;

use App\Models\PerformanceAppraisal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class GradePa extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'grade_pas';
    protected $fillable = ['employee_id', 'month', 'year', 'appraisal_id', 'grade'];
 
    protected $casts = [
        'grade' => 'decimal:2', 
    ];
    protected $dates = ['deleted_at']; 

    public function employees()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function appraisal()
    {
        return $this->belongsTo(PerformanceAppraisal::class, 'appraisal_id');
    }
    
}
