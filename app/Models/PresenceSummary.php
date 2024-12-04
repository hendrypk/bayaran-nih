<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PresenceSummary extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'presence_summary';

    public function employee()
    {
        return $this->hasMany(Employee::class);
    }

    protected $fillable = [
        'eid',
        'name',
        'late_arrival',
        'total_overtime',
    ];



}
