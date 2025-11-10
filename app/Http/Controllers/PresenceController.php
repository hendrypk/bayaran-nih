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
use App\Models\WorkScheduleGroup;
use App\Services\PresenceService;
use Illuminate\Cache\RedisTagSet;

class PresenceController extends Controller
{
    protected $presenceService;

    public function __construct(PresenceService $presenceService)
    {
        $this->presenceService = $presenceService;
    }


//Presences List
public function index(){
    $employees = Employee::whereNull('resignation')->get();
            $workDays = $employees->mapWithKeys(fn($e) => [
            $e->id => $e->workDay->map(fn($wd) => [
                'id' => $wd->id,
                'name' => $wd->name
            ])
        ])->toArray();
    return view('presence.index', compact('employees', 'workDays'));
}

public function indexOldd(Request $request)
{
    $query = Presence::with('employee', 'workDay')
        ->whereNull('leave_status')
        ->whereNotNull('work_day_id');

    $today = now()->toDateString();
    $defaultStartDate = now()->copy()->startOfMonth()->toDateString();
    $defaultEndDate = now()->toDateString();

    // ambil filter
    $filter = $request->input('filter', null);

    if ($filter === 'today') {
        $startDate = $today;
        $endDate = $today;
    } else {
        $startDate = $request->input('start_date', $defaultStartDate);
        $endDate = $request->input('end_date', $defaultEndDate);
    }

    $userDivision = Auth::user()->division_id;
    $userDepartment = Auth::user()->department_id;

    if ($userDivision && !$userDepartment) {
        $query->whereHas('employee', function ($query) use ($userDivision) {
            $query->whereHas('position', function ($query) use ($userDivision) {
                $query->where('division_id', $userDivision);
            });
        });
    } elseif (!$userDivision && $userDepartment) {
        $query->whereHas('employee', function ($query) use ($userDepartment) {
            $query->whereHas('position', function ($query) use ($userDepartment) {
                $query->where('department_id', $userDepartment);
            });
        });
    }

    if ($startDate && $endDate) {
        $query->whereBetween('date', [$startDate, $endDate]);
    }
    
    $presence = $query->get();

    $query = Employee::query();
    if ($userDivision && !$userDepartment) {
        $query->whereHas('position',function ($query) use ($userDivision) {
            $query->where('division_id', $userDivision);
        });
    } elseif (!$userDivision && $userDepartment) {
        $query->whereHas('position', function ($query) use ($userDepartment) {
            $query->where('department_id', $userDepartment);
        });
    } 

    $query->whereNull('resignation');
    $employees = $query->get();
    
    $workDays = [];
    foreach ($employees as $employee) {
        $workDays[$employee->id] = $employee->workDay->map(function ($workDay) {
            return [
                'id' => $workDay->id,
                'name' => $workDay->name,
            ];
        });
    }
    
    return view('presence.index', compact('presence', 'workDays', 'employees', 'startDate', 'endDate', 'filter'));
}

public function indexOld(Request $request){
    $query = Presence::with('employee', 'workDay')->whereNull('leave_status')->whereNotNull('work_day_id');
    $today = now();
    $defaultStartDate = $today->copy()->startOfMonth()->toDateString();
    $defaultEndDate = $today->toDateString();
    $startDate = $request->input('start_date', $defaultStartDate);
    $endDate = $request->input('end_date', $defaultEndDate);
    $userDivision = Auth::user()->division_id;
    $userDepartment = Auth::user()->department_id;

    if ($userDivision && !$userDepartment) {
        $query->whereHas('employee', function ($query) use ($userDivision) {
            $query->whereHas('position', function ($query) use ($userDivision) {
                $query->where('division_id', $userDivision);
            });
        });
    } elseif (!$userDivision && $userDepartment) {
        $query->whereHas('employee', function ($query) use ($userDepartment) {
            $query->whereHas('position', function ($query) use ($userDepartment) {
                $query->where('department_id', $userDepartment);
            });
        });
    }

    if ($startDate && $endDate) {
        $query->whereBetween('date', [$startDate, $endDate]);
    }
    
    $presence = $query->get();

    $query = Employee::query();
    if ($userDivision && !$userDepartment) {
        $query->whereHas('position',function ($query) use ($userDivision) {
            $query->where('division_id', $userDivision);
        });
    } elseif (!$userDivision && $userDepartment) {
        $query->whereHas('position', function ($query) use ($userDepartment) {
            $query->where('department_id', $userDepartment);
        });
    } 

    $query->whereNull('resignation');
    $employees = $query->get();
    
    $workDays = [];
    foreach ($employees as $employee) {
        // Ambil semua work days untuk masing-masing employee
        $workDays[$employee->id] = $employee->workDay->map(function ($workDay) {
            return [
                'id' => $workDay->id,
                'name' => $workDay->name,
            ];
        });
    }
    
    return view('presence.index', compact('presence', 'workDays', 'employees'));
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

        $group = WorkScheduleGroup::find($request->workDay);

        if (!$group) {
            
            $message = 'Work Schedule Group not found for the employee.';
            return redirect()->back()->with('error', $message);
        }

        $workDay = $group->days()
            ->where('day', $today)
            ->first();
            
        $checked_in = $request->checkin;
        $day_off = $workDay->is_offday;
        // dd($workDayId, $date, $today, $workDay->toArray(), $day_off);
        $break = $workDay->count_break;
        $isCountLate = $group->count_late;
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
        $check_in = $workDay ? $parseTime($workDay->start_time) : null;
        $check_out = $workDay ? $parseTime($workDay->end_time) : null;
        $break_in = $workDay ? $parseTime($workDay->break_start) : null;
        $break_out = $workDay ? $parseTime($workDay->break_end) : null;
        $excldueBreak = $break == 1;

        //Break Duration
        $breakDuration = max(intval($break_in->diffInMinutes($break_out, false)), 0);

        //get from form
        $checked_in = $request ? $parseTime($request->checkin) : null;
        $checked_out = $request ? $parseTime($request->checkout) : null;

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
        return redirect()->back()->with('success', 'Manual Presence Successfully saved');
    }


