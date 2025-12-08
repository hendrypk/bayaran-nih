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
    use FinalGradeTrait;

    public function index(Request $request)
    {
        $selectedMonth = $request->input('month', date('n'));
        $selectedYear = $request->input('year', date('Y'));
        
        $userDivision = Auth::user()->division_id;
        $userDepartment = Auth::user()->department_id;
        
        $query = Employee::query()->whereNull('resignation');

        if ($userDivision && !$userDepartment) {
            $query->where('division_id', $userDivision);
        } elseif (!$userDivision && $userDepartment) {
            $query->where('department_id', $userDepartment);
        }

        $employees = $this->getEmployeesWithFinalGrade($selectedMonth, $selectedYear);

        return view('performance.final-grade', compact('employees', 'selectedMonth', 'selectedYear'));
    }

    public function export(Request $request)
    {
        $selectedMonth = $request->input('month', date('F'));
        $selectedYear = $request->input('year', date('Y'));

        return Excel::download(new FinalGradeExport($selectedMonth, $selectedYear), 'final_grades.xlsx');
    }


}
