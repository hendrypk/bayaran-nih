<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaporHrAttachment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'lapor_hr_id',
        'file_path',
        'type'
    ];

    const TYPE_REPORT = 'report';
    const TYPE_SOLVE = 'solve';
    
    public function lapor_hr () 
    {
        return $this->belongsTo(LaporHr::class, 'lapor_hr_id');
    }
}
