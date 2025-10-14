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
    public $filter = 'presence';

    protected $listeners = ['dateRangeChanged' => 'setDateRange'];

    public function mount()
    {
        $this->filter = request()->get('status', 'presence');
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

    protected function isOffday($employee, $date)
    {
        $dayName = strtolower(date('l', strtotime($date))); // monday, tuesday, etc.
        $workDay = $employee->workDay->first();

        if(!$workDay) {
            return false;
        }

        return $workDay->days
            ->where('day', $dayName)
            ->contains(fn($day) => $day->is_offday);
    }
    
    protected function hasPresence($employee, $date)
    {
        return $employee->presences
            ->filter(fn($p) => \Carbon\Carbon::parse($p->date)->format('Y-m-d') === $date)
            ->isNotEmpty();
    }

    public function render()
    {
        $start = $this->startDate;
        $end   = $this->endDate;

        // Generate array tanggal dari start ke end
        $allDates = [];
        $current = strtotime($start);
        $last    = strtotime($end);

        while ($current <= $last) {
            $allDates[] = date('Y-m-d', $current);
            $current = strtotime('+1 day', $current);
        }

        $employees = Employee::with([
            'workDay.days',
            'presences' => fn($q) => $q->whereBetween('date', [$start, $end])
        ])
        ->whereNull('resignation')
        ->where(fn ($q) => $this->filterByUserPosition($q))
        ->get();

        $allDates = $this->setDateRange($start, $end);

        $presenceData = [];
        $absenceData  = [];

        foreach ($employees as $employee) {
            $workDay = $employee->workDay->first();
            foreach ($allDates as $date) {
                $dayName = strtolower(date('l', strtotime($date)));
                $isOffday = $workDay ? $workDay->days->where('day', $dayName)->contains(fn($day) => $day->is_offday) : false;

                $presence = $employee->presences->first(fn($p) => \Carbon\Carbon::parse($p->date)->format('Y-m-d') === $date);

                if ($presence && !$isOffday) {
                    $presenceData[] = $presence;
                }

                if (!$presence && !$isOffday) {
                    $absenceData[] = [
                        'employee' => $employee,
                        'date' => $date,
                    ];
                }
            }
        }

        $workDays = $employees->mapWithKeys(fn($e) => [
            $e->id => $e->workDay->map(fn($wd) => [
                'id' => $wd->id,
                'name' => $wd->name
            ])
        ])->toArray();

        return view('livewire.presence-table', [
            'presences' => $presenceData,
            'absences'  => $absenceData,
            'workDays'  => $workDays,
            'employees' => $employees,
            'startDate' => $start,
            'endDate'   => $end,
            'filter'    => $this->filter,
            'allDates'  => $allDates,
        ]);
    }

}
