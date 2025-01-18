<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\WorkDay;
use App\Models\Employee;
use App\Models\Overtime;
use App\Models\Presence;
use App\Models\WorkSchedule;
use Illuminate\Http\Request;
use App\Imports\PresenceImport;
use App\Exports\PresencesExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TemplateExportPresence;
use Illuminate\Cache\RedisTagSet;

class PresenceController extends Controller
{

//Presences List
public function index(Request $request){
    $query = Presence::with('employees')->whereNull('leave');
    $today = now();
    $defaultStartDate = $today->copy()->startOfMonth()->toDateString();
    $defaultEndDate = $today->toDateString();
    $startDate = $request->input('start_date', $defaultStartDate);
    $endDate = $request->input('end_date', $defaultEndDate);
    $userDivision = Auth::user()->division_id;
    $userDepartment = Auth::user()->department_id;

    if ($userDivision && !$userDepartment) {
        $query->whereHas('employee', function ($query) use ($userDivision) {
            $query->where('division_id', $userDivision);
        });
    } elseif (!$userDivision && $userDepartment) {
        $query->whereHas('employee', function ($query) use ($userDepartment) {
            $query->where('department_id', $userDepartment);
        });
    } elseif ($userDivision && $userDepartment) {
        $query->whereHas('employee', function ($query) use ($userDivision, $userDepartment) {
            $query->where('division_id', $userDivision)
                  ->where('department_id', $userDepartment);
        });
    }

    if ($startDate && $endDate) {
        $query->whereBetween('date', [$startDate, $endDate]);
    }
// $query->whereNull('leave');
    $presence = $query->get();

    // $workDay = WorkDay::select(DB::raw('MIN(id) as id'), 'name')
    //     ->groupBy('name')
    //     ->get();

    // $workDay = Employee::with('workDay')->get()->keyBy('id');

    $employees = Employee::whereNull('resignation')->get();
    $workDays = [];
    foreach ($employees as $employee) {
        // Ambil semua work days untuk masing-masing employee
        $workDay[$employee->id] = $employee->workDay->map(function ($workDay) {
            return [
                'id' => $workDay->id,
                'name' => $workDay->name,
            ];
        });
    }
    
    return view('presence.index', compact('presence', 'workDay', 'employees'));
}


//Import Prresences
    public function import(){
        return view('presence.import');
    }

    //import template
    public function template() {
        return Excel::download(new TemplateExportPresence, 'template_import.xlsx');
    }
    
    public function importStore(Request $request)
    {
        // Validasi file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        // Proses impor
        $import = new PresenceImport();
        Excel::import($import, $request->file('file'));

        // Dapatkan error dari import
        $errors = $import->getErrors();

        // Redirect dengan error jika ada
        if (!empty($errors)) {
            return redirect()->back()->withErrors(['import_errors' => $errors]);
        }

        return redirect()->back()->with('success', 'Data presensi berhasil diimpor.');
    }

    

    // public function importStore(Request $request){  
    //     $errors = []; // Array to store errors

    //     $request->validate([
    //         'file' => 'required|file|mimes:xlsx',
    //     ]);
            
    //     $file = $request->file('file');
    //     Excel::import(new PresenceImport, $file);