    public function save (Request $request, PresenceService $presenceService) {
        $validated = $request->validate([
            'id' => 'nullable|exists:presences,id',
            'employee_id' => 'required|exists:employees,id',
            'workDay' => 'required|exists:work_schedule_groups,id',
            'date' => 'required|date',
            'checkin' => 'required',
            'checkout' => 'nullable',
        ]);

        $employee = Employee::findOrFail($request->employee_id);
        $group = WorkScheduleGroup::findOrFail($request->workDay);
        $date = Carbon::parse($request->date);
        $today = strtolower($date->format('l'));
        $workDay = $group->days()->where('day', $today)->first();
        $checkin = Carbon::parse($request->checkin);
        $checkout = Carbon::parse($request->checkout);

        if (!$group) {
            throw new \Exception("WorkDay data not found for selected date ($today).");
        }

        $requiredFields = ['arrival', 'start_time', 'end_time', 'break_start', 'break_end'];
        foreach ($requiredFields as $field) {
            if (empty($workDay->$field)) {
                throw new \Exception("Missing required work day field: {$field}");
            }
        }

        $presenceData = $presenceService->calculateManualPresence($employee, $workDay, $group, $date, $checkin, $checkout);

        Presence::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'date' => $request->date,
                'employee_id' => $request->employee_id,
                'work_day_id' => $request->workDay,
                'check_in' => $checkin,
                'check_out' => $checkout,
                'late_check_in' => $presenceData['late_check_in'],
                'late_arrival' => $presenceData['late_arrival'],
                'check_out_early' => $presenceData['check_out_early'],
            ]
        );
        return redirect()->back()->with('success', 'Manual Presence Successfully saved');
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
        $startDate = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
        $endDate   = $request->end_date ?? now()->format('Y-m-d');
        $status    = $request->status;
        // dd($status);
        try {
            $formattedStartDate = Carbon::parse($startDate)->format('Y-m-d');
            $formattedEndDate   = Carbon::parse($endDate)->format('Y-m-d');

            $fileName = "presence_{$formattedStartDate}_to_{$formattedEndDate}.xlsx";

            return Excel::download(new PresencesExport($formattedStartDate, $formattedEndDate), $fileName);
        } catch (\InvalidArgumentException $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

}


