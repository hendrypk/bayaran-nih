<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkDay extends Model
{
    use HasFactory, SoftDeletes;

    protected $table ='work_days';
    protected $fillable = [
        'name',
        'day',
        'day_off',
        'tolerance',
        'arrival',
        'check_in',
        'check_out',
        'break_in',
        'break_out',
        'break',
        'late_check_in',
        'late_arrival',
        'check_out_eraly',
        'count_late',
    ];
    protected $dates = ['deleted_at']; 

    public function employees(){
        return $this->belongsToMany(Employee::class, 'employee_work_day', 'work_day_id', 'employee_id', );
    }
}
