<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\WorkDay;
use App\Models\Employee;
use App\Models\Overtime;
use App\Models\Presence;
use Illuminate\Http\Request;
use App\Models\PresenceSummary;

class PresenceSummaryController extends Controller
{
    function index(Request $request){
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        //Get Employee
        $employees = Employee::with('overtimes', 'presences', 'WorkDay')->get();
        // $workDays = WorkDay::all();

        $employees->each(function ($employee) use ($startDate, $endDate){

        //Get Total Absence and Presence
        $countStartDate = $startDate ? Carbon::parse($startDate) : Carbon::now()->startOfMonth();
        $countEndDate = $endDate ? Carbon::parse($endDate) : Carbon::now();  

        $totalDays = $countStartDate->diffInDays($countEndDate) + 1;

        $wd = $employee->workDay;
        $wdName = $wd->pluck('name')->first();
        $dayOff = WorkDay::where('name', $wdName)->where('day_off', 1)->pluck('day');
        $dayOffCount = 0;

        foreach($dayOff as $dayOffName) {
            $dayOffWeekday = Carbon::parse($dayOffName)->dayOfWeek; 
            for ($date = $countStartDate->copy(); $date->lte($countEndDate); $date->addDay()) {
                if($date->dayOfWeek === $dayOffWeekday) {
                    $dayOffCount++;
                }
            }
        }
        
        $effectiveDays = $totalDays - $dayOffCount;

        $employee->presence = Presence::where('employee_id', $employee->id)
            ->whereBetween('date', [$countStartDate, $countEndDate])
            ->count('date'); //Total Presence
        
        $employee->absence = intval($effectiveDays - $employee->presence); //Total Absence

        //Overtime Total
            $overtime = Overtime::where('employee_id', $employee->id);
            if($startDate && $endDate){
                $overtime->whereBetween('date', [$startDate, $endDate]);
            }
            $employee->total_overtime = $overtime->sum('total');

        //Late Check In Total
            $late_check_in = Presence::where('employee_id', $employee->id);
            if($startDate && $endDate){
                $late_check_in->whereBetween('date', [$startDate, $endDate]);
            }
            $employee->late_check_in = $late_check_in->sum('late_check_in');

        //Check Out Early Total
            $check_out_early = Presence::where('employee_id', $employee->id);
            if($startDate && $endDate){
                $check_out_early->whereBetween('date', [$startDate, $endDate]);
            }
            $employee->check_out_early = $check_out_early->sum('check_out_early');

        //Count Late Arrival
            $late_arrival = Presence::where('employee_id', $employee->id);

            if ($startDate && $endDate) {
                $late_arrival->whereBetween('date', [$startDate, $endDate]);
            }
            $employee->late_arrival = $late_arrival->where('late_arrival', 1)->count();

            


        });

        return view('presence_summary.index', [
            'employees' => $employees,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }

}
