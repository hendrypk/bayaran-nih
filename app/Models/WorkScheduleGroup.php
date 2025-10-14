<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkScheduleGroup extends Model
{
    protected $fillable = [
        'name',
        'count_late',
        'tolerance',
    ];

    public function days()
    {
        return $this->hasMany(WorkScheduleDay::class, 'work_schedule_group_id');
    }
}
