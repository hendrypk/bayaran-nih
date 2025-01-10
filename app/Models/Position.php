<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'positions';
    protected $fillable = [
        'name',
        'job_title_id',
        'division_id',
        'department_id'
    ]; 
    protected $dates = ['deleted_at']; 

    public function job_title () {
        return $this->belongsTo(JobTitle::class, 'job_title_id');
    }

    public function division () {
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function department () {
        return $this->belongsTo(Department::class, 'department_id');
    }
    
}
