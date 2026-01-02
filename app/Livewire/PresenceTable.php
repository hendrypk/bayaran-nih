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
        // Samakan dengan nama di $queryString
        $this->startDate = request('startDate', now()->format('Y-m-d'));
        $this->endDate   = request('endDate', now()->format('Y-m-d'));
    }

    public function setDateRange($start, $end)
    {
        // Pastikan tanggal terkecil selalu jadi startDate
        $dates = collect([$start, $end])->sort();
        
        $this->startDate = $dates->first();
        $this->endDate = $dates->last();
        
        $this->resetPage();
        $this->dispatch('filter-changed'); // Untuk menutup sidebar detail
    }

    // Reset pagination otomatis saat filter berubah
    public function updated($property)
    {
        if (in_array($property, ['search', 'status', 'perPage'])) {
            $this->resetPage();
            $this->dispatch('filter-changed');
        }
    }

    /**
     * Mengambil dan memproses data gabungan Presence & Absence
     */
    protected function getProcessedData()
    {
        $period = CarbonPeriod::create($this->startDate, $this->endDate);
        
        $employees = Employee::with([
                'workDay.days',
                'position.division',
                'position.department',
                'presences' => fn($q) => $q->with('media')->whereBetween('date', [$this->startDate, $this->endDate])
            ])
            ->whereNull('resignation')
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->where(fn($q) => $this->filterByUserPosition($q))
            ->get();

        $allData = collect();

        foreach ($employees as $employee) {
            $workDay = $employee->workDay->first();
            $presencesByDate = $employee->presences->keyBy(fn($p) => Carbon::parse($p->date)->format('Y-m-d'));

            foreach ($period as $date) {
                $dateStr = $date->format('Y-m-d');
                $dayName = strtolower($date->format('l'));
                
                // Lewati jika hari libur karyawan
                $isOffday = $workDay ? $workDay->days->where('day', $dayName)->contains('is_offday', true) : false;
                if ($isOffday) continue;

                $presence = $presencesByDate->get($dateStr);

                // Logika Filter
                if (in_array($this->status, ['absence']) && !$presence) {
                    $allData->push([
                        'id' => "abs-{$employee->id}-{$dateStr}",
                        'date' => $dateStr,
                        'status' => 'absence',
                        'employee' => $employee,
                        'check_in' => null, 
                        'check_out' => null
                    ]);
                } elseif ($presence) {
                    if ($this->status === 'presence' || $presence->status === $this->status) {
                        $allData->push($presence);
                    }
                }
            }
        }

        return $allData->sortByDesc('date');
    }

    public function getStatusCountsProperty()
    {
        return [
            'presence' => $this->getProcessedData()->where('status', 'presence')->count(),
            'absence'  => $this->getProcessedData()->where('status', 'absence')->count(),
            'permit'   => $this->getProcessedData()->where('status', 'permit')->count(),
            'sick'     => $this->getProcessedData()->where('status', 'sick')->count(),
            'leave'    => $this->getProcessedData()->where('status', 'leave')->count(),
        ];
    }

    public function render()
    {
        $data = $this->getProcessedData();
        $currentPage = $this->getPage();
        $perPageLimit = ($this->perPage === 'all') ? max($data->count(), 1) : $this->perPage;

        // Buat Paginator Manual
        $paginatedData = new LengthAwarePaginator(
            $data->forPage($currentPage, $perPageLimit)->values(),
            $data->count(),
            $perPageLimit,
            $currentPage,
            ['path' => url()->current()]
        );

        return view('livewire.presence-table', [
            'presences' => $paginatedData
        ]);
    }

    protected function filterByUserPosition($query)
    {
        $user = Auth::user();
        return $query->when($user->division_id && !$user->department_id, fn($q) =>
            $q->whereHas('position', fn($pos) => $pos->where('division_id', $user->division_id))
        )->when(!$user->division_id && $user->department_id, fn($q) =>
            $q->whereHas('position', fn($pos) => $pos->where('department_id', $user->department_id))
        );
    }
}