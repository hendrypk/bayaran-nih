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
        $countStartDate = Carbon::parse($startDate)->startOfDay();
        $countEndDate   = Carbon::parse($endDate)->endOfDay();

        // $countStartDate = $startDate ? Carbon::parse($startDate) : Carbon::now()->startOfMonth();
        // $countEndDate   = $endDate ? Carbon::parse($endDate) : Carbon::now();

        $employees->each(function ($employee) use ($countStartDate, $countEndDate) {

            // ----- Total Hari & WorkDay -----
            $totalDays = intval($countStartDate->diffInDays($countEndDate) + 1);

            $effectiveDays = $this->calculateEffectiveDays($employee, $countStartDate, $countEndDate);

            // ----- Presence -----
            $employee->presence = Presence::where('employee_id', $employee->id)
                ->whereNull('leave')
                ->whereBetween('date', [$countStartDate, $countEndDate])
                ->count('date');

            // ----- Overtime -----
            $employee->total_overtime = Overtime::where('employee_id', $employee->id)
                ->where('status', 1)
                ->whereBetween('date', [$countStartDate, $countEndDate])
                ->sum('total');

            // ----- Late / Early -----
            $employee->late_check_in   = $this->sumPresenceField($employee->id, $countStartDate, $countEndDate, 'late_check_in');
            $employee->check_out_early = $this->sumPresenceField($employee->id, $countStartDate, $countEndDate, 'check_out_early');
            $employee->late_arrival    = Presence::where('employee_id', $employee->id)
                                                ->whereBetween('date', [$countStartDate, $countEndDate])
                                                ->where('late_arrival', 1)
                                                ->count();

            // ----- Leaves -----
            $employee->annual_leave     = $this->countLeave($employee->id, PRESENCE::LEAVE_ANNUAL, $countStartDate, $countEndDate);
            $employee->sick_permit      = $this->countLeave($employee->id, PRESENCE::LEAVE_SICK, $countStartDate, $countEndDate);
            $employee->full_day_permit  = $this->countLeave($employee->id, PRESENCE::LEAVE_FULL_DAY_PERMIT, $countStartDate, $countEndDate);
            $employee->half_day_permit  = $this->countLeave($employee->id, PRESENCE::LEAVE_HALF_DAY_PERMIT, $countStartDate, $countEndDate);

            // ----- Holiday -----
            $employee->holiday = Holiday::whereBetween('date', [$countStartDate, $countEndDate])
                                        ->count('date');

            // ----- Alpha -----
            $employee->alpha = $effectiveDays
                - $employee->annual_leave
                - $employee->sick_permit
                - $employee->full_day_permit
                - $employee->half_day_permit
                - $employee->presence
                - $employee->holiday;
        });

        return $employees;
    }

    /**
     * Hitung effectiveDays berdasarkan WorkDay karyawan
     */
    private function calculateEffectiveDays($employee, $start, $end)
    {
        $wd = $employee->workDay->first();
        $dayOffs = $wd->days->filter(fn($day) => $day->is_offday)->pluck('day');
        // $dayOffs = WorkDay::where('name', $wdName)->where('day_off', 1)->pluck('day');

        $dayOffCount = 0;

        foreach ($dayOffs as $dayOffName) {
            $dayOffWeekday = Carbon::parse($dayOffName)->dayOfWeek;

            for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                if ($date->dayOfWeek === $dayOffWeekday) {
                    $dayOffCount++;
                }
            }
        }

        return intval($start->diffInDays($end) + 1) - $dayOffCount;
    }

    /**
     * Hitung jumlah leave untuk tipe tertentu
     */
    private function countLeave($employeeId, $leaveType, $start, $end)
    {
        return Presence::where('employee_id', $employeeId)
                    ->where('leave', $leaveType)
                    ->where('leave_status', 1)
                    ->whereBetween('date', [$start, $end])
                    ->count();
    }

    /**
     * Sum field tertentu di tabel Presence
     */
    private function sumPresenceField($employeeId, $start, $end, $field)
    {
        return Presence::where('employee_id', $employeeId)
                    ->whereBetween('date', [$start, $end])
                    ->sum($field);
    }

    /**
     * Hitung Active Days khusus KPI (Total Hari Bulan - Holiday kecuali Minggu)
     */
    private function getActiveDaysForKpi($month, $year)
    {
        $totalDays = Carbon::createFromDate($year, $month, 1)->daysInMonth;

        $holidays = Holiday::whereMonth('date', $month)
                        ->whereYear('date', $year)
                        ->get();

        $holidayDays = $holidays->filter(fn($h) => Carbon::parse($h->date)->dayOfWeek !== Carbon::SUNDAY)
                                ->count();

        return $totalDays - $holidayDays;
    }

    // private function calculatePresenceSummary($employees, $startDate, $endDate)
    // {
    //     $countStartDate = $startDate ? Carbon::parse($startDate) : Carbon::now()->startOfMonth();
    //     $countEndDate = $endDate ? Carbon::parse($endDate) : Carbon::now();

    //     $employees->each(function ($employee) use ($countStartDate, $countEndDate) {
    //         $totalDays = intval($countStartDate->diffInDays($countEndDate) + 1);

    //         // Work Day Calculations
    //         $wd = $employee->workDay;
    //         $wdName = $wd->pluck('name')->first();
    //         $dayOff = WorkDay::where('name', $wdName)->where('day_off', 1)->pluck('day');
    //         $dayOffCount = 0;

    //         foreach ($dayOff as $dayOffName) {
    //             $dayOffWeekday = Carbon::parse($dayOffName)->dayOfWeek;
    //             for ($date = $countStartDate->copy(); $date->lte($countEndDate); $date->addDay()) {
    //                 if ($date->dayOfWeek === $dayOffWeekday) {
    //                     $dayOffCount++;
    //                 }
    //             }
    //         }

    //         $effectiveDays = $totalDays - $dayOffCount;

    //         // Presence
    //         $employee->presence = Presence::where('employee_id', $employee->id)
    //             ->whereNull('leave')
    //             ->whereBetween('date', [$countStartDate, $countEndDate])
    //             ->count('date');

    //         // Overtime
    //         $employee->total_overtime = Overtime::where('employee_id', $employee->id)
    //             ->where('status', 1)
    //             ->whereBetween('date', [$countStartDate, $countEndDate])
    //             ->sum('total');

    //         // Late Check-in and Early Check-out
    //         $employee->late_check_in = Presence::where('employee_id', $employee->id)
    //             ->whereBetween('date', [$countStartDate, $countEndDate])
    //             ->sum('late_check_in');
    //         $employee->check_out_early = Presence::where('employee_id', $employee->id)
    //             ->whereBetween('date', [$countStartDate, $countEndDate])
    //             ->sum('check_out_early');

    //         // Late Arrival
    //         $employee->late_arrival = Presence::where('employee_id', $employee->id)
    //             ->whereBetween('date', [$countStartDate, $countEndDate])
    //             ->where('late_arrival', 1)
    //             ->count();

    //         // Leaves
    //         $annual_leave = PRESENCE::LEAVE_ANNUAL;
    //         $sick = PRESENCE::LEAVE_SICK;
    //         $full_day_permit = PRESENCE::LEAVE_FULL_DAY_PERMIT;
    //         $half_day_permit = PRESENCE::LEAVE_HALF_DAY_PERMIT;

    //         $employee->annual_leave = Presence::where('employee_id', $employee->id)
    //             ->where('leave', PRESENCE::LEAVE_ANNUAL)
    //             ->where('leave_status', 1)
    //             ->whereBetween('date', [$countStartDate, $countEndDate])
    //             ->count();
    //         $employee->sick_permit = Presence::where('employee_id', $employee->id)
    //             ->where('leave', PRESENCE::LEAVE_SICK)
    //             ->where('leave_status', 1)
    //             ->whereBetween('date', [$countStartDate, $countEndDate])
    //             ->count();
    //         $employee->full_day_permit = Presence::where('employee_id', $employee->id)
    //             ->where('leave', PRESENCE::LEAVE_FULL_DAY_PERMIT)
    //             ->where('leave_status', 1)
    //             ->whereBetween('date', [$countStartDate, $countEndDate])
    //             ->count();
    //         $employee->half_day_permit = Presence::where('employee_id', $employee->id)
    //             ->where('leave', PRESENCE::LEAVE_HALF_DAY_PERMIT)
    //             ->where('leave_status', 1)
    //             ->whereBetween('date', [$countStartDate, $countEndDate])
    //             ->count();
                
    //         //Holiday
    //         $employee->holiday = Holiday::whereBetween('date', [$countStartDate, $countEndDate])
    //             ->count('date');
            
    //         // Alpha
    //         $employee->alpha = $effectiveDays - $employee->annual_leave - $employee->sick_permit - $employee->$full_day_permit - $employee->$half_day_permit - $employee->presence - $employee->holiday;
    //     });

    //     return $employees;
    // }
}