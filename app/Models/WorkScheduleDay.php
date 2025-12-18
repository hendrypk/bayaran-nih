<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkScheduleDay extends Model
{

    protected $fillable = [
        'work_schedule_group_id',
        'is_offday',
        'day',
        'arrival',
        'start_time',
        'end_time',
        'break_start',
        'break_end',
        'count_break',
    ];

    public function group()
    {
        return $this->belongsTo(WorkScheduleGroup::class, 'work_schedule_group_id');
    }
}
