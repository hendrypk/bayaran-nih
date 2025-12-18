<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeWorkSchedule extends Model
{
    protected $fillable = [
        'employee_id',
        'work_schedule_group_id',
        'created_at',
        'updated_at',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function workScheduleGroup()
    {
        return $this->belongsTo(WorkScheduleGroup::class);
    }
}
