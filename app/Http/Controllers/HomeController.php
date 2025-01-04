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

        $employeeStatus = EmployeeStatus::pluck('name')->toArray();
        $genders = ['unkown', 'Male', 'Female'];
        $marriage = ['unkown', 'Single', 'Married', 'Divorced', 'Widowed'];
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

        // Get employee statistics
        $statusSummary = $this->getEmployeeStatusSummary();
        // $getEmployeeDivisionSummary = $this->getEmployeeDivisionSummary();
        $genderSummary = $this->getEmployeeGenderSummary();
        $educationSummary = $this->getEmployeeEducationSummary();
        $ageSummary = $this->getEmployeeAgeRangeSummary();
        $religionSummary = $this->getEmployeeReligionSummary();
        $maritalSummary = $this->getEmployeeMaritalStatusSummary();
        $workDurationSummary = $this->getEmployeeWorkDurationSummary();

        return view('home', compact(
            'statusSummary',
            // 'officeProductionSummary',
            'genderSummary',
            'educationSummary',
            'ageSummary',
            'religionSummary',
            'maritalSummary',
            'workDurationSummary',
            'religions',
            'marriage',
            'employeeStatus',
            'genders'
        ));
    }
}
