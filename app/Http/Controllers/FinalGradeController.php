<?php

namespace App\Http\Controllers;

use App\Models\GradePa;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\PerformanceAppraisal;
use Illuminate\Support\Facades\Auth;

class FinalGradeController extends Controller
{
    public function index(Request $request) {
        // Get selected month and year from the request, default to current month and year
        $selectedMonth = $request->input('month', date('F'));
        $selectedYear = $request->input('year', date('Y'));
    
        // Get division and department from the authenticated user
        $userDivision = Auth::user()->division_id;
        $userDepartment = Auth::user()->department_id;
    
        // Start the employee query
        $query = Employee::with([
            'GradePas' => function($query) use ($selectedMonth, $selectedYear) {
                $query->select('employee_id', 'month', 'year', \DB::raw('avg(grade) as final_pa'))
                    ->where('month', $selectedMonth)
                    ->where('year', $selectedYear)
                    ->groupBy('employee_id', 'month', 'year');
            },
            'GradeKpis' => function($query) use ($selectedMonth, $selectedYear) {
                $query->select('employee_id', 'month', 'year', \DB::raw('sum(grade) as final_kpi'))
                    ->where('month', $selectedMonth)
                    ->where('year', $selectedYear)
                    ->groupBy('employee_id', 'month', 'year');
            }
        ]);
    
        // Apply filtering conditions based on the user's division and department
        if ($userDivision && !$userDepartment) {
            $query->where('division_id', $userDivision);
        } elseif (!$userDivision && $userDepartment) {
            $query->where('department_id', $userDepartment);
        } elseif ($userDivision && $userDepartment) {
            $query->where('division_id', $userDivision)
                  ->where('department_id', $userDepartment);
        }
    
        // Execute the query to get the employees with their associated grades
        $employees = $query->get();
    
        // Loop through each employee and calculate the final grade
        foreach ($employees as $employee) {
            $final_pa = 0;
            $final_kpi = 0;
    
            // Get the first GradePa and GradeKpi for the employee, if available
            if ($employee->GradePas->isNotEmpty()) {
                $final_pa = $employee->GradePas->first()->final_pa;
            }
    
            if ($employee->GradeKpis->isNotEmpty()) {
                $final_kpi = $employee->GradeKpis->first()->final_kpi;
            }
            
            // Calculate the final grade based on KPI and PA weight
            $bobot_kpi = $employee->bobot_kpi / 100;
            $bobot_pa = 1 - $bobot_kpi;
            $kpi_value = $final_kpi * $bobot_kpi;
            $pa_value = $final_pa * $bobot_pa;
            $finalGrade = $kpi_value + $pa_value;
    
            // Add the final grade to the employee model
            $employee->finalGrade = number_format($finalGrade, 2, '.', '');
        }
    
        // Return the view with the employees, selected month, and selected year
        return view('performance.final-grade', compact('employees', 'selectedMonth', 'selectedYear'));
    }
    


}
