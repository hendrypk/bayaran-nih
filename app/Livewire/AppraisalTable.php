<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PerformanceAppraisalResult;

class AppraisalTable extends Component // Nama class harus sama dengan nama file
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $selectedMonth;
    public $selectedYear;

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedMonth' => ['as' => 'month'],
        'selectedYear' => ['as' => 'year'],
    ];

    public function mount($month = null, $year = null)
    {
        $this->selectedMonth = $month ?? date('n');
        $this->selectedYear = $year ?? date('Y');
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function setDateRange($month, $year)
    {
        $this->selectedMonth = $month;
        $this->selectedYear = $year;
        $this->resetPage();
    }

    public function render()
    {
        $appraisals = PerformanceAppraisalResult::query()
            ->with(['employees', 'appraisalName', 'details', 'creator'])
            ->where('month', $this->selectedMonth)
            ->where('year', $this->selectedYear)
            ->when($this->search, function ($query) {
                $query->whereHas('employees', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate($this->perPage === 'all' ? 1000 : $this->perPage);

        return view('livewire.appraisal-table', [ // Pastikan file view adalah resources/views/livewire/appraisal-table.blade.php
            'appraisals' => $appraisals
        ]);
    }
}