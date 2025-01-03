<?php

namespace App\Http\Controllers;

use App\Models\GradePa;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Exports\FinalGradeExport;
use App\Models\PerformanceAppraisal;
use App\Traits\FinalGradeTrait;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class FinalGradeController extends Controller
{
    // public function index(Request $request) {
    //     $selectedMonth = $request->input('month', date('F'));
    //     $selectedYear = $request->input('year', date('Y'));
    //     $userDivision = Auth::user()->division_id;
    //     $userDepartment = Auth::user()->department_id;
        
    //     $query = Employee::query();
    //     $query->whereNull('resignation');
    //     if ($userDivision && !$userDepartment) {
    //         $query->where('division_id', $userDivision);
    //     } elseif (!$userDivision && $userDepartment) {
    //         $query->where('department_id', $userDepartment);
    //     } 

    //     $employees = $query->with([
    //         'GradePas' => function($query) use ($selectedMonth, $selectedYear) {
    //             $query->select('employee_id', 'month', 'year', \DB::raw('avg(grade) as final_pa'))
    //                 ->where('month', $selectedMonth)
    //                 ->where('year', $selectedYear)
    //                 ->groupBy('employee_id', 'month', 'year');
    //         },
    //         'GradeKpis' => function($query) use ($selectedMonth, $selectedYear) {
    //             $query->select('employee_id', 'month', 'year', \DB::raw('sum(grade) as final_kpi'))
    //                 ->where('month', $selectedMonth)
    //                 ->where('year', $selectedYear)
    //                 ->groupBy('employee_id', 'month', 'year');
    //         }
    //     ])->get();

    //     foreach ($employees as $employee) {
    //         $final_pa = 0;
    //         $final_kpi = 0;

    //         if ($employee->GradePas->isNotEmpty()) {
    //             $final_pa = $employee->GradePas->first()->final_pa;
    //         }

    //         if ($employee->GradeKpis->isNotEmpty()) {
    //             $final_kpi = $employee->GradeKpis->first()->final_kpi;
    //         }
            
    //         $bobot_kpi = $employee->bobot_kpi/100;
    //         $bobot_pa = 1 - $bobot_kpi;
    //         $kpi_value = $final_kpi * $bobot_kpi;
    //         $pa_value = $final_pa * $bobot_pa;
    //         $finalGrade = $kpi_value + $pa_value;
    //         $employee->finalGrade = number_format($finalGrade, 2, '.', '');
    //     }

    //     return view('performance.final-grade', compact('employees', 'selectedMonth', 'selectedYear'));
    // }

    use FinalGradeTrait;

    public function index(Request $request)
    {
        // Get selected month and year
        $selectedMonth = $request->input('month', date('F'));
        $selectedYear = $request->input('year', date('Y'));
        
        // Get user's division and department
        $userDivision = Auth::user()->division_id;
        $userDepartment = Auth::user()->department_id;
        
        // Build the query for fetching employees based on division and department
        $query = Employee::query()->whereNull('resignation');

        if ($userDivision && !$userDepartment) {
            $query->where('division_id', $userDivision);
        } elseif (!$userDivision && $userDepartment) {
            $query->where('department_id', $userDepartment);
        }

        // Get employees with final grade calculations using the trait
        $employees = $this->getEmployeesWithFinalGrade($selectedMonth, $selectedYear);

        // Return the view with employees and the selected month/year
        return view('performance.final-grade', compact('employees', 'selectedMonth', 'selectedYear'));
    }

    public function export(Request $request)
    {
        $selectedMonth = $request->input('month', date('F'));
        $selectedYear = $request->input('year', date('Y'));

        return Excel::download(new FinalGradeExport($selectedMonth, $selectedYear), 'final_grades.xlsx');
    }


}
