<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobTitle extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table= 'job_titles';
    protected $fillable = ['name', 'section'];
    protected $dates = ['deleted_at']; 

}
