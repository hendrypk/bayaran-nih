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
    public $startDate = '';
    public $endDate = '';
    public $filter;

    protected $listeners = ['dateRangeChanged' => 'setDateRange'];

    public function mount()
    {
        $this->filter = request()->get('status', null);
        $this->startDate = request()->get('start_date') ?: now()->startOfMonth()->format('Y-m-d');
        $this->endDate = request()->get('end_date') ?: now()->endOfMonth()->format('Y-m-d');
    }

    public function setDateRange($start, $end)
    {
        $this->startDate = $start ?? '';
        $this->endDate   = $end ?? '';
    }

    public function render(Request $request)
    {
        $query = Presence::with('employee', 'workDay')
            ->whereNull('leave_status')
            ->whereNotNull('work_day_id');



        $userDivision = Auth::user()->division_id;
        $userDepartment = Auth::user()->department_id;

        if ($userDivision && !$userDepartment) {
            $query->whereHas('employee', function ($query) use ($userDivision) {
                $query->whereHas('position', function ($query) use ($userDivision) {
                    $query->where('division_id', $userDivision);
                });
            });
        } elseif (!$userDivision && $userDepartment) {
            $query->whereHas('employee', function ($query) use ($userDepartment) {
                $query->whereHas('position', function ($query) use ($userDepartment) {
                    $query->where('department_id', $userDepartment);
                });
            });
        }

    if ($this->startDate && $this->endDate) {
        $query->whereBetween('date', [$this->startDate, $this->endDate]);
    }
        
        $presences = $query->get();

        // Ambil semua employee beserta presences pada rentang tanggal
        $employeeQuery = Employee::with([
            'presences' => function ($q) {
                $q->whereBetween('date', [$this->startDate, $this->endDate]);
            },
            'workDay'
        ]);
        if ($userDivision && !$userDepartment) {
            $employeeQuery->whereHas('position',function ($query) use ($userDivision) {
                $query->where('division_id', $userDivision);
            });
        } elseif (!$userDivision && $userDepartment) {
            $employeeQuery->whereHas('position', function ($query) use ($userDepartment) {
                $query->where('department_id', $userDepartment);
            });
        } 

        $employeeQuery->whereNull('resignation');

        // Filter absence: employee yang TIDAK ada di tabel presence pada rentang tanggal
        $today = now()->toDateString();
        $defaultStartDate = now()->copy()->startOfMonth()->toDateString();
        $defaultEndDate = now()->toDateString();

        // ambil filter
        $startDate = $request->input('start_date', $defaultStartDate);
        $endDate = $request->input('end_date', $defaultEndDate);
        if ($this->filter === 'absence' && $startDate && $endDate) {
            $employeeQuery->whereDoesntHave('presences', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('date', [$startDate, $endDate]);
            });
        }

        // Filter presence: employee yang ADA di tabel presence pada rentang tanggal
        if ($this->filter === 'presence' && $startDate && $endDate) {
            $employeeQuery->whereHas('presences', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('date', [$startDate, $endDate]);
            });
        }

        $employees = $employeeQuery->get();
        
        $workDays = [];
        foreach ($employees as $employee) {
            $workDays[$employee->id] = $employee->workDay->map(function ($workDay) {
                return [
                    'id' => $workDay->id,
                    'name' => $workDay->name,
                ];
            });
        }

        return view('livewire.presence-table', [
            'presences' => $presences,
            'workDays'  => $workDays,
            'employees' => $employees,
            'startDate' => $this->startDate,
            'endDate'   => $this->endDate,
            'filter'    => $this->filter,
        ]);

    }
}
