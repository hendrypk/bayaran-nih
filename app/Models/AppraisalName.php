<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppraisalName extends Model
{
    protected $table = 'performance_appraisal_name';

    protected $fillable = [
        'name'
    ];

    public function appraisals()
    {
        return $this->hasMany(PerformanceKpi::class, 'appraisal_id', 'id');
    }

}
