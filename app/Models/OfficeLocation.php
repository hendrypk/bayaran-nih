<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfficeLocation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'office_locations';
    protected $fillable = [
        'name',
        'location',
        'latitude',
        'longitude',
        'radius',
    ];
    protected $dates = ['deleted_at']; 

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_office_location');
    }


}
