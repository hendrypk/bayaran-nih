<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Presence; 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Overtime extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'overtimes';

    protected $fillable = [
        'employee_id',
        'date',
        'start_at',
        'end_at',
        'total',
        'status',
        'note_in', 
        'note_out',
        'location_in', 
        'location_out', 
        'photo_in', 
        'photo_out'
    ];

    protected $casts = [
        'date'       => 'date',
        'start_at'   => 'datetime',
        'end_at'     => 'datetime',
        'status'     => 'boolean',
        'total'      => 'integer',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    /**
     * Relasi ke tabel Presensi berdasarkan tanggal dan karyawan yang sama
     */
    public function presence()
    {
        return $this->hasOne(Presence::class, 'employee_id', 'employee_id')
                    ->whereColumn('date', 'overtimes.date');
    }

    /**
     * Mengubah menit menjadi format "2h 30m"
     */
    public function getDurationAttribute()
    {
        if (!$this->total) return '-';
        
        $hours = floor($this->total / 60);
        $minutes = $this->total % 60;

        if ($hours < 1) return $minutes . 'm';
        return "{$hours}h {$minutes}m";
    }

    /**
     * Helper untuk label status
     */
    public function getStatusLabelAttribute()
    {
        if (is_null($this->status)) return 'Pending';
        return $this->status ? 'Approved' : 'Rejected';
    }
}