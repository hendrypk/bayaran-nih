<?php

namespace App\Traits;

use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait FinalGradeTrait
{
    /**
     * Get the employees with their final grades based on the selected month and year.
     *
     * @param string $selectedMonth
     * @param string $selectedYear
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getEmployeesWithFinalGrade($selectedMonth, $selectedYear)
    {
        $userDivision = Auth::user()->division_id;
        $userDepartment = Auth::user()->department_id;

        $query = Employee::query();
        $query->whereNull('resignation');
        
        if ($userDivision && !$userDepartment) {
            $query->where('division_id', $userDivision);
        } elseif (!$userDivision && $userDepartment) {
            $query->where('department_id', $userDepartment);
        }

        $employees = $query->with([
            'GradePas' => function($query) use ($selectedMonth, $selectedYear) {
                $query->select('employee_id', 'month', 'year', DB::raw('avg(grade) as final_pa'))
                    ->where('month', $selectedMonth)
                    ->where('year', $selectedYear)
                    ->groupBy('employee_id', 'month', 'year');
            },
            'GradeKpis' => function($query) use ($selectedMonth, $selectedYear) {
                $query->select('employee_id', 'month', 'year', DB::raw('sum(grade) as final_kpi'))
                    ->where('month', $selectedMonth)
                    ->where('year', $selectedYear)
                    ->groupBy('employee_id', 'month', 'year');
            }
        ])->get();

        foreach ($employees as $employee) {
            $final_pa = 0;
            $final_kpi = 0;

            if ($employee->GradePas->isNotEmpty()) {
                $final_pa = $employee->GradePas->first()->final_pa;
            }

            if ($employee->GradeKpis->isNotEmpty()) {
                $final_kpi = $employee->GradeKpis->first()->final_kpi;
            }

            $bobot_kpi = $employee->bobot_kpi / 100;
            $bobot_pa = 1 - $bobot_kpi;
            $kpi_value = $final_kpi * $bobot_kpi;
            $pa_value = $final_pa * $bobot_pa;
            $finalGrade = $kpi_value + $pa_value;
            $employee->finalGrade = number_format($finalGrade, 2, '.', '');
            $employee->final_pa = number_format($final_pa, 2, '.', '');
            $employee->final_kpi = number_format($final_kpi, 2, '.', '');
        }

        return $employees;
    }
}
