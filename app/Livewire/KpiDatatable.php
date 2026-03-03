<?php

namespace App\Livewire;

use App\Models\PerformanceKpiResult;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class KpiDatatable extends Component
{
    public $month;
    public $year;

    protected $paginationTheme = 'bootstrap';

    public function mount($month = null, $year = null)
    {
        $this->month = $month ?? date('F');
        $this->year = $year ?? date('Y');
    }

    public function updatedMonth()
    {
        $this->resetPage();
    }

    public function updatedYear()
    {
        $this->resetPage();
    }

    public function render()
    {
        $userDivision = Auth::user()->division_id;
        $userDepartment = Auth::user()->department_id;

        $query = PerformanceKpiResult::with('details', 'employees')
            ->where('month', $this->month)
            ->where('year', $this->year);

        if ($userDivision && !$userDepartment) {
            $query->whereHas('employees', fn($q) => $q->where('division_id', $userDivision));
        } elseif (!$userDivision && $userDepartment) {
            $query->whereHas('employees', fn($q) => $q->where('department_id', $userDepartment));
        } elseif ($userDivision && $userDepartment) {
            $query->whereHas('employees', fn($q) => $q->where('division_id', $userDivision)
                                                      ->where('department_id', $userDepartment));
        }

        $gradeKpi = $query->paginate(10);
        return view('livewire.kpi-datatable', [
            'gradeKpi' => $gradeKpi
        ]);

    }
}