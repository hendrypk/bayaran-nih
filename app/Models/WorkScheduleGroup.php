<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class WorkScheduleGroup extends Model
{
    protected $fillable = [
        'name',
        'count_late',
        'tolerance',
    ];

    public function days()
    {
        return $this->hasMany(WorkScheduleDay::class, 'work_schedule_group_id');
    }

    public function getEffectiveWorkingDays($month, $year)
    {
        $map = [
            'monday'    => 1,
            'tuesday'   => 2,
            'wednesday' => 3,
            'thursday'  => 4,
            'friday'    => 5,
            'saturday'  => 6,
            'sunday'    => 7,
        ];

        $workingDays = $this->days()
            ->where('is_offday', 0)
            ->pluck('day')
            ->map(fn($d) => $map[strtolower($d)] ?? null)
            ->filter()
            ->toArray();

        if (empty($workingDays)) {
            return 0;
        }

        $holidays = \App\Models\Holiday::whereMonth('date', $month)
            ->whereYear('date', $year)
            ->pluck('date')
            ->map(fn($d) => Carbon::parse($d)->toDateString())
            ->toArray();

        $effective = 0;
        $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        for ($i = 1; $i <= $totalDays; $i++) {

            $date = Carbon::create($year, $month, $i)->startOfDay();
            $dayOfWeek = $date->dayOfWeekIso; 

            if (!in_array($dayOfWeek, $workingDays)) {
                continue;
            }

            if (in_array($date->toDateString(), $holidays)) {

                if ($dayOfWeek != 7) {  
                    continue;
                }
            }

            $effective++;
        }

        return $effective;
    }


}
