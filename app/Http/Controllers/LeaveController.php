<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Leave;
use App\Models\Employee;
use App\Models\Presence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
//Index

public function ind (Request $request) {
    // $query = Presence::whereNotNull('leave');

    $query = Presence::whereNotNull('leave');
    $today = now();
    $defaultStartDate = $today->copy()->startOfMonth()->toDateString();
    $defaultEndDate = $today->copy()->endOfDay()->toDateString();
    $startDate = Carbon::parse($request->input('start_date', $defaultStartDate));
    $endDate = Carbon::parse($request->input('end_date', $defaultEndDate))->endOfDay();
    $dateType = $request->input('date_type', 'created_at'); 

    $userDivision = Auth::user()->division_id;
    $userDepartment = Auth::user()->department_id;

    // Filter by division and/or department if set
    if ($userDivision && !$userDepartment) {
        $query->whereHas('employees', function ($query) use ($userDivision) {
            $query->where('division_id', $userDivision);
        });
    } elseif (!$userDivision && $userDepartment) {
        $query->whereHas('employees', function ($query) use ($userDepartment) {
            $query->where('department_id', $userDepartment);
        });
    } elseif ($userDivision && $userDepartment) {
        $query->whereHas('employees', function ($query) use ($userDivision, $userDepartment) {
            $query->where('division_id', $userDivision)
                  ->where('department_id', $userDepartment);
        });
    }

    if ($dateType && $startDate && $endDate) {
        $query->whereBetween($dateType, [$startDate, $endDate]);
    }

    $leaves = $query->with('employees')->get();

    $employees = Employee::whereNull('resignation')->get();
    $category = [
        PRESENCE::LEAVE_ANNUAL,
        PRESENCE::LEAVE_SICK,
        PRESENCE::LEAVE_FULL_DAY_PERMIT,
        PRESENCE::LEAVE_HALF_DAY_PERMIT,
    ];
    return view('leave.index', compact('leaves', 'employees', 'category', 'startDate', 'endDate'));

}

    public function index (Request $request) {
        $query = Leave::query();
        $today = now();
        $defaultStartDate = $today->copy()->startOfMonth()->toDateString();
        $defaultEndDate = $today->copy()->endOfDay()->toDateString();
        $startDate = Carbon::parse($request->input('start_date', $defaultStartDate));
        $endDate = Carbon::parse($request->input('end_date', $defaultEndDate))->endOfDay();
        $dateType = $request->input('date_type', 'created_at'); 

        $userDivision = Auth::user()->division_id;
        $userDepartment = Auth::user()->department_id;
    
        // Filter by division and/or department if set
        if ($userDivision && !$userDepartment) {
            $query->whereHas('employees', function ($query) use ($userDivision) {
                $query->where('division_id', $userDivision);
            });
        } elseif (!$userDivision && $userDepartment) {
            $query->whereHas('employees', function ($query) use ($userDepartment) {
                $query->where('department_id', $userDepartment);
            });
        } elseif ($userDivision && $userDepartment) {
            $query->whereHas('employees', function ($query) use ($userDivision, $userDepartment) {
                $query->where('division_id', $userDivision)
                      ->where('department_id', $userDepartment);
            });
        }
    
        if ($dateType && $startDate && $endDate) {
            $query->whereBetween($dateType, [$startDate, $endDate]);
        }

        $leaves = $query->with('employees')->get();

        $employees = Employee::whereNull('resignation')->get();
        $category = [
            'Annual leave', 
            'Sick',
            'Permit'
        ];
        return view('leave.index', compact('leaves', 'employees', 'category', 'startDate', 'endDate'));
    }


//Store

