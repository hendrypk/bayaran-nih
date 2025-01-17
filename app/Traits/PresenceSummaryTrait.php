<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\Leave;
use App\Models\Holiday;
use App\Models\WorkDay;
use App\Models\Overtime;
use App\Models\Presence;

trait PresenceSummaryTrait

{
private function calculatePresenceSummary($employees, $startDate, $endDate)
{
    $countStartDate = $startDate ? Carbon::parse($startDate) : Carbon::now()->startOfMonth();
    $countEndDate = $endDate ? Carbon::parse($endDate) : Carbon::now();

    $employees->each(function ($employee) use ($countStartDate, $countEndDate) {
        $totalDays = intval($countStartDate->diffInDays($countEndDate) + 1);

        // Work Day Calculations
        $wd = $employee->workDay;
        $wdName = $wd->pluck('name')->first();
        $dayOff = WorkDay::where('name', $wdName)->where('day_off', 1)->pluck('day');
        $dayOffCount = 0;

        foreach ($dayOff as $dayOffName) {
            $dayOffWeekday = Carbon::parse($dayOffName)->dayOfWeek;
            for ($date = $countStartDate->copy(); $date->lte($countEndDate); $date->addDay()) {
                if ($date->dayOfWeek === $dayOffWeekday) {
                    $dayOffCount++;
                }
            }
        }

        $effectiveDays = $totalDays - $dayOffCount;

        // Presence
        $employee->presence = Presence::where('employee_id', $employee->id)
            ->whereNull('leave')
            ->whereBetween('date', [$countStartDate, $countEndDate])
            ->count('date');

        // Overtime
        $employee->total_overtime = Overtime::where('employee_id', $employee->id)
            ->where('status', 1)
            ->whereBetween('date', [$countStartDate, $countEndDate])
            ->sum('total');

        // Late Check-in and Early Check-out
        $employee->late_check_in = Presence::where('employee_id', $employee->id)
            ->whereBetween('date', [$countStartDate, $countEndDate])
            ->sum('late_check_in');
        $employee->check_out_early = Presence::where('employee_id', $employee->id)
            ->whereBetween('date', [$countStartDate, $countEndDate])
            ->sum('check_out_early');

        // Late Arrival
        $employee->late_arrival = Presence::where('employee_id', $employee->id)
            ->whereBetween('date', [$countStartDate, $countEndDate])
            ->where('late_arrival', 1)
            ->count();

        // Leaves
        $annual_leave = PRESENCE::LEAVE_ANNUAL;
        $sick = PRESENCE::LEAVE_SICK;
        $full_day_permit = PRESENCE::LEAVE_FULL_DAY_PERMIT;
        $half_day_permit = PRESENCE::LEAVE_HALF_DAY_PERMIT;

        $employee->annual_leave = Presence::where('employee_id', $employee->id)
            ->where('leave', PRESENCE::LEAVE_ANNUAL)
            ->where('leave_status', 1)
            ->whereBetween('date', [$countStartDate, $countEndDate])
            ->count();
        $employee->sick_permit = Presence::where('employee_id', $employee->id)
            ->where('leave', PRESENCE::LEAVE_SICK)
            ->where('leave_status', 1)
            ->whereBetween('date', [$countStartDate, $countEndDate])
            ->count();
        $employee->full_day_permit = Presence::where('employee_id', $employee->id)
            ->where('leave', PRESENCE::LEAVE_FULL_DAY_PERMIT)
            ->where('leave_status', 1)
            ->whereBetween('date', [$countStartDate, $countEndDate])
            ->count();
        $employee->half_day_permit = Presence::where('employee_id', $employee->id)
            ->where('leave', PRESENCE::LEAVE_HALF_DAY_PERMIT)
            ->where('leave_status', 1)
            ->whereBetween('date', [$countStartDate, $countEndDate])
            ->count();
            
        //Holiday
        $employee->holiday = Holiday::whereBetween('date', [$countStartDate, $countEndDate])
            ->count('date');
        
        // Alpha
        $employee->alpha = $effectiveDays - $employee->annual_leave - $employee->sick_permit - $employee->$full_day_permit - $employee->$half_day_permit - $employee->presence - $employee->holiday;
    });

    return $employees;
}
}