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

        // Presence, Absence, and Leaves
        $employee->presence = Presence::where('employee_id', $employee->id)
            ->whereBetween('date', [$countStartDate, $countEndDate])
            ->count('date');
        $employee->absence = intval($effectiveDays - $employee->presence);

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
        $employee->annual_leave = Leave::where('employee_id', $employee->id)
            ->where('category', 'Annual leave')
            ->where('status', 1)
            ->whereBetween('date', [$countStartDate, $countEndDate])
            ->count();
        $employee->sick_leave = Leave::where('employee_id', $employee->id)
            ->where('category', 'Sick')
            ->where('status', 1)
            ->whereBetween('date', [$countStartDate, $countEndDate])
            ->count();
        $employee->permit_leave = Leave::where('employee_id', $employee->id)
            ->where('category', 'Permit')
            ->where('status', 1)
            ->whereBetween('date', [$countStartDate, $countEndDate])
            ->count();
            
        //Holiday
        $employee->holiday = Holiday::whereBetween('date', [$countStartDate, $countEndDate])
            ->count('date');
        
        // Alpha
        $employee->alpha = $effectiveDays - $employee->annual_leave - $employee->sick_leave - $employee->permit_leave - $employee->presence - $employee->holiday;
    });

    return $employees;
}
}