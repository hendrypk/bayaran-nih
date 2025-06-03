<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeePositionChange extends Model
{
    use SoftDeletes; 

    protected $fillable = [
        'employee_id',
        'old_position',
        'new_position',
        'effective_date',
        'reason',
        'category'
    ];

    protected $dates = ['deleted_at']; 

    public function employees () {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function oldPosition () {
        return $this->belongsTo(Position::class, 'old_position');
    }

    public function position () {
        return $this->belongsTo(Position::class, 'new_position');
    }
}
