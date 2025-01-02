<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Performance extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'performance';
    protected $dates = ['deleted_at']; 
}
