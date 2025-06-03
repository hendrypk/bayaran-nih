<?php

namespace App\Http\Controllers;

use App\Models\EmployeeStatus;
use App\Traits\EmployeeSummaryTrait;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use EmployeeSummaryTrait;
    
    public function index()
    {

        $employeeStatus = EmployeeStatus::orderBy('name', 'asc')->pluck('name')->toArray();
        $genders = ['Male', 'Female'];
        // $marriage = ['Single', 'Married','Widowed', 'Unknown'];
        $religions = ['buddha', 'catholic', 'christian', 'hindu', 'islam', 'konghuchu'];

        // Get employee statistics
        $employeeStatusSummary = $this->getEmployeeStatusSummary();
        // $getEmployeeDivisionSummary = $this->getEmployeeDivisionSummary();
        $genderSummary = $this->getEmployeeGenderSummary();
        $educationSummary = $this->getEmployeeEducationSummary();
        $ageSummary = $this->getEmployeeAgeRangeSummary();
        $religionSummary = $this->getEmployeeReligionSummary();
        $maritalSummary = $this->getEmployeeMaritalStatusSummary();
        $workDurationSummary = $this->getEmployeeWorkDurationSummary();

        return view('home', compact(
            'employeeStatusSummary',
            // 'officeProductionSummary',
            'genderSummary',
            'educationSummary',
            'ageSummary',
            'religionSummary',
            'maritalSummary',
            'workDurationSummary',
            'religions',
            // 'marriage',
            'employeeStatus',
            'genders'
        ));
    }
}
