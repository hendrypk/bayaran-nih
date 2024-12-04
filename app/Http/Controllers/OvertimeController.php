<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Overtime;
use Illuminate\Http\Request;
use App\Exports\OvertimeExport;
use App\Models\PresenceSummary;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class OvertimeController extends Controller
{

//Overtimes List
public function index(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $userDivision = Auth::user()->division_id;
    $userDepartment = Auth::user()->department_id;

    $query = Overtime::with('employees'); 

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
        $query->whereBetween('date', [$startDate, $endDate]);
    }

    $overtimes = $query->get();

    $employees = Employee::get();

    return view('overtime.index', compact('overtimes', 'employees'));
}


//Overtime Add
    function submit (Request $request){
        $request->validate([
            'employee_id'=>'integer',
            'date'=>'date',
        ]);  
        
        // Parse start and end times using Carbon
        $start = Carbon::createFromFormat('H:i', $request->start);
        $end = Carbon::createFromFormat('H:i', $request->end);

        //If end time is before start time
        if($end->lt($start)){
            $end->addDay();
        }

        // Calculate the difference in minutes
        $totalMinutes = $start->diffInMinutes($end);

        $employee = Employee::where('name', $request->name)->first();

        $overtime = new Overtime();
        $overtime->employee_id = $request->employee_id;
        $overtime->date = $request->date;
        $overtime->start_at = $request->start;
        $overtime->end_at = $request->end;
        $overtime->total = $totalMinutes;
        $overtime->save();
        return redirect()->route('overtime.list')->with('success', 'Overtime successfully added');
    }

//Overtime Delete
    function delete($id){
        $overtime = Overtime::find($id);
        $overtime->delete();
        return response()->json([
            'success' => true,
            'message' => 'Employee presence has been deleted.',
            'redirect' => route('overtime.list') 
        ]);
    }

//Overtime Edit
    function update(Request $request){

        $request->validate([
            'name'=>'string',
            'date'=>'date',
        ]);
        
        // Parse start and end times using Carbon
        $start = Carbon::createFromFormat('H:i:s', $request->start);
        $end = Carbon::createFromFormat('H:i:s', $request->end);
        

        //If end time is before start time
        if($end->lt($start)){
            $end->addDay();
        }

        // Calculate the difference in minutes
        $totalMinutes = $start->diffInMinutes($end);
        $employee = Employee::where('name', $request->name)->first();


        $action = $request->input('action');
        $status = ($action === 'reject') ? 0 : 1;

        $id = $request->id;
        
        $id = Overtime::updateOrCreate([
            'id' => $id
        ], [
            'employee_id' => $request->employee_id,
            'date' => $request->date,
            'start_at' => $request->start,
            'end_at' => $request->end,
            'total' => $totalMinutes,
            'status' => $status
        ]);


        return redirect()->route('overtime.list')->with('success', 'Overtime updated successfully');
    }

//Overtime Export
public function export(Request $request) {
    $startDate = $request->start_date;
    $endDate = $request->end_date;

    \Log::info("Attempting to export from $startDate to $endDate");

    $formattedStartDate = Carbon::parse($startDate)->format('Y-m-d');
    $formattedEndDate = Carbon::parse($endDate)->format('Y-m-d');

    $fileName = "overtime_{$formattedStartDate}_to_{$formattedEndDate}.xlsx";

    try {
        return Excel::download(new OvertimeExport($startDate, $endDate), $fileName);
    } catch (\InvalidArgumentException $e) {
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }

}

}
