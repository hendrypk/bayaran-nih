<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sales extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'sales';
    protected $fillable = [
        'month',
        'year',
        'employee_id',
        'qty',
    ];
    protected $dates = ['deleted_at']; 

    public function employees(){
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
