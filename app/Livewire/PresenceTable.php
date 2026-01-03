<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;

class PresenceTable extends Component
{
    use WithPagination;

    public $startDate;
    public $endDate;
    public $status = 'presence';
    public $search = '';
    public $perPage = 10;

    protected $queryString = [
        'startDate' => ['except' => ''],
        'endDate' => ['except' => ''],
        'status' => ['except' => ''],
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    protected $listeners = ['dateRangeChanged' => 'setDateRange', 'refreshTable'];

    public function mount()
    {
        $this->startDate = request('startDate', now()->format('Y-m-d'));
        $this->endDate   = request('endDate', now()->format('Y-m-d'));
    }

    public function setDateRange($start, $end)
    {
        $dates = collect([$start, $end])->sort();
        $this->startDate = $dates->first();
        $this->endDate = $dates->last();

        $this->resetPage();
        $this->dispatch('filter-changed');
    }

    public function updated($property)
    {
        if (in_array($property, ['search', 'status', 'perPage'])) {
            $this->resetPage();
            $this->dispatch('filter-changed');
        }
    }

    /**
     * Query master data: semua karyawan + presensi sesuai range tanggal
     */
    protected function prepareMasterData()
    {
        $period = CarbonPeriod::create($this->startDate, $this->endDate);

        $employees = Employee::with([
            'workDay.days',
            'position.division',
            'position.department',
            'presences' => fn($q) => $q->with('media')
                ->whereBetween('date', [$this->startDate, $this->endDate])
        ])
        ->whereNull('resignation')
        ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
        ->where(fn($q) => $this->filterByUserPosition($q))
        ->get();

        $masterData = collect();

        foreach ($employees as $employee) {
            $workDay = $employee->workDay->first();
            $presencesByDate = $employee->presences->keyBy(fn($p) => Carbon::parse($p->date)->format('Y-m-d'));

            foreach ($period as $date) {
                $dateStr = $date->format('Y-m-d');
                $dayName = strtolower($date->format('l'));

                // Lewati hari libur
                $isOffday = $workDay ? $workDay->days->where('day', $dayName)->contains('is_offday', true) : false;
                if ($isOffday) continue;

                $presence = $presencesByDate->get($dateStr);

                // Default: jika tidak ada presensi → absence
                $masterData->push($presence ?? [
                    'id' => "abs-{$employee->id}-{$dateStr}",
                    'date' => $dateStr,
                    'status' => 'absence',
                    'employee' => $employee,
                    'check_in' => null,
                    'check_out' => null
                ]);
            }
        }

        return $masterData->sortByDesc('date')->values();
    }

    /**
     * Filter master data berdasarkan status
     */
    protected function filterDataByStatus($data)
    {
        if (!$this->status || $this->status === 'all') return $data;

        return $data->filter(fn($item) => match($this->status) {
            'presence' => $item['status'] === 'presence',
            'late'     => $item['status'] === 'late',
            'absence'  => $item['status'] === 'absence',
            'permit'   => $item['status'] === 'permit',
            'sick'     => $item['status'] === 'sick',
            'leave'    => $item['status'] === 'leave',
            default    => true,
        })->values();
    }

    /**
     * Hitung stats berdasarkan master data
     */
    protected function computeStats($data)
    {
        return [
            'total'   => $data->count(),
            'present' => $data->where('status', 'presence')->count(),
            'ontime'  => $data->where('status', 'presence')->filter(fn($item) => ($item['late_check_in'] ?? 0) == 0)->count(),
            'late'    => $data->where('status', 'presence')->filter(fn($item) => ($item['late_check_in'] ?? 0) > 0)->count(),
            'absence' => $data->whereIn('status', ['absence', 'leave', 'sick'])->count(),
            'permit'  => $data->where('status', 'permit')->count(),
            'sick'    => $data->where('status', 'sick')->count(),
            'leave'   => $data->where('status', 'leave')->count(),
        ];
    }

    /**
     * Hitung jumlah per status untuk tab / widget
     */
    public function getStatusCountsProperty()
    {
        $data = $this->prepareMasterData();

        return [
            'presence' => $data->where('status', 'presence')->count(),
            'absence'  => $data->where('status', 'absence')->count(),
            'permit'   => $data->where('status', 'permit')->count(),
            'sick'     => $data->where('status', 'sick')->count(),
            'leave'    => $data->where('status', 'leave')->count(),
        ];
    }

    public function render()
    {
        $masterData = $this->prepareMasterData();
        $filteredData = $this->filterDataByStatus($masterData);
        $stats = $this->computeStats($masterData);

        $currentPage = $this->getPage();
        $perPageLimit = ($this->perPage === 'all') ? max($filteredData->count(), 1) : $this->perPage;

        $paginatedData = new LengthAwarePaginator(
            $filteredData->forPage($currentPage, $perPageLimit)->values(),
            $filteredData->count(),
            $perPageLimit,
            $currentPage,
            ['path' => url()->current()]
        );

        return view('livewire.presence-table', [
            'presences' => $paginatedData,
            'stats' => $stats
        ]);
    }

    protected function filterByUserPosition($query)
    {
        $user = Auth::user();

        return $query
            ->when($user->division_id && !$user->department_id, fn($q) =>
                $q->whereHas('position', fn($pos) => $pos->where('division_id', $user->division_id))
            )
            ->when(!$user->division_id && $user->department_id, fn($q) =>
                $q->whereHas('position', fn($pos) => $pos->where('department_id', $user->department_id))
            );
    }
}
