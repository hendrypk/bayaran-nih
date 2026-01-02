<?php

namespace App\Livewire;

use App\Models\Overtime;
use App\Models\Employee;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;

class OvertimeTable extends Component
{
    use WithPagination;

    public $search = '';
    public $status = 'pending';
    public $perPage = 10;
    public $startDate;
    public $endDate;

    public $statusCounts = [
        'pending' => 0,
        'approve' => 0,
        'reject'  => 0,
        'all'     => 0,
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => 'pending'],
        'startDate' => ['except' => ''],
        'endDate' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    protected $listeners = ['dateRangeChanged' => 'setDateRange', 'refreshTable'];

    public function mount()
    {
        $this->startDate = $this->startDate ?: now()->format('Y-m-d');
        $this->endDate   = $this->endDate   ?: now()->format('Y-m-d');
    }

    public function updated($property)
    {
        if (in_array($property, ['search', 'status', 'perPage'])) {
            $this->resetPage();
        }
    }

    public function setDateRange($start, $end)
    {
        $dates = collect([$start, $end])->sort();
        $this->startDate = $dates->first();
        $this->endDate = $dates->last();
        $this->resetPage();
    }

    /**
     * Ambil dan proses data Overtime
     */
    protected function getProcessedData()
    {
        $period = CarbonPeriod::create($this->startDate, $this->endDate);

        $query = Overtime::with('employee')
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->when($this->search, fn($q) => $q->whereHas('employee', fn($q2) => $q2->where('name', 'like', "%{$this->search}%")));

        $allOvertimes = $query->get();

        // Hitung count per status
        $this->statusCounts['pending'] = $allOvertimes->whereNull('status')->count();
        $this->statusCounts['approve'] = $allOvertimes->where('status', 1)->count();
        $this->statusCounts['reject']  = $allOvertimes->where('status', 0)->count();
        $this->statusCounts['all']     = $allOvertimes->count();

        // Filter sesuai tab active
        if ($this->status === 'pending') {
            $allOvertimes = $allOvertimes->whereNull('status');
        } elseif ($this->status === 'approve') {
            $allOvertimes = $allOvertimes->where('status', 1);
        } elseif ($this->status === 'reject') {
            $allOvertimes = $allOvertimes->where('status', 0);
        }

        return $allOvertimes->sortByDesc('date')->values();
    }

    public function render()
    {
        $data = $this->getProcessedData();
        $currentPage = $this->getPage();
        $perPageLimit = ($this->perPage === 'all') ? max($data->count(), 1) : $this->perPage;

        $paginatedData = new LengthAwarePaginator(
            $data->forPage($currentPage, $perPageLimit)->values(),
            $data->count(),
            $perPageLimit,
            $currentPage,
            ['path' => url()->current()]
        );

        return view('livewire.overtime-table', [
            'overtimes' => $paginatedData
        ]);
    }
}
