<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Overtime extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'overtimes';

    protected $fillable = [
        'employee_id',
        'date',
        'start_at',
        'end_at',
        'total',
        'status',
        'note_in', 'note_out' ,
        'location_in', 'location_out', 'photo_in', 'photo_out'
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];


    public function employees()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
    
    public function presence()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    
}
