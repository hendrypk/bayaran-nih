<?php

namespace App\Livewire;

use App\Models\PerformanceAppraisalResult;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PaDatatable extends Component
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
    $user = Auth::user();

    $query = PerformanceAppraisalResult::with('details', 'employees')
        ->where('month', $this->month)
        ->where('year', $this->year)
        ->whereHas('employees', fn($q) => $q->sameOrg($user));

    $gradePa = $query->paginate(10);

    return view('livewire.pa-datatable', [
        'gradePa' => $gradePa
    ]);
}

}
