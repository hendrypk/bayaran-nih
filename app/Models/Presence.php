<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Presence extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'employee_id',
        'eid',
        'employee_name',
        'work_day_id',
        'date',
        'check_in',
        'check_out',
        'late_arrival',
        'late_check_in',
        'check_out_early',
        'note_in',
        'note_out',
        'photo_in',
        'photo_out',
        'location_in',
        'location_out'
    ];
    protected $dates = ['deleted_at']; 

    // protected $casts = [
    //     'date' => 'date',
    // ];

    protected $casts = [
        'late_arrival' => 'integer',
    ];

    
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
        
    public function workDay()
    {
        return $this->belongsTo(WorkDay::class, 'work_day_id'); // Adjust 'work_day_id' based on your actual column
    }


}
