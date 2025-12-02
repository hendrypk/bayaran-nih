<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PerformanceAppraisalName extends Model
{
    use SoftDeletes;

    protected $table = 'performance_appraisal_name';

    protected $fillable = [
        'name'
    ];

    protected $dates = ['deleted_at']; 

    public function appraisals()
    {
        return $this->hasMany(PerformanceAppraisal::class, 'appraisal_id', 'id');
    }
}
