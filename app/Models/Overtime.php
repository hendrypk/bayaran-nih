<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Overtime extends Model
{
    use HasFactory;

    protected $table = 'overtimes';

    protected $fillable = [
        'employee_id',
        'date',
        'start_at',
        'end_at',
        'total',
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
