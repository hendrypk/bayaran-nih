<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaporHr extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'employee_id',
        'category_id',
        'report_description',
        'solve_description',
        'status',
        'report_date',
        'solve_date'
    ];

    public function category ()
    {
        return $this->belongsTo(LaporHrCategory::class, 'category_id');
    }

    public function employee ()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function attachments() 
    {
        return $this->hasMany(LaporHrAttachment::class, 'lapor_hr_id');
    }
    
}