public function save (Request $request) {
    $id = $request->id;
    $employeeId = $request->input('employee_id');
    $leaveDates = $request->input('leave_dates');
    $leaveDates = explode(',', $leaveDates[0]);
    $leaveDates = array_map('trim', $leaveDates);
    $category = $request->input('category');
    $note = $request->input('note');
    $action = $request->input('action');switch ($action) {
        case 'accept':
            $status = 1;
            break;
        case 'reject':
            $status = null;
            break;
        default:
            $status = null; 
            break;
        }

    $employee_name = Employee::where('id', $employeeId)->first();
    $name = $employee_name->name;
    $eid = $employee_name->eid;

    $existPresence = Presence::where('employee_id', $employeeId)
        ->whereIn('date', $leaveDates)
        ->whereNotNull('check_in')
        ->pluck('date')->toArray();

    // dd($leaveDates, $existPresence);

    if($existPresence) {
        return redirect()->back()->withErrors('Karyawan hadir pada tanggal tersebut. Silahkan hapus presensi untuk menyetujui ijin.');
    }

    $existLeave = Presence::where('employee_id', $employeeId)
        ->whereIn('date', $leaveDates)
        ->whereNotNull('leave')
        ->pluck('date')->toArray();
        // dd($existLeave);
    if(count($existLeave) > 1) {
        return redirect()->back()->withErrors(['leave_dates' => 'There have been applications for leave on several dates.']);
    }

    $request->validate([
        'employee_id' => 'required',
        'category' => 'required',
        'note' => 'required'
    ]);

    foreach ($leaveDates as $date) {
        $leaves = Presence::updateOrCreate(
            ['id' => $id 
        ], [    
            'employee_id' => $employeeId,
            'eid' => $eid,
            'date' => $date,
            'leave' => $category,
            'leave_status' => $status,
            'leave_note' => $note,
        ]);
    }

    return redirect()->back()->with('success', 'Leave for ' . $name . ' saved successfully');
}

    public function store (Request $request) {
        $id = $request->id;
        $employeeId = $request->input('employee_id');
        $leaveDates = $request->input('leave_dates');
        $leaveDates = explode(',', $leaveDates[0]);
        $leaveDates = array_map('trim', $leaveDates);
        $category = $request->input('category');
        $note = $request->input('note');
        $action = $request->input('action');
        $status = ($action === 'accept') ? 1 : 0;
    
        $employee_name = Employee::where('id', $employeeId)->first();
        $name = $employee_name->name;

        $existLeave = Leave::where('employee_id', $employeeId)
                           ->whereIn('date', $leaveDates)
                           ->pluck('date')->toArray();
                            
        if(count($existLeave) > 0 && $status === '') {
            return redirect()->back()->withErrors(['leave_dates' => 'There have been applications for leave on several dates.']);
        }

        $request->validate([
            'employee_id' => 'required',
            'category' => 'required',
            'note' => 'required'
        ]);

        $existPresence = Presence::where('employee_id', $employeeId)
            ->whereIn('date', $leaveDates)
            ->whereNotNull('check_in')
            ->pluck('date')->toArray();

        if($existPresence) {
            return redirect()->back()->withErrors('Karyawan hadir pada tanggal tersebut. Silahkan hapus presensi untuk menyetujui ijin.');
        }

        foreach ($leaveDates as $date) {
            $leaves = Leave::updateOrCreate(
                ['id' => $id 
            ], [    
                'employee_id' => $employeeId,
                'date' => $date,
                'category' => $category,
                'note' => $note,
                'status' => $status,
            ]);
        }

        return redirect()->back()->with('success', 'Leave for ' . $name . ' updated successfully');
    }

//Delete
public function destroy ($id) {
    $leave = Presence::findOrFail($id);
    $leave->update([
        'leave' => null,
        'leave_status' => null,
    ]);
    return response()->json([
        'success' => true,
        'message' => 'Leave has been deleted.',
        'redirect' => url()->previous()
    ]);
}

    public function delete ($id) {
        $leave = Leave::findOrFail($id);
        $leave->delete();
        return response()->json([
            'success' => true,
            'message' => 'Leave has been deleted.',
            'redirect' => url()->previous()
        ]);
    }
}
