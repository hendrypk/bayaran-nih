<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceAppraisal extends Model
{
    use HasFactory;

    protected $table = 'performance_appraisals';
    protected $fillable = ['appraisal_id', 'aspect'];
    
    public function gradePas()
    {
        return $this->hasMany(GradePa::class, 'appraisal_id');
    }

}
