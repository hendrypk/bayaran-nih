<?php

namespace App\Http\Controllers;

use App\Models\GradePa;
use App\Models\Employee;
use App\Models\GradeKpi;
use App\Models\KpiOptions;
use Illuminate\Http\Request;
use App\Models\PerformanceKpi;
use Illuminate\Support\Facades\DB;
use App\Models\PerformanceAppraisal;
use Illuminate\Support\Facades\Auth;

class KpiController extends Controller
{

//KPI Index
public function indexKpi(Request $request){
    $selectedMonth = $request->input('month', date('F'));
    $selectedYear = $request->input('year', date('Y'));    

    // Ambil division_id dan department_id dari user yang sedang login
    $userDivision = Auth::user()->division_id;
    $userDepartment = Auth::user()->department_id;

    // Query untuk ambil data GradeKpi
    $query = GradeKpi::with('indicator', 'employees')
        ->select('employee_id', 'month', 'year', DB::raw('sum(grade) as final_kpi'))
        ->where('month', $selectedMonth)
        ->where('year', $selectedYear);

    // Filter berdasarkan division_id dan department_id dari user
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

    // Ambil data gradeKpi sesuai dengan filter
    $gradeKpi = $query->groupBy('employee_id', 'month', 'year')->get();
    $final_kpi = $gradeKpi->avg('grade');

    return view('performance.kpi.index', compact('gradeKpi', 'selectedMonth', 'selectedYear', 'final_kpi'));
}

//Kpi Add
    public function addKpi(Request $request){
        $userDivision = Auth::user()->division_id;
        $userDepartment = Auth::user()->department_id;
        $query = Employee::query();
        if ($userDivision && !$userDepartment) {
            $query->where('division_id', $userDivision);
        } elseif (!$userDivision && $userDepartment) {
            $query->where('department_id', $userDepartment);
        } 

        $query->whereNull('resignation');
        $employees = $query->get();

        return view('performance.kpi.add', compact('employees'));
    }

//Kpi Create
    public function create(Request $request){
        $request->validate([
            'employee' => 'required',
            'month' => 'required',
            'year' => 'required',
            'grades.*' => 'required'
        ]);

        $employee_id = $request->employee;
        $employee = Employee::where('id', $employee_id)->first();
        $employee_name = $employee->name;
        $month = $request->month;
        $year = $request->year;

        $existingKpi = GradeKpi::where('employee_id', $employee_id)
                       ->where('month', $month)
                       ->where('year', $year)
                       ->first();

        if($existingKpi) {
            return back()->with('error', 'Kpi ' . $employee_name . ' pada ' . $month . ' ' . $year . ' sudah ada.');
        }

        foreach ($request->input('grades') as $kpi_id => $inputGrade) {

            $indicators = PerformanceKpi::find($kpi_id);

            if($indicators){
                $target = $indicators->target;
                $bobot = $indicators->bobot;
                $grade = ($inputGrade / $target) * ($bobot);
                $grade = min($grade, $bobot);
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

//Get KPI per kpi_id
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

//Kpi Create
    public function update(Request $request, $employee_id, $month, $year){
        foreach ($request->input('grades') as $kpi_id => $inputGrade) {
            $indicators = PerformanceKpi::find($kpi_id);

            if ($indicators) {
                $target = $indicators->target;
                $bobot = $indicators->bobot;
                $grade = ($inputGrade / $target) * $bobot;
                $grade = min($grade, $bobot);
                $grade = number_format($grade, 2);

                $gradeKpi = GradeKpi::where('employee_id', $request->employee_id)
                    ->where('month', $request->month)
                    ->where('year', $request->year)
                    ->where('indicator_id', $indicators->id)
                    ->first();

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
