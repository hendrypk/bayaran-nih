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
        'presence_id',
        'start_date',
        'end_date',
        'category',
        'status',
        'note'
    ];
    protected $dates = ['deleted_at']; 
    
    const LEAVE_ACC = 'accepted';
    const LEAVE_REJECT = 'rejected';
    const LEAVE_PENDING = 'pending';

    public function employee() {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
