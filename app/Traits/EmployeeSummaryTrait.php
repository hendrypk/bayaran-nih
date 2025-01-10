<?php

namespace App\Traits;

use App\Models\Employee;
use App\Models\EmployeeStatus;
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
        $employeeStatus = EmployeeStatus::orderBy('name', 'asc')->pluck('name')->toArray();
        $employeeStatusSummary = Employee::selectRaw('employee_status.name as status_name, COUNT(*) as total')
            ->join('employee_status', 'employees.employee_status', '=', 'employee_status.id')
            ->groupBy('employee_status.name')
            ->orderBy('employee_status.name', 'asc')
            ->pluck('total', 'status_name')
            ->toArray();
        
        $employeeStatusSummary = array_merge(array_fill_keys($employeeStatus, 0), $employeeStatusSummary);
    
        return array_intersect_key(array_replace(array_fill_keys($employeeStatus, 0), $employeeStatusSummary), array_flip($employeeStatus));
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
        $educations = [
            'elementary_school',
            'junior_school',
            'high_school',
            'diploma',
            'bachelor',
            'master',
            'doctorate',
        ];
        
        $educationSummary = Employee::selectRaw("education, COUNT(*) as total")
            ->groupBy('education')
            ->pluck('total', 'education')
            ->toArray();
        
            $educationSummary = array_merge(array_fill_keys($educations, 0), $educationSummary);
    
            return array_intersect_key(array_replace(array_fill_keys($educations, 0), $educationSummary), array_flip($educations));
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
            '<20_year' => Employee::whereRaw('TIMESTAMPDIFF(YEAR, date_birth, ?) < ?', [$now, 20])->count(),
            '21_25_year'    => Employee::whereRaw('TIMESTAMPDIFF(YEAR, date_birth, ?) BETWEEN ? AND ?', [$now, 21, 25])->count(),
            '26_35_year'    => Employee::whereRaw('TIMESTAMPDIFF(YEAR, date_birth, ?) BETWEEN ? AND ?', [$now, 25, 35])->count(),
            '36_45_year'    => Employee::whereRaw('TIMESTAMPDIFF(YEAR, date_birth, ?) BETWEEN ? AND ?', [$now, 36, 45])->count(),
            '46_55_year'    => Employee::whereRaw('TIMESTAMPDIFF(YEAR, date_birth, ?) BETWEEN ? AND ?', [$now, 46, 55])->count(),
            '>55_year' => Employee::whereRaw('TIMESTAMPDIFF(YEAR, date_birth, ?) > ?', [$now, 55])->count(),
        ];
    }

    /**
     * Get the total employees by religion.
     *
     * @return array
     */
    public function getEmployeeReligionSummary()
    {
        // Daftar agama default
        $religions = ['buddha', 'catholic', 'christian', 'hindu', 'islam', 'konghuchu'];
    
        $religionSummary = Employee::selectRaw("religion, COUNT(*) as total")
            ->groupBy('religion')
            ->orderBy('religion', 'asc')
            ->pluck('total', 'religion')
            ->toArray();
    
        $religionSummary = array_merge(array_fill_keys($religions, 0), $religionSummary);
    
        return array_intersect_key(array_replace(array_fill_keys($religions, 0), $religionSummary), array_flip($religions));
    }
    

    /**
     * Get the total employees by marital status.
     *
     * @return array
     */
    public function getEmployeeMaritalStatusSummary()
    {
        $marriage = ['single', 'married', 'widowed'];
        $marriageSummary = Employee::selectRaw("marriage, COUNT(*) as total")
            ->groupBy('marriage')
            ->orderBy('marriage', 'asc')
            ->pluck('total', 'marriage')
            ->toArray();

        $marriageSummary = array_merge(array_fill_keys($marriage, 0), $marriageSummary);
        return array_intersect_key(array_replace(array_fill_keys($marriage, 0), $marriageSummary), array_flip($marriage));
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
            '<1_years' => Employee::whereRaw('TIMESTAMPDIFF(YEAR, joining_date, ?) < ?', [$now, 1])->count(),
            '1_3_years'    => Employee::whereRaw('TIMESTAMPDIFF(YEAR, joining_date, ?) BETWEEN ? AND ?', [$now, 1, 3])->count(),
            '4_6_years'   => Employee::whereRaw('TIMESTAMPDIFF(YEAR, joining_date, ?) BETWEEN ? AND ?', [$now, 4, 6])->count(),
            '7_9_years'  => Employee::whereRaw('TIMESTAMPDIFF(YEAR, joining_date, ?) BETWEEN ? AND ?', [$now, 7, 9])->count(),
            '>9_years' => Employee::whereRaw('TIMESTAMPDIFF(YEAR, joining_date, ?) > ?', [$now, 9])->count(),
        ];
    }
}
