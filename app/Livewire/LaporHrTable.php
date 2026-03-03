<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\LaporHr;
use App\Models\LaporHrAttachment;
use Livewire\WithPagination;

class LaporHrTable extends Component
{
    use WithPagination;

    protected $listeners = ['refreshTable' => '$refresh'];

    public $startDate;
    public $endDate;
    public $status = 'all';
    public $category = 'all';
    public $search = '';
    public $perPage = 10;

    protected $queryString = [
        'startDate' => ['except' => ''],
        'endDate' => ['except' => ''],
        'status' => ['except' => 'all'],
        'category' => ['except' => 'all'],
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    public function mount()
    {
        $this->startDate = request('startDate', now()->startOfMonth()->format('Y-m-d'));
        $this->endDate = request('endDate', now()->format('Y-m-d'));
    }

    public function setDateRange($start, $end)
    {
        // Ensure smallest date is always startDate
        $dates = collect([$start, $end])->sort();

        $this->startDate = $dates->first();
        $this->endDate = $dates->last();

        $this->resetPage();
    }

    // Reset pagination automatically when filters change
    public function updated($property)
    {
        if (in_array($property, ['search', 'status', 'category', 'perPage'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $query = LaporHr::with(['employee', 'category', 'attachments'])
            ->whereBetween('report_date', [$this->startDate, $this->endDate])
            ->when($this->search, fn($q) => $q->whereHas(
                'employee',
                fn($emp) =>
                $emp->where('name', 'like', "%{$this->search}%")
            ))
            ->when($this->status !== 'all', fn($q) => $q->where('status', $this->status))
            ->when($this->category !== 'all', fn($q) => $q->where('category_id', $this->category))
            ->orderBy('report_date', 'desc');

        $perPageLimit = ($this->perPage === 'all') ? $query->count() : $this->perPage;
        $laporHrs = $query->paginate($perPageLimit);

        // Process attachments for each report
        $laporHrs->getCollection()->transform(function ($report) {
            $report->report_attachments = $report->attachments
                ? $report->attachments->where('type', LaporHrAttachment::TYPE_REPORT)->values()
                : collect();
            $report->solve_attachments = $report->attachments
                ? $report->attachments->where('type', LaporHrAttachment::TYPE_SOLVE)->values()
                : collect();
            return $report;
        });

        return view('livewire.lapor-hr-table', [
            'laporHrs' => $laporHrs
        ]);
    }
}
