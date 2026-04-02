<?php

namespace App\Traits;

use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

trait FinalGradeTrait
{
    /**
     * Fetch employees with their calculated final grades (PA + KPI) 
     * filtered by a specific month and year.
     *
     * @param string|int $selectedMonth The month (numeric format expected by DB)
     * @param string|int $selectedYear The year (e.g., 2026)
     * @return Collection
     */
    public function getEmployeesWithFinalGrade($selectedMonth, $selectedYear): Collection
    {
        $user = Auth::user();

        // 1. Ensure month is numeric if the database stores it as an integer/numeric string
        // This prevents "Not Found" issues if 'January' is passed instead of '1'
        if (!is_numeric($selectedMonth)) {
            $selectedMonth = date('n', strtotime($selectedMonth));
        }

        return Employee::query()
            ->whereNull('resignation')
            // 2. Filter by Organization using fluent 'when' helpers
            ->when($user->division_id && !$user->department_id, function ($q) use ($user) {
                $q->where('division_id', $user->division_id);
            })
            ->when(!$user->division_id && $user->department_id, function ($q) use ($user) {
                $q->where('department_id', $user->department_id);
            })
            // 3. Eager Load results with a reusable filter
            ->with([
                'paResults' => fn($q) => $this->applyPeriodFilter($q, $selectedMonth, $selectedYear),
                'kpiResults' => fn($q) => $this->applyPeriodFilter($q, $selectedMonth, $selectedYear),
            ])
            ->get()
            ->map(function ($employee) {
                // 4. Extract grades using Null Coalescing (defaults to 0 if no record exists)
                $finalPa  = $employee->paResults->first()->grade ?? 0;
                $finalKpi = $employee->kpiResults->first()->grade ?? 0;

                // 5. Calculate Weights
                $kpiWeightRatio = $employee->bobot_kpi / 100;
                $paWeightRatio  = 1 - $kpiWeightRatio;

                // 6. Calculate Final Score
                $score = ($finalKpi * $kpiWeightRatio) + ($finalPa * $paWeightRatio);

                // 7. Append calculated attributes to the model instance
                $employee->finalGrade = number_format($score, 2, '.', '');
                $employee->final_pa   = number_format($finalPa, 2, '.', '');
                $employee->final_kpi  = number_format($finalKpi, 2, '.', '');
                $employee->kpi_weight = $employee->bobot_kpi;
                $employee->pa_weight  = 100 - $employee->bobot_kpi;

                return $employee;
            });
    }

    /**
     * Reusable filter for Appraisal and KPI relations to keep code DRY.
     * * @param \Illuminate\Database\Eloquent\Relations\HasMany $query
     * @param int $month
     * @param int $year
     */
    private function applyPeriodFilter($query, $month, $year)
    {
        return $query->select('id', 'employee_id', 'month', 'year', 'grade')
            ->where('month', $month)
            ->where('year', $year);
    }
}