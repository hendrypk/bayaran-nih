<?php

namespace App\Livewire;

use App\Models\Overtime;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class OvertimeTable extends Component
{
    use WithPagination;

    // Filter properties
    public $search = '';
    public $status = 'all';
    public $perPage = 10;
    public $startDate, $endDate;

    // Query string agar filter tetap ada saat page di-refresh
    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => 'all'],
        'startDate' => ['except' => ''],
        'endDate' => ['except' => ''],
    ];

public function mount()
{
    // Cek apakah startDate sudah terisi dari URL (Query String)
    // Jika kosong, baru berikan default awal bulan
    if (!$this->startDate) {
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
    }
    
    if (!$this->endDate) {
        $this->endDate = Carbon::now()->format('Y-m-d');
    }
}

    // Reset pagination saat filter berubah
    public function updatedSearch() { $this->resetPage(); }
    public function updatedStatus() { $this->resetPage(); }

    public function setDateRange($start, $end)
    {
        $this->startDate = $start;
        $this->endDate = $end;
        $this->resetPage();
    }

    public function render()
    {
        $query = Overtime::with('employee')
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->when($this->search, function ($q) {
                $q->whereHas('employee', function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status !== 'all', function ($q) {
                if ($this->status === 'pending') {
                    $q->whereNull('status');
                } elseif ($this->status === 'approve') {
                    $q->where('status', 1);
                } elseif ($this->status === 'reject') {
                    $q->where('status', 0);
                }
            })
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc');

        $overtimes = ($this->perPage === 'all') 
            ? $query->get() 
            : $query->paginate($this->perPage);

        return view('livewire.overtime-table', [
            'overtimes' => $overtimes
        ]);
    }
}