    //     if (!empty($errors)) {
    //         return redirect()->route('presence.import')->withErrors($errors);
    //     }
    //     return redirect()->route('presence.import')->with('success', 'Data imported successfully!');
    // }

//Presence Add Manual
    public function create(Request $request){
        $employee_id = $request->employee_id;
        $employee = Employee::where('id', $employee_id)->first();
        $eid = $employee->eid;
        $employee_name = $employee->name;
        $date = Carbon::parse($request->date);
        $today = strtolower($date->format('l'));
        $workDayId = $request->workDay;

        $workDayData = WorkDay::find($workDayId);
        $workDay = WorkDay::where('name', $workDayData->name)->where('day', $today)->first();

        // $workDay = WorkDay::find($workDayId)->where('day', $today)->first();
        $checked_in = $request->checkin;
        $cheked_out = $request->checkout;
        $day_off = $workDay->day_off;
        // dd($workDayId, $date, $today, $workDay->toArray(), $day_off);
        $break = $workDay->break;
        $isCountLate = $workDay->count_late;
        $isEmployeeLeave = Presence::where('date', $date)
            ->where('employee_id', $employee_id)
            ->whereNotNull('leave')
            ->get();
            
        if(!$isEmployeeLeave->isEmpty()) {
            $message = 'The employee has leave. You can not add presence.';
            return redirect()->back()->with('error', $message);
        }

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
        $noCountLate = $isCountLate == 0;

        //Break Duration
        $breakDuration = max(intval($break_in->diffInMinutes($break_out, false)), 0);

        //get from form
        $checked_in = $request ? $parseTime($request->checkin) : null;
        $checked_out = $request ? $parseTime($request->checkout) : null;
        // $lateArrival = $checked_in && $arrival ? ($arrival->diffInMinutes($checked_in, false)> 1 ? 1 : 0) :0;
        // $lateArrival = intval($lateArrival);
        // $lateCheckIn = $checked_in && $check_in ? max(intval($check_in->diffInMinutes($checked_in, false)), 0) : '0';

        if($checked_in && $check_in) {
            switch(true) {
                case $isCountLate == 0:
                    $lateCheckIn = 0;
                    $lateArrival = 0;
                    break;

                case $excldueBreak:
                    $lateCheckIn = max(intval($check_in->diffInMinutes($checked_in, false)), 0);
                    $lateArrival = $checked_in && $arrival ? ($arrival->diffInMinutes($checked_in, false)> 1 ? 1 : 0) :0;
                    $lateArrival = intval($lateArrival);
                    break;

                case $checked_in->between($break_in, $break_out):
                    $lateCheckIn = max(intval($check_in->diffInMinutes($break_in, false)), 0);
                    $lateArrival = $checked_in && $arrival ? ($arrival->diffInMinutes($checked_in, false)> 1 ? 1 : 0) :0;
                    $lateArrival = intval($lateArrival);
                    break;

                case $break_in->lt($checked_in):
                    $lateCheckIn = max(intval($check_in->diffInMinutes($checked_in, false)) - $breakDuration, 0);
                    $lateArrival = $checked_in && $arrival ? ($arrival->diffInMinutes($checked_in, false)> 1 ? 1 : 0) :0;
                    $lateArrival = intval($lateArrival);
                    break;

                case $checked_in->lt($break_in):
                    $lateCheckIn = max(intval($check_in->diffInMinutes($checked_in, false)), 0);
                    $lateArrival = $checked_in && $arrival ? ($arrival->diffInMinutes($checked_in, false)> 1 ? 1 : 0) :0;
                    $lateArrival = intval($lateArrival);
                    break;
            }
        }

        if($checked_out && $check_out){
            $cutStart = Carbon::parse($check_out->format('Y-m-d' . ' 12:00:00 '));
            $cutEnd = Carbon::parse($check_out->format('Y-m-d' . ' 13:00:00 '));

            switch(true) {
                case $isCountLate == 0:
                    $checkOutEarly = 0;
                    break;

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
            'check_out'=>['regex:/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/'],
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
        // $workDay = WorkDay::find($presence->work_day_id)->where('day', $today)->first();
        $workDayData = WorkDay::find($presence->work_day_id);
        $workDay = WorkDay::where('name', $workDayData->name)->where('day', $today)->first();
        $day_off = $workDay->day_off;
        $break = $workDay->break;
        $isCountLate = $workDay->count_late;

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
        $noCountLate = $isCountLate == 0;

        //Break Duration
        $breakDuration = max(intval($break_in->diffInMinutes($break_out, false)), 0);

        //Get From Form
        $checked_in = $request ? $parseTime($request->checkin) : null;
        $checked_out = $request ? $parseTime($request->checkout) : null;
        $lateArrival = $checked_in && $arrival ? ($arrival->diffInMinutes($checked_in, false)> 1 ? 1 : 0) :0;
        $lateArrival = intval($lateArrival);

        if($checked_in && $check_in) {
            switch(true) {
                case $isCountLate == 0:
                    $lateCheckIn = 0;
                    break;

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
                case $isCountLate == 0:
                    $checkOutEarly = 0;
                    break;

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
                'check_out'=>['regex:/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/'],
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
        // return redirect()->route('presence.list.admin', compact('employees'))->with('success', 'Update Manual Presence Successfull');
        return redirect()->back()->with('success', 'Update Manual Presence Successfull');
    }

//Presence Delete
    public function delete($id){
        $presence = Presence::findOrFail($id);
        $presence->delete();

        return response()->json([
            'success' => true,
            'message' => 'Employee presence has been deleted.',
            'redirect' => url()->previous() 
        ]);
    }

//Presences Export
    public function export(Request $request) {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
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


