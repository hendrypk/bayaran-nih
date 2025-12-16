<?php

namespace App\Models;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Presence extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'employee_id',
        'work_day_id',
        'date',
        'status',
        'check_in',
        'check_out',
        'late_arrival',
        'late_check_in',
        'check_out_early',
        'note_in',
        'note_out',
        'photo_in',
        'photo_out',
        'location_in',
        'location_out',
        'creator',
        'updater',
        'deleter',
    ];
    
    protected $dates = ['deleted_at']; 

    // protected $casts = [
    //     'date' => 'date',
    // ];

    protected $casts = [
        'late_arrival' => 'integer',
        'date' => 'datetime',
        'start_at' => 'time',
        'end_at' => 'time'
    ];

    const STATUS_LEAVE = 'leave';
    const STATUS_SICK = 'sick';
    const STATUS_PERMIT = 'permit';
    const STATUS_HALFDAY = 'halfday';
    const STATUS_ABSENCE = 'absence';
    const STATUS_PRESENCE = 'presence';

    public $start_date;
    public $end_date;

    protected $listeners = ['dateRangeChanged' => 'updateDateRange'];
    
    public function updateDateRange($payload)
    {
        $this->start_date = $payload['start_date'];
        $this->end_date   = $payload['end_date'];
    }

    public function render()
    {
        $query = Presence::with('employee','workDay');

        if ($this->start_date && $this->end_date) {
            $query->whereBetween('date', [$this->start_date, $this->end_date]);
        }

        return view('livewire.presence-table', [
            'presence' => $query->get(),
        ]);
    }
    
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
        
    public function workDay()
    {
        return $this->belongsTo(WorkScheduleGroup::class, 'work_day_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }

    public static function getPresence($employeeId, $startDate, $endDate)
    {
        return self::where('employee_id', $employeeId)
                    ->where(function($q){
                        $q->whereNull('leave')->orWhere('leave', ''); // termasuk empty string
                    })
                    ->whereBetween('date', [
                        Carbon::parse($startDate)->startOfDay(),
                        Carbon::parse($endDate)->endOfDay()
                    ])
                    ->count();
    }



}
