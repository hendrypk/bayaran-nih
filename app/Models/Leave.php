<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leave extends Model
{
    use SoftDeletes;
    
    protected $table = 'leaves';
    protected $fillable = [
        'employee_id',
        'date',
        'start_date',
        'end_date',
        'category',
        'status',
        'note'
    ];

    public function employees() {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
