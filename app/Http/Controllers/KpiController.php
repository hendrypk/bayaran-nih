<?php

namespace App\Http\Controllers;

use App\Models\GradePa;
use App\Models\Employee;
use App\Models\GradeKpi;
use App\Models\KpiOptions;
use Illuminate\Http\Request;
use App\Models\PerformanceAppraisal;
use App\Models\PerformanceKpi;

class KpiController extends Controller
{

//KPI Index
    function indexKpi(Request $request){

        $selectedMonth = $request->input('month', date('F'));
        $selectedYear = $request->input('year', date('Y'));    

        $gradeKpi = GradeKpi::with('indicator', 'employees')
        ->select('employee_id', 'month','year')
        ->where('month', $selectedMonth)
        ->where('year', $selectedYear)
        ->groupBy('employee_id', 'month', 'year')
        ->get();
        return view('performance.kpi.index', compact('gradeKpi', 'selectedMonth', 'selectedYear'));
    }

//Kpi Add
    public function addKpi(Request $request){
        $employees = Employee::get();
        return view('performance.kpi.add', compact('employees'));
    }

//Kpi Create
    public function create(Request $request){
        // Loop through the submitted grades (KPI results)
        foreach ($request->input('grades') as $kpi_id => $inputGrade) {
            $indicators = PerformanceKpi::find($kpi_id);

            if($indicators){
                $target = $indicators->target;
                $bobot = $indicators->bobot;

                $grade = ($inputGrade / $target) * ($bobot);
                $grade = number_format($grade, 2);
            }

            $gradeKpi = new GradeKpi();
            $gradeKpi->employee_id = $request->employee;
            $gradeKpi->month = $request->input('month');
            $gradeKpi->year = $request->input('year');
            $gradeKpi->indicator_id = $kpi_id;
            $gradeKpi->achievement = $inputGrade;
            $gradeKpi->grade = $grade;
            $gradeKpi->save();
        }

        // Redirect back with a success message
        return redirect()->route('kpi.list')->with('success', 'KPI successfully added for the employee.');
    }

//Get KPI per position_id
    public function getKpiByEmployee($kpiId){
        $kpis = PerformanceKpi::where('kpi_id', $kpiId)->get();
        return response()->json($kpis);
    }

//KPI Detail
public function detail($employee_id, $month = null, $year = null){ 
    $employees = Employee::findOrFail($employee_id);
    $indicators = PerformanceKpi::get();
    $query = GradeKpi::where('employee_id', $employee_id);

    if ($month) {
        $query->where('month', $month);
    }
    if ($year) {
        $query->where('year', $year);
    }
    $gradeKpi = $query->get();
    $totalGrade = $gradeKpi->sum('grade');
    $avgGrade = $gradeKpi->avg('grade');
    if ($gradeKpi->isEmpty()) {
        return redirect()->back()->with('error', 'No appraisal records found for the given criteria.');
    }
    
    return view('performance.kpi.detail', compact('employees', 'gradeKpi', 'month', 'year', 'indicators', 'totalGrade', 'avgGrade'));
}

//KPI Delete
public function delete($employee_id, $month, $year){
    $gradeKpi = GradeKpi::where('employee_id', $employee_id)
                             ->where('month', $month)
                             ->where('year', $year)
                             ->get();
    $employee = Employee::where('id', $employee_id)->first();

    if ($gradeKpi->isEmpty()) {
        return redirect()->route('kpi.list')->with('error', 'No records found for deletion.');
    }
    foreach ($gradeKpi as $record) {
        $record->delete();
    }   return response()->json([
        'success' => true,
        'message' => 'KPI ' . $employee->name . ' for ' . $month . ' ' . $year . ' has been deleted.',
        'redirect' => route('kpi.list')
    ]);
}

//KPI Edit
public function edit($employee_id, $month = null, $year = null){ 
    $employees = Employee::with('position')->findOrFail($employee_id);
    $query = GradeKpi::where('employee_id', $employee_id);
    if ($month) {
        $query->where('month', $month);
    }
    if ($year) {
        $query->where('year', $year);
    }
    $gradeKpi = $query->get();
    $totalGrade = $gradeKpi->sum('grade');
    $avgGrade = $gradeKpi->avg('grade');
    if ($gradeKpi->isEmpty()) {
        return redirect()->back()->with('error', 'No appraisal records found for the given criteria.');
    }
    return view('performance.kpi.edit', compact('employees', 'gradeKpi', 'month', 'year', 'totalGrade', 'avgGrade'));
}

//KPI Update
// public function update(Request $request, $employee_id, $month, $year) {
//     // Validasi input
//     // $request->validate([
//     //     'employee_id' => 'required|exists:employees,id',
//     //     'month' => 'required',
//     //     'year' => 'required|integer',
//     //     'grades' => 'required|array',
//     //     'grades.*' => 'integer|min:0|max:100',
//     // ]);
//     foreach ($request->input('grades') as $kpi_id => $inputGrade) {

//         $indicators = KpiOptions::find($kpi_id);
//         if($indicators){
//             $target = $indicators->target;
//             $bobot = $indicators->bobot;

//             $grade = ($inputGrade / $target) * ($bobot);
//             $grade = number_format($grade, 2);
//         }
//         // $gradeKpi = new GradeKpi();
//         // $gradeKpi->employee_id = $request->employeeName;
//         // $gradeKpi->month = $request->input('month');
//         // // $gradeKpi->year = $request->input('year');
//         // $gradeKpi->indicator_id = $kpi_id;
//         $gradeKpi->achievement = $inputGrade;
//         $gradeKpi->grade = $grade;
//         $gradeKpi->save();
//     }

//     // foreach ($request->input('grades') as $appraisalId => $grade) {
//     //     // Find the existing record
//     //     $gradePa = GradePa::where('employee_id', $request->employee_id)
//     //                       ->where('month', $request->month)
//     //                       ->where('year', $request->year)
//     //                       ->where('id', $appraisalId)
//     //                       ->first();
                        
//     //     // Only update if the record exists
//     //     if ($gradePa) {
//     //         $gradePa->grade = $grade;
//     //         $gradePa->save();
//     //     }
//     // }

//     return redirect()->route('kpi.detail', [$employee_id, $month, $year])->with('success', 'KPI grades updated successfully.');
// }

//Kpi Create
public function update(Request $request, $employee_id, $month, $year){
    // $request->validate([
    //     'employeeName' => 'required|integer|exists:employees,id', // Ensures employee ID exists in the employees table
    //     'month' => 'required',
    //     'year' => 'required|intefer',
    //     'grades' => 'required|array', // Make sure grades are provided as an array
    //     'grades.*' => 'numeric|min:0' // Ensure each grade is numeric and greater than or equal to 0
    // ]);

    // $employee_id = Employee::find($request->input('employeeName'));
    // $position_id = Employee::where('position_id', $employee_id);

    // Loop through the submitted grades (KPI results)
    // Loop through the submitted grades (KPI results)
foreach ($request->input('grades') as $kpi_id => $inputGrade) {
    // Find the corresponding KPI indicator
    $indicators = PerformanceKpi::find($kpi_id);

    if ($indicators) {
        $target = $indicators->target;
        $bobot = $indicators->bobot;

        // Calculate grade based on target and weight (bobot)
        $grade = ($inputGrade / $target) * $bobot;
        $grade = number_format($grade, 2);

        // Check if the gradeKpi exists for the employee, month, year, and indicator
        $gradeKpi = GradeKpi::where('employee_id', $request->employee_id)
            ->where('month', $request->month)
            ->where('year', $request->year)
            ->where('indicator_id', $indicators->id)  // Use indicator id here
            ->first();  // Retrieve the first matching record

        // If the gradeKpi exists, update it
        if ($gradeKpi) {
            $gradeKpi->achievement = $inputGrade;
            $gradeKpi->grade = $grade;
            $gradeKpi->save();
        }
    }
}

    return redirect()->route('kpi.detail', [$employee_id, $month, $year])->with('success', 'KPI successfully updated for the employee.');
}


}
