<?php

namespace App\Http\Controllers;

use App\Exports\PresencesExport;
use Carbon\Carbon;
use App\Models\WorkDay;
use App\Models\Employee;
use App\Models\Overtime;
use App\Models\Presence;
use App\Models\WorkSchedule;
use Illuminate\Http\Request;
use App\Imports\PresenceImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PresenceController extends Controller
{

//Presences List
    public function index(Request $request){
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $employees = Employee::with('workDay')->get();
        $workDay = [];
        foreach ($employees as $employee) {
            $workDay[$employee->id] = $employee->workDay->toArray(); 
        }

        $query = Presence::with('employee');
        if($startDate && $endDate){
            $query->whereBetween('date', [$startDate, $endDate]);
        }
        $presence = $query->get();
        $workDays = WorkDay::select(DB::raw('MIN(id) as id'), 'name')
        ->groupBy('name')
        ->get();

        return view('presence.index', compact('employees', 'presence', 'workDay', 'workDays'));
    }

//Import Prresences
    public function import(){
        return view('presence.import');
    }
    public function __construct(Excel $excel){
        $this->excel = $excel;
    }

    public function importStore(Request $request){  
        $errors = []; // Array to store errors

        $request->validate([
            'file' => 'required|file|mimes:xlsx',
        ]);
            
        $file = $request->file('file');
        Excel::import(new PresenceImport, $file);

        if (!empty($errors)) {
            return redirect()->route('presence.import')->withErrors($errors);
        }
        return redirect()->route('presence.import')->with('success', 'Data imported successfully!');
    }

//Presence Add Manual
    public function create(Request $request){
        $employee_id = $request->employee_id;
        $employee = Employee::where('id', $employee_id)->first();
        $eid = $employee->eid;
        $employee_name = $employee->name;
        $date = Carbon::parse($request->date);
        $today = strtolower($date->format('l'));
        $workDayId = $request->workDay;
        $workDay = WorkDay::where('name', $workDayId)->where('day', $today)->first();
        $checked_in = $request->checkin;
        $cheked_out = $request->checkout;
        $day_off = $workDay->day_off;
        $break = $workDay->break;

        if ($day_off == 1) {
            $message = 'Today is Off Day for You';
            return redirect()->back()->with('error', $message);
        }
        $parseTime = function ($time) {
            return $time && $time !== 'N/A' ? Carbon::parse($time) : null;
        };
        
        //get from work dat table
        $arrival = $workDay ? $parseTime($workDay->arrival) : null;
        $check_in = $workDay ? $parseTime($workDay->check_in) : null;
        $check_out = $workDay ? $parseTime($workDay->check_out) : null;
        $break_in = $workDay ? $parseTime($workDay->break_in) : null;
        $break_out = $workDay ? $parseTime($workDay->break_out) : null;
        $excldueBreak = $break == 1;

        //Break Duration
        $breakDuration = max(intval($break_in->diffInMinutes($break_out, false)), 0);

        //get from form
        $checked_in = $request ? $parseTime($request->checkin) : null;
        $checked_out = $request ? $parseTime($request->checkout) : null;
        $lateArrival = $checked_in && $arrival ? ($arrival->diffInMinutes($checked_in, false)> 1 ? 1 : 0) :0;
        $lateArrival = intval($lateArrival);
        // $lateCheckIn = $checked_in && $check_in ? max(intval($check_in->diffInMinutes($checked_in, false)), 0) : '0';

        if($checked_in && $check_in) {
            switch(true) {
                case $excldueBreak:
                    $lateCheckIn = max(intval($check_in->diffInMinutes($checked_in, false)), 0);
                    break;

                case $checked_in->between($break_in, $break_out):
                    $lateCheckIn = max(intval($check_in->diffInMinutes($break_in, false)), 0);
                    break;

                case $break_in->lt($checked_in):
                    $lateCheckIn = max(intval($check_in->diffInMinutes($checked_in, false)) - $breakDuration, 0);
                    break;

                case $checked_in->lt($break_in):
                $lateCheckIn = max(intval($check_in->diffInMinutes($checked_in, false)), 0);
                    break;
            }
        }

        if($checked_out && $check_out){
            $cutStart = Carbon::parse($check_out->format('Y-m-d' . ' 12:00:00 '));
            $cutEnd = Carbon::parse($check_out->format('Y-m-d' . ' 13:00:00 '));

            switch(true) {
                case $excldueBreak:
                    $checkOutEarly = max(intval($checked_out->diffInMinutes($check_out, false)), 0);
                    break;

                case $checked_out->lt($check_in):
                    $checkOutEarly = 0;
                    break;

                case $checked_out->lt($cutStart):
                    $checkOutEarly = max(intval($checked_out->diffInMinutes($check_out, false))-60, 0);
                    break;
                
                case $checked_out->between($cutStart, $cutEnd):
                    $checkOutEarly = max(intval($cutEnd->diffInMinutes($check_out, false)), 0);
                    break;

                default:
                    $checkOutEarly = max(intval($checked_out->diffInMinutes($check_out, false)), 0);
                    break;
            }
        }

        $request->validate([
            'check_in'=>['regex:/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/'],
            'check_out'=>['regex:/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/'],
            'late_arrival'=>'integer',
            'late_check_in'=>'integer',
            'check_out_early'=>'integer',
        ]);

        $presence = Presence::where('employee_id', $employee_id)
        ->where('date', $date)
        ->first();
        
        $message = '';

        switch (true) {
            case is_null($presence):
                $presence = Presence::create([
                    'employee_id' => $employee_id,
                    'eid' => $eid,
                    'employee_name' => $employee_name,
                    'work_day_id' => $workDayId,
                    'date' => $request->date,
                    'check_in' => $checked_in,
                    'check_out' => $checked_out,
                    'late_check_in' => $lateCheckIn,
                    'late_arrival' => $lateArrival,
                    'check_out_early' => $checkOutEarly,
                ]);
                $message = 'Check-in recorded successfully! But, you are late for ' . $lateCheckIn . ' minutes';
                break;
             case !is_null($presence->check_in) && !is_null($presence->check_out):
                $message = 'You have already checked out for today. No further presence allowed.';
                return redirect()->back()->with('error', $message);
                break;
        }

        return redirect()->route('presence.list.admin')->with('success', $message);
    }

//Presence Update Manual
    public function update(Request $request, $id){
        $presence = Presence::findOrFail($id);
        $employees = Employee::get();
        $date = Carbon::parse($request->date);
        $today = strtolower($date->format('l'));
        $workDay = WorkDay::where('name', $presence->work_day_id)->where('day', $today)->first();
        $day_off = $workDay->day_off;
        $break = $workDay->break;

        if ($day_off == 1) {
            $message = 'Today is Off Day for You';
            return redirect()->back()->with('error', $message);
        }

        $parseTime = function ($time) {
            return $time && $time !== 'N/A' ? Carbon::parse($time) : null;
        };
        
        //Get From Table
        $arrival = $workDay ? $parseTime($workDay->arrival) : null;
        $check_in = $workDay ? $parseTime($workDay->check_in) : null;
        $check_out = $workDay ? $parseTime($workDay->check_out) : null;
        $break_in = $workDay ? $parseTime($workDay->break_in) : null;
        $break_out = $workDay ? $parseTime($workDay->break_out) : null;
        $excldueBreak = $break == 1;

        //Break Duration
        $breakDuration = max(intval($break_in->diffInMinutes($break_out, false)), 0);

        //Get From Form
        $checked_in = $request ? $parseTime($request->checkin) : null;
        $checked_out = $request ? $parseTime($request->checkout) : null;
        $lateArrival = $checked_in && $arrival ? ($arrival->diffInMinutes($checked_in, false)> 1 ? 1 : 0) :0;
        $lateArrival = intval($lateArrival);

        if($checked_in && $check_in) {
            switch(true) {
                case $excldueBreak:
                    $lateCheckIn = max(intval($check_in->diffInMinutes($checked_in, false)), 0);
                    break;

                case $checked_in->between($break_in, $break_out):
                    $lateCheckIn = max(intval($check_in->diffInMinutes($break_in, false)), 0);
                    break;

                case $break_in->lt($checked_in):
                    $lateCheckIn = max(intval($check_in->diffInMinutes($checked_in, false)) - $breakDuration, 0);
                    break;

                case $checked_in->lt($break_in):
                $lateCheckIn = max(intval($check_in->diffInMinutes($checked_in, false)), 0);
                    break;
            }
        }

        if($checked_out && $check_out){
            switch(true) {
                case $excldueBreak:
                    $checkOutEarly = max(intval($checked_out->diffInMinutes($check_out, false)), 0);
                    break;

                case $checked_out->lt($break_in):
                    $checkOutEarly = max(intval($checked_out->diffInMinutes($check_out, false))-60, 0);
                    break;
                
                case $checked_out->between($break_in, $break_out):
                    $checkOutEarly = max(intval($break_out->diffInMinutes($check_out, false)), 0);
                    break;

                case $checked_out->lt($check_in):
                    $checkOutEarly = 0;
            
                default:
                    $checkOutEarly = max(intval($checked_out->diffInMinutes($check_out, false)), 0);
                    break;
            }
        }
        
        $request->validate([
                'check_in'=>['regex:/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/'],
                'check_out'=>['regex:/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/'],
                'late_arrival'=>'integer',
                'late_check_in'=>'integer',
                'check_out_early'=>'integer',
            ]);  
            
        $presence->check_in = $request->checkin;
        $presence->check_out = $request->checkout;
        $presence->late_arrival = $lateArrival;
        $presence->late_check_in = $lateCheckIn;
        $presence->check_out_early = $checkOutEarly;
        $presence->save();
        return redirect()->route('presence.list.admin', compact('employees'))->with('success', 'Update Manual Presence Successfull');
    }

//Presence Delete
    public function delete($id){
        $presence = Presence::findOrFail($id);
        $presence->delete();

        return response()->json([
            'success' => true,
            'message' => 'Employee presence has been deleted.',
            'redirect' => route('presence.list.admin') 
        ]);
    }

//Presences Export
    public function export(Request $request) {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        \Log::info("Attempting to export from $startDate to $endDate");

        $formattedStartDate = Carbon::parse($startDate)->format('Y-m-d');
        $formattedEndDate = Carbon::parse($endDate)->format('Y-m-d');
    
        $fileName = "presence_{$formattedStartDate}_to_{$formattedEndDate}.xlsx";
    
        try {
            return Excel::download(new PresencesExport($startDate, $endDate), $fileName);
        } catch (\InvalidArgumentException $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }


}


