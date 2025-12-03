<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;
use App\Models\PerformanceKpi;
use App\Models\PerformanceKpiResult;
use Illuminate\Support\Facades\Auth;

class KpiForm extends Component
{
    public $kpiResultId;
    public $employees;
    public $employeeId = '';
    public $eid = '';
    public $positionName = '';
    public $kpiName;
    public $kpiId = null;
    public $kpis;
    public $weight;
    public $achievement = [];
    public $result;
    public $month;
    public $year;
    public $isEditing = false;


    public function mount($kpiId = null)
    {
        $this->employees = Employee::all();

        if ($kpiId) {
            $this->isEditing = true;
            $this->loadKpiResult($kpiId);
        }

        $this->month = $this->month ?? date('F');
        $this->year = $this->year ?? date('Y');
    }

    protected function loadKpiResult($id)
    {
        $kpiResult = PerformanceKpiResult::with('employees.position', 'details', 'kpiName')
            ->findOrFail($id);

        $this->kpiResultId = $kpiResult->id;
        $this->employeeId = $kpiResult->employee_id;
        $this->loadEmployeeData($this->employeeId, $kpiResult);

        $this->month = $kpiResult->month;
        $this->year = $kpiResult->year;

        // Load achievement & result dari details
        $this->achievement = $kpiResult->details->pluck('achievement')->toArray();
        $this->result = $kpiResult->details->pluck('result')->toArray();
    }


    public function updatedEmployeeId($value)
    {
        $this->loadEmployeeData($value);
    }

    protected function loadEmployeeData($id, $kpiResult = null)
    {
        $employee = Employee::with('position', 'kpis.indicators')->find($id);

        if (!$employee) {
            $this->eid = '';
            $this->positionName = '';
            $this->kpiName = '';
            $this->kpis = collect();
            return;
        }

        $this->eid = $employee->eid ?? '';
        $this->positionName = $employee->position->name ?? '';
        $this->kpiName = $employee->kpis->name ?? '';
        $this->kpiId = $employee->kpis->id ?? null;

        // Jangan overwrite achievement & result jika sedang edit
        if ($kpiResult) {
            $this->kpis = $employee->kpis ? $employee->kpis->indicators : collect();
        } else {
            $this->kpis = $employee->kpis ? $employee->kpis->indicators : collect();
            $this->achievement = [];
            $this->result = [];
        }
    }


    public function updatedAchievement($value, $index)
    {
        if (!isset($this->kpis[$index])) {
            $this->result[$index] = 0;
            return;
        }

        $kpi = $this->kpis[$index];

        $achievement = floatval($value);
        $target = floatval($kpi->target);
        $weight = floatval($kpi->weight);

        if ($target > 0) {
            $calculated = ($achievement / $target) * $weight;
            $this->result[$index] = round(min($calculated, $weight), 2);
        } else {
            $this->result[$index] = 0;
        }

    }

    public function getGradeProperty()
    {
        if (empty($this->result)) {
            return 0;
        }

        return round(array_sum($this->result), 2);
    }

    public function rules()
    {
        return [
            'kpiId' => 'required|exists:performance_kpi_name,id',
            'employeeId' => 'required|exists:employees,id',
            'achievement' => 'required|array',
            'achievement.*' => 'required|numeric|min:0',
        ];
    }

    public function save()
    {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errorText = implode("\n", collect($e->errors())->flatten()->toArray());
            $this->dispatch('swal:error', message: $errorText);
            return;
        }

        $month = trim($this->month ?? date('F'));
        $year  = trim($this->year ?? date('Y'));
        $userId = auth()->id();

        $existsQuery = \App\Models\PerformanceKpiResult::where('employee_id', $this->employeeId)
            ->where('month', $month)
            ->where('year', $year)
            ->where('id', '!=', $this->kpiResultId);

        if ($existsQuery->exists()) {
            $this->dispatch('swal:error', message: 'KPI untuk karyawan ini pada periode tersebut sudah ada.');
            return;
        }

        if ($this->isEditing && $this->kpiResultId) {
            $kpiResult = \App\Models\PerformanceKpiResult::find($this->kpiResultId);
            // dd(Auth::id());

            $kpiResult->update([
                'user_updated' => $userId,
                'employee_id' => $this->employeeId,
                'kpi_id' => $this->kpiId,
                'month' => $month,
                'year' => $year,
                'grade' => $this->grade,
            ]);

            $kpiResult->details()->delete();
        } else {
            $kpiResult = \App\Models\PerformanceKpiResult::create([
                'user_created' => Auth::id(),
                'employee_id' => $this->employeeId,
                'kpi_id' => $this->kpiId,
                'month' => $month,
                'year' => $year,
                'grade' => $this->grade,
            ]);
        }

        $details = [];
        foreach ($this->kpis as $index => $kpi) {
            $details[] = [
                'aspect' => $kpi->aspect ?? '',
                'target' => $kpi->target ?? 0,
                'weight' => $kpi->weight ?? 0,
                'achievement' => $this->achievement[$index] ?? 0,
                'result' => $this->result[$index] ?? 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        $kpiResult->details()->createMany($details);

        return redirect()->route('kpi.detail', ['id' => $kpiResult->id])
                        ->with('success', 'KPI Berhasil Disimpan...');

    }

    public function render()
    {
        return view('livewire.kpi-form');
    }
}
