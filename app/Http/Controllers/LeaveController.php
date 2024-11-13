<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Leave;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
//Index
    public function index () {
        $leaves = Leave::with('employees')->get()->map(function($leave) {
            // $leave->start_date = \Carbon\Carbon::parse($leave->start_date)->format('d F Y');
            // $leave->end_date = \Carbon\Carbon::parse($leave->end_date)->format('d F Y');
            return $leave;
        });
        $employees = Employee::all();
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

        return redirect()->route('leaves.index')->with('success', 'Leave for ' . $name . ' updated successfully');
    }

//Delete
    public function delete ($id) {
        $leave = Leave::findOrFail($id);
        $leave->delete();
        return response()->json([
            'success' => true,
            'message' => 'Leave has been deleted.',
            'redirect' => route('leaves.index') 
        ]);
    }
}
