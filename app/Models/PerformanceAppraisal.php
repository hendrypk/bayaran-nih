<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PerformanceAppraisal extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'performance_appraisals';
    protected $fillable = ['appraisal_id', 'aspect', 'description'];
    protected $dates = ['deleted_at']; 
    
    public function appraisals()
    {
        return $this->hasMany(GradePa::class, 'appraisal_id');
    }

}
