<?php

namespace App\Traits;

use App\Models\Employee;
use Carbon\Carbon;

trait EmployeeSummaryTrait
{
    /**
     * Get the summary of employee statuses.
     *
     * @return array
     */
    public function getEmployeeStatusSummary()
    {
        return Employee::selectRaw('employee_status, COUNT(*) as total')
            ->groupBy('employee_status')
            ->pluck('total', 'employee_status')
            ->toArray();
    }

    /**
     * Get the total employees in office and production.
     *
     * @return array
     */
    // public function getEmployeeDivisionSummary()
    // {
    //     return Employee::selectRaw("division, COUNT(*) as total")
    //         ->groupBy('division')
    //         ->pluck('total', 'division')
    //         ->toArray();
    // }

    /**
     * Get the total male and female employees.
     *
     * @return array
     */
    public function getEmployeeGenderSummary()
    {
        return Employee::selectRaw("gender, COUNT(*) as total")
            ->groupBy('gender')
            ->pluck('total', 'gender')
            ->toArray();
    }

    /**
     * Get the total employees by last education level.
     *
     * @return array
     */
    public function getEmployeeEducationSummary()
    {
        return Employee::selectRaw("education, COUNT(*) as total")
            ->groupBy('education')
            ->pluck('total', 'education')
            ->toArray();
    }

    /**
     * Get the total employees by age range.
     *
     * @return array
     */
    public function getEmployeeAgeRangeSummary()
    {
        $now = Carbon::now();

        return [
            'Under 20' => Employee::whereRaw('TIMESTAMPDIFF(YEAR, date_birth, ?) < ?', [$now, 20])->count(),
            '21-25'    => Employee::whereRaw('TIMESTAMPDIFF(YEAR, date_birth, ?) BETWEEN ? AND ?', [$now, 21, 25])->count(),
            '26-35'    => Employee::whereRaw('TIMESTAMPDIFF(YEAR, date_birth, ?) BETWEEN ? AND ?', [$now, 25, 35])->count(),
            '36-45'    => Employee::whereRaw('TIMESTAMPDIFF(YEAR, date_birth, ?) BETWEEN ? AND ?', [$now, 36, 45])->count(),
            '46-55'    => Employee::whereRaw('TIMESTAMPDIFF(YEAR, date_birth, ?) BETWEEN ? AND ?', [$now, 46, 55])->count(),
            'Above 55' => Employee::whereRaw('TIMESTAMPDIFF(YEAR, date_birth, ?) > ?', [$now, 55])->count(),
        ];
    }

    /**
     * Get the total employees by religion.
     *
     * @return array
     */
    public function getEmployeeReligionSummary()
    {
        $religions = [
            'Unknown', 
            'Islam', 
            'Christian', 
            'Catholic', 
            'Hindu', 
            'Buddha', 
            'Confucianism', 
            'Others'
        ];

        return Employee::selectRaw("religion, COUNT(*) as total")
            ->groupBy('religion')
            ->pluck('total', 'religion')
            ->toArray();

        $religionSummary = array_merge(array_fill_keys($religions, 0), $religionSummary);

    }

    /**
     * Get the total employees by marital status.
     *
     * @return array
     */
    public function getEmployeeMaritalStatusSummary()
    {
        return Employee::selectRaw("marriage, COUNT(*) as total")
            ->groupBy('marriage')
            ->pluck('total', 'marriage')
            ->toArray();
    }

    /**
     * Get the total employees by years of service.
     *
     * @return array
     */
    public function getEmployeeWorkDurationSummary()
    {
        $now = Carbon::now();

        return [
            'Under 1 year' => Employee::whereRaw('TIMESTAMPDIFF(YEAR, joining_date, ?) < ?', [$now, 1])->count(),
            '1-3 years'    => Employee::whereRaw('TIMESTAMPDIFF(YEAR, joining_date, ?) BETWEEN ? AND ?', [$now, 1, 3])->count(),
            '4-6 years'   => Employee::whereRaw('TIMESTAMPDIFF(YEAR, joining_date, ?) BETWEEN ? AND ?', [$now, 4, 6])->count(),
            '7-9 years'  => Employee::whereRaw('TIMESTAMPDIFF(YEAR, joining_date, ?) BETWEEN ? AND ?', [$now, 7, 9])->count(),
            'Above 9 years' => Employee::whereRaw('TIMESTAMPDIFF(YEAR, joining_date, ?) > ?', [$now, 9])->count(),
        ];
    }
}
