<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeLocation extends Model
{
    use HasFactory;

    protected $table = 'office_locations';
    protected $fillable = [
        'name',
        'location',
        'latitude',
        'longitude',
        'radius',
    ];

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_office_location');
    }


}
