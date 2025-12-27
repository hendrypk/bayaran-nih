<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Presence;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request; 

class PresenceTable extends Component
{
    public $startDate;
    public $endDate;
    public $status = 'presence';

    protected $listeners = ['dateRangeChanged' => 'setDateRange'];

    public function mount()
    {
        $this->status = request()->get('status');
        $this->startDate = request()->get('start_date') ?: now()->startOfMonth()->format('Y-m-d');
        $this->endDate = request()->get('end_date') ?: now()->format('Y-m-d');
    }

    public function setDateRange($start, $end)
    {
        $this->startDate = $start;
        $this->endDate   = $end;

        $dates = [];
        $current = strtotime($start);
        $last = strtotime($end);

        while ($current <= $last) {
            $dates[] = date('Y-m-d', $current);
            $current = strtotime('+1 day', $current);
        }

        return $dates;
    }

    protected function filterByUserPosition($query)
    {
        $userDivision = Auth::user()->division_id;
        $userDepartment = Auth::user()->department_id;

        $query->when($userDivision && !$userDepartment, fn($q) =>
            $q->whereHas('position', fn($pos) => $pos->where('division_id', $userDivision))
        )->when(!$userDivision && $userDepartment, fn($q) =>
            $q->whereHas('position', fn($pos) => $pos->where('department_id', $userDepartment))
        );
    }

public function render()
{
    $start = $this->startDate;
    $end   = $this->endDate;

    $allDates = [];
    $current = strtotime($start);
    $last    = strtotime($end);
    while ($current <= $last) {
        $allDates[] = date('Y-m-d', $current);
        $current = strtotime('+1 day', $current);
    }

    $employees = Employee::with([
            'workDay.days',
            'position.division',
            'position.department',
            'presences' => fn($q) => $q->whereBetween('date', [$start, $end])
        ])
        ->whereNull('resignation')
        ->where(fn ($q) => $this->filterByUserPosition($q))
        ->get();

    $presenceData = [];
    $absenceData  = [];

    foreach ($employees as $employee) {
        $workDay = $employee->workDay->first();
        
        foreach ($allDates as $date) {
            $dayName = strtolower(date('l', strtotime($date)));
            $isOffday = $workDay ? $workDay->days->where('day', $dayName)->contains(fn($day) => $day->is_offday) : false;

            $presence = $employee->presences->first(fn($p) => \Carbon\Carbon::parse($p->date)->format('Y-m-d') === $date);

            if ($presence && !$isOffday) {
                // Tambahkan URL Spatie Media Library
                $presence->photo_in_url = $presence->getFirstMediaUrl('presence-in');
                $presence->photo_out_url = $presence->getFirstMediaUrl('presence-out');
                
                // Pastikan relasi employee & position ikut ter-encode ke JSON
                $presence->load(['employee.position']); 
                
                $presenceData[] = $presence;
            }

            if (!$presence && !$isOffday) {
                $absenceData[] = [
                    'id' => 'abs-' . $employee->id . '-' . $date, // Dummy ID untuk Alpine key
                    'date' => $date,
                    'status' => 'absence',
                    'employee' => $employee,
                    'check_in' => null,
                    'check_out' => null,
                    'location_in' => null,
                    'location_out' => null,
                    'photo_in_url' => null,
                    'photo_out_url' => null,
                ];
            }
        }
    }

    return view('livewire.presence-table', [
        // Kirim data berdasarkan status filter
        'presences' => ($this->status === 'absence') ? $absenceData : $presenceData,
        'startDate' => $start,
        'endDate'   => $end,
        'status'    => $this->status,
    ]);
}

}
