<?php

namespace App\Livewire;

use App\Models\Leave;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class LeaveTable extends Component
{
    use WithPagination;

    // Filter Properties
    public $search = '';
    public $status = 'pending'; // ''=semua, 0=reject, 1=approved
    public $category = '';
    public $perPage = 10;
    public $startDate;
    public $endDate;
    public $typeCounts;

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

    protected $listeners = ['refreshLeaveTable' => '$refresh'];

    public function mount()
    {
        $this->startDate = $this->startDate ?: now()->format('Y-m-d');
        $this->endDate   = $this->endDate   ?: now()->format('Y-m-d');
    }

    public function setDateRange($start, $end)
    {
        $dates = collect([$start, $end])->sort();
        $this->startDate = $dates->first();
        $this->endDate = $dates->last();
        $this->resetPage();
    }

    public function updated($property)
    {
        if (in_array($property, ['search', 'status', 'category', 'perPage'])) {
            $this->resetPage();
        }
    }

    /**
     * Ambil data Leave yang sudah diproses untuk tabel
     */
protected function getProcessedData()
{
    // Ambil semua data sesuai search, category, dan tanggal
    $query = Leave::with('employee')
        ->when($this->search, fn($q) => $q->whereHas('employee', fn($q) => 
            $q->where('name', 'like', "%{$this->search}%")
              ->orWhere('eid', 'like', "%{$this->search}%")
        ))
        ->when($this->category, fn($q) => $q->where('category', $this->category))
        ->where(function($q){
            $q->whereBetween('start_date', [$this->startDate, $this->endDate])
              ->orWhereBetween('end_date', [$this->startDate, $this->endDate]);
        })
        ->latest('start_date');

    $allLeaves = $query->get();

    // Hitung count per status **sebelum filter tab active**
    $statusCounts = [
        'all'     => $allLeaves->count(),
        'pending' => $allLeaves->whereNull('status')->count(),
        'approve' => $allLeaves->where('status', 1)->count(),
        'reject'  => $allLeaves->where('status', 0)->count(),
    ];

    // Hitung count per type/category
    $typeCounts = $allLeaves->groupBy('category')->map(fn($group) => $group->count())->toArray();

    $this->statusCounts = $statusCounts;
    $this->typeCounts   = $typeCounts;

    // Filter data sesuai tab active
    $filteredLeaves = match($this->status) {
        'pending' => $allLeaves->whereNull('status'),
        'approve' => $allLeaves->where('status', 1),
        'reject'  => $allLeaves->where('status', 0),
        default   => $allLeaves,
    };

    // Sort by start_date desc
    return $filteredLeaves->sortByDesc('start_date')->values();
}



    public function render()
    {
        $data = $this->getProcessedData();

        // Pagination manual agar bisa pakai $perPage='all'
        $perPageLimit = $this->perPage === 'all' ? max($data->count(), 1) : $this->perPage;
        $currentPage = $this->getPage();

        $paginatedData = new LengthAwarePaginator(
            $data->forPage($currentPage, $perPageLimit)->values(),
            $data->count(),
            $perPageLimit,
            $currentPage,
            ['path' => url()->current()]
        );

        return view('livewire.leave-table', [
            'leaves'       => $paginatedData,
            'statusCounts' => $this->statusCounts, // <-- kirim ke Blade
        ]);
    }
}
