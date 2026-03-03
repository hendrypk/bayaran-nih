<?php

namespace App\Http\Controllers;

use App\Models\GradePa;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\PerformanceAppraisal;
use Illuminate\Support\Facades\Auth;

class AppraisalController extends Controller
{
//Appraisal Index
public function index(Request $request)
{
    $selectedMonth = $request->input('month', date('n')); 
    $selectedYear  = $request->input('year', date('Y'));

    return view('performance.pa.index', compact('selectedMonth', 'selectedYear'));
}

//Get PA per pa_id
public function getPaByEmployee($paId){
    $appraisals = PerformanceAppraisal::where('appraisal_id', $paId)->get();
    return response()->json($appraisals);
}


//Appraisal Add
public function create(Request $request){
    $appraisals = PerformanceAppraisal::get();
    $request->validate([
        'employee_id' => 'required|exists:employees,id',
        'month' => 'required',
        'year' => 'required',
        'grades' => 'nullable|array',
        'grades.*' => 'integer|min:0|max:100',
    ]);
    
    $employee_id = $request->employee_id;
    $employee = Employee::where('id', $employee_id)->first();
    $employee_name = $employee->name;
    $month = $request->month;
    $year = $request->year;

    $existingPa = GradePa::where('employee_id', $employee_id)
                  ->where('month', $month)
                  ->where('year', $year)
                  ->first();

    if($existingPa) {
        return back()->with('error', 'Kpi ' . $employee_name . ' pada ' . $month . ' ' . $year . ' sudah ada.');
    }

    foreach($request->input('grades') as $appraisalId => $grade){
        $gradePa = new GradePa();
        $gradePa->employee_id = $request->employee_id;
        $gradePa->month = $request->month;
        $gradePa->year = $request->year;
        $gradePa->appraisal_id = $appraisalId;
        $gradePa->grade = $grade;
        $gradePa->save();
    }

    return redirect()->route('pa.list', compact('appraisals'))->with('success', 'Appraisal successfully added for the employee.');
}

//Appraisal Detail
public function detail($employee_id, $month = null, $year = null){ 
    $employees = Employee::findOrFail($employee_id);
    $appraisals = PerformanceAppraisal::get();
    $query = GradePa::where('employee_id', $employee_id);
    if ($month) {
        $query->where('month', $month);
    }
    if ($year) {
        $query->where('year', $year);
    }
    $gradePas = $query->get();
    $totalGrade = $gradePas->sum('grade');
    $avgGrade = $gradePas->avg('grade');
    $avgGrade = number_format($avgGrade, 2);
    if ($gradePas->isEmpty()) {
        return redirect()->back()->with('error', 'No appraisal records found for the given criteria.');
    }
    
    return view('performance.pa.detail', compact('employees', 'gradePas', 'month', 'year', 'appraisals', 'totalGrade', 'avgGrade'));
}

//Appraisal Edit
public function edit($employee_id, $month = null, $year = null){ 
    $employees = Employee::findOrFail($employee_id);
    $query = GradePa::where('employee_id', $employee_id);
    if ($month) {
        $query->where('month', $month);
    }
    if ($year) {
        $query->where('year', $year);
    }
    $gradePas = $query->get();
    $totalGrade = $gradePas->sum('grade');
    $avgGrade = $gradePas->avg('grade');
    if ($gradePas->isEmpty()) {
        return redirect()->back()->with('error', 'No appraisal records found for the given criteria.');
    }
    return view('performance.pa.edit', compact('employees', 'gradePas', 'month', 'year', 'totalGrade', 'avgGrade'));
}

//Appraisal Update
public function update(Request $request, $employee_id, $month, $year) {
    //Validasi input
    $request->validate([
        'month' => 'required',
        'year' => 'required|integer',
        'grades' => 'nullable|array',
        'grades.*' => 'min:0|max:100',
    ]);

    foreach ($request->input('grades') as $appraisalId => $grade) {
        // Find the existing record
        $gradePa = GradePa::where('employee_id', $request->employee_id)
                          ->where('month', $request->month)
                          ->where('year', $request->year)
                          ->where('id', $appraisalId)
                          ->first();
                        
        // Only update if the record exists
        if ($gradePa) {
            $gradePa->grade = $grade;
            $gradePa->save();
        }
    }

    return redirect()->route('pa.detail', [$employee_id, $month, $year])->with('success', 'Appraisal grades updated successfully.');
}

//Appraisal Delete
public function delete($employee_id, $month, $year){
    
    $gradePa = GradePa::where('employee_id', $employee_id)
                             ->where('month', $month)
                             ->where('year', $year)
                             ->get();

    if ($gradePa->isEmpty()) {
        return redirect()->route('pa.list')->with('error', 'No records found for deletion.');
    }
    foreach ($gradePa as $record) {
        $record->delete();
    }
    return response()->json([
        'success' => true,
        'message' => 'Appraisal has been deleted.',
        'redirect' => route('pa.list')
    ]);
}

}
