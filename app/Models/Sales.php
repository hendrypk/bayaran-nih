<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sales extends Model
{
    use HasFactory;

    protected $table = 'sales';
    protected $fillable = [
        'month',
        'year',
        'employee_id',
        'qty',
    ];

    public function employees(){
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
