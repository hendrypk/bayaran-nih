<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Leave;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
//Index
    public function index (Request $request) {
        $query = Leave::query();
        $today = now();
        $defaultStartDate = $today->copy()->startOfMonth()->toDateString();
        $defaultEndDate = $today->toDateString();
        $startDate = Carbon::parse($request->input('start_date', $defaultStartDate));
        $endDate = Carbon::parse($request->input('end_date', $defaultEndDate))->endOfDay();
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
    
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
        
        $leaves = $query->with('employees')->get();

        $employees = Employee::whereNull('resignation')->get();
        $category = [
            'Annual leave', 
            'Sick',
            'Permit'
        ];
        return view('leave.index', compact('leaves', 'employees', 'category'));
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
        $status = ($action === 'accept') ? 1 : (($action === 'reject') ? 2 : 0);
    
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

        foreach ($leaveDates as $date) {
            $leaves = Leave::updateOrCreate(
                ['id' => $id 
            ], [    
                'status' => $status,
                'employee_id' => $employeeId,
                'date' => $date,
                'category' => $category,
                'note' => $note,
            ]);
        }

        return redirect()->back()->with('success', 'Leave for ' . $name . ' updated successfully');
    }

//Delete
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
