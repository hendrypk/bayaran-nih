<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;
use App\Models\PerformanceKpiResult;
use App\Models\Presence;
use App\Traits\PresenceSummaryTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class KpiForm extends Component
{

    use PresenceSummaryTrait;

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
    public $presenceTotal;
    public $effectiveDays;

private function getPeriod()
{
    $year  = $this->year ?: date('Y');
    $month = $this->month ?: date('n');

    $start = Carbon::create($year, $month, 1)->startOfDay();
    $end   = $start->copy()->endOfMonth()->endOfDay();

    return [$start, $end];
}

public function mount($kpiId = null)
{
    $this->employees = Employee::all();

    $this->month = $this->month ?: date('n');
    $this->year  = $this->year ?: date('Y');

    if ($kpiId) {
        $this->isEditing = true;
        $this->loadKpiResult($kpiId);
    }
}

private function normalizeKpis($collection)
{
    return $collection->map(function ($item) {
        return (object)[
            'id'          => $item->id ?? null,
            'aspect'      => $item->aspect,
            'description' => $item->description,
            'target'      => $item->target,
            'weight'      => $item->weight,
            'unit'        => $item->unit ?? $item->units->symbol ?? null,
            'locked'      => $item->locked ?? false,
            'active'      => $item->active ?? true,
            'achievement' => $item->achievement ?? null,
            'result'      => $item->result ?? null,
        ];
    })->filter(fn ($x) => $x->active);
}


protected function loadKpiResult($id)
{
    $kpiResult = PerformanceKpiResult::with('employees.position', 'details')
        ->findOrFail($id);

    $this->kpiResultId = $kpiResult->id;
    $this->employeeId  = $kpiResult->employee_id;
    $this->month       = $kpiResult->month;
    $this->year        = $kpiResult->year;

    $this->loadEmployeeData($this->employeeId);

    $this->kpis = $this->normalizeKpis($kpiResult->details);

    $this->achievement = $this->kpis->pluck('achievement')->toArray();
    $this->result      = $this->kpis->pluck('result')->toArray();

    $this->loadPresenceSummary();
}

protected function loadEmployeeData($id)
{
    $employee = Employee::with(['position', 'kpis.indicators.units'])->find($id);

    if (!$employee) {
        $this->reset(['eid', 'positionName', 'kpiName', 'kpis']);
        return;
    }

    $this->eid          = $employee->eid ?? '';
    $this->positionName = $employee->position->name ?? '';
    $this->kpiName      = $employee->kpis->name ?? '';
    $this->kpiId        = $employee->kpis->id ?? null;

    // Ambil indikator active
    $activeIndicators = $employee->kpis
        ? $employee->kpis->indicators->where('active', true)
        : collect();

    $this->kpis = $this->normalizeKpis($activeIndicators);

    // Default arrays
    $this->achievement = array_fill(0, count($this->kpis), null);
    $this->result      = array_fill(0, count($this->kpis), null);

    $this->loadPresenceSummary();
}

protected function loadPresenceSummary()
{
    if (!$this->employeeId) return;

    [$start, $end] = $this->getPeriod();

    $this->presenceTotal = Presence::getPresence($this->employeeId, $start, $end);

    $this->syncAttendanceAchievement();
    $this->loadEffectiveDay();
}

public function loadEffectiveDay()
{
    if (!$this->employeeId) {
        $this->effectiveDays = 0;
        return;
    }

    $employee = Employee::with('workDay')->find($this->employeeId);

    $firstGroup = $employee?->workDay->first();

    $this->effectiveDays = $firstGroup
        ? $firstGroup->getEffectiveWorkingDays($this->month, $this->year)
        : 0;
}


private function syncAttendanceAchievement()
{
    if (!$this->kpis) return;

    foreach ($this->kpis as $i => $kpi) {
        if (strtolower($kpi->aspect) === "kehadiran") {
            $this->achievement[$i] = $this->presenceTotal;
            $this->updatedAchievement($this->presenceTotal, $i);
        }
    }
}

public function updatedAchievement($value, $index)
{
    $kpi = $this->kpis[$index] ?? null;

    if (!$kpi) {
        $this->result[$index] = 0;
        return;
    }

    $achievement = floatval($value);
    $target      = floatval($kpi->target);
    $weight      = floatval($kpi->weight);

    if ($target > 0) {
        $score = ($achievement / $target) * $weight;
        $this->result[$index] = round(min($score, $weight), 2);
    } else {
        $this->result[$index] = 0;
    }
}


    // public function mount($kpiId = null)
    // {
    //     $this->employees = Employee::all();

    //     if ($kpiId) {
    //         $this->isEditing = true;
    //         $this->loadKpiResult($kpiId);
    //     }

    //     $this->month = $this->month ?: date('n');
    //     $this->year = $this->year ?: date('y');

    //     $startDate = Carbon::create($this->year, $this->month, 1)->startOfDay();
    //     $endDate   = $startDate->copy()->endOfMonth()->endOfDay();
    // }

    // protected function loadKpiResult($id)
    // {
    //     $kpiResult = PerformanceKpiResult::with('employees.position', 'details', 'kpiName')
    //         ->findOrFail($id);

    //     $this->kpiResultId = $kpiResult->id;
    //     $this->employeeId = $kpiResult->employee_id;
    //     $this->loadEmployeeData($this->employeeId, $kpiResult);

    //     $this->month = $kpiResult->month;
    //     $this->year = $kpiResult->year;
    //     $this->loadPresenceSummary();

    //     $this->kpis = $kpiResult->details->map(function ($detail) {
    //         return (object)[
    //             'aspect'      => $detail->aspect,
    //             'description' => $detail->description,
    //             'target'      => $detail->target,
    //             'weight'      => $detail->weight,
    //             'unit'        => $detail->unit,
    //             'achievement' => $detail->achievement,
    //             'result'      => $detail->result,
    //         ];
    //     });
        
    //     $this->achievement = $kpiResult->details->pluck('achievement')->toArray();
    //     $this->result = $kpiResult->details->pluck('result')->toArray();
    // }

    public function updatedEmployeeId($value)
    {
        $this->loadEmployeeData($value);
        $this->loadEffectiveDay();
        $this->loadPresenceSummary();
    }

    public function updatedMonth()
    {
        $this->loadEffectiveDay();
        $this->loadPresenceSummary();
    }

    public function updatedYear()
    {
        $this->loadEffectiveDay();
        $this->loadPresenceSummary();
    }

    // protected function loadPresenceSummary()
    // {
    //     if (!$this->employeeId || !$this->month || !$this->year) {
    //         $this->presenceTotal = 0;
    //         return;
    //     }

    //     $startDate = Carbon::create($this->year, $this->month, 1)->startOfDay();
    //     $endDate   = $startDate->copy()->endOfMonth()->endOfDay();

    //     $this->presenceTotal = Presence::getPresence($this->employeeId, $startDate, $endDate);

    //     $this->syncAttendanceAchievement();
    // }
    
    // public function loadEffectiveDay()
    // {
    //     if (!$this->employeeId || !$this->month || !$this->year) {
    //         $this->effectiveDays = 0;
    //         return;
    //     }

    //     $employee = Employee::with('workDay')->find($this->employeeId);

    //     if (!$employee || $employee->workDay->isEmpty()) {
    //         $this->effectiveDays = 0;
    //         return;
    //     }

    //     // Ambil schedule pertama saja
    //     $firstGroup = $employee->workDay->first();

    //     $this->effectiveDays = $firstGroup
    //         ? $firstGroup->getEffectiveWorkingDays($this->month, $this->year)
    //         : 0;
    // }

    // private function syncAttendanceAchievement()
    // {
    //     if (!$this->kpis) return;

    //     foreach ($this->kpis as $index => $kpi) {
    //         if (strtolower($kpi->aspect) === "kehadiran") {
    //             $this->achievement[$index] = $this->presenceTotal;
    //         }
    //     }
    // }


    // protected function loadEmployeeData($id, $kpiResult = null)
    // {
    //     $employee = Employee::with([
    //         'position', 
    //         'kpis.indicators.units'
    //     ])->find($id);


    //     if (!$employee) {
    //         $this->eid = '';
    //         $this->positionName = '';
    //         $this->kpiName = '';
    //         $this->kpis = collect();
    //         return;
    //     }

    //     $this->eid = $employee->eid ?? '';
    //     $this->positionName = $employee->position->name ?? '';
    //     $this->kpiName = $employee->kpis->name ?? '';
    //     $this->kpiId = $employee->kpis->id ?? null;

    //     if ($kpiResult) {
    //         $this->kpis = $kpiResult->details;
    //         $this->achievement = $kpiResult->details->pluck('achievement')->toArray();
    //         $this->result = $kpiResult->details->pluck('result')->toArray();
    //     } else {
    //         $activeIndicators = $employee->kpis
    //             ? $employee->kpis->indicators->filter(fn($indicator) => $indicator->active)
    //             : collect();

    //         $this->kpis = $activeIndicators->map(function ($indicator) {
    //             return (object)[
    //                 'aspect'      => $indicator->aspect,
    //                 'description' => $indicator->description,
    //                 'target'      => $indicator->target,
    //                 'weight'      => $indicator->weight,
    //                 'unit'        => $indicator->units->symbol ?? null,
    //             ];
    //         });

    //         $this->achievement = [];
    //         $this->result = [];
    //     }
    // }

    // public function updatedAchievement($value, $index)
    // {
    //     if (!isset($this->kpis[$index])) {
    //         $this->result[$index] = 0;
    //         return;
    //     }

    //     $kpi = $this->kpis[$index];

    //     $achievement = floatval($value);
    //     $target = floatval($kpi->target);
    //     $weight = floatval($kpi->weight);

    //     if ($target > 0) {
    //         $calculated = ($achievement / $target) * $weight;
    //         $this->result[$index] = round(min($calculated, $weight), 2);
    //     } else {
    //         $this->result[$index] = 0;
    //     }

    // }

    // public function getGradeProperty()
    // {
    //     if (empty($this->result)) {
    //         return 0;
    //     }

    //     return round(array_sum($this->result), 2);
    // }

public function getGradeProperty()
{
    return round(array_sum($this->result ?? []), 2);
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

private function flashValidationError($e)
{
    $errorText = collect($e->errors())->flatten()->implode("\n");
    $this->dispatch('swal:error', message: $errorText);
}

private function baseKpiResultPayload($month, $year, $userId)
{
    return [
        'employee_id'  => $this->employeeId,
        'kpi_id'       => $this->kpiId,
        'month'        => $month,
        'year'         => $year,
        'grade'        => $this->grade,
        $this->isEditing ? 'user_updated' : 'user_created' => $userId,
    ];
}

private function buildDetailPayload()
{
    $details = [];

    foreach ($this->kpis as $index => $kpi) {

        $unitSymbol = $kpi->unit;

        if (!$unitSymbol && isset($kpi->id)) {
            $unitSymbol = \App\Models\PerformanceKpi::with('units')
                ->find($kpi->id)
                ->units
                ->symbol ?? '';
        }

        // DEFAULT target dari master
        $targetValue = $kpi->target;

        // JIKA aspek Kehadiran --> override target
        if (strtolower($kpi->aspect) === 'kehadiran') {
            $targetValue = $this->effectiveDays ?? $kpi->target;
        }

        $details[] = [
            'aspect'      => $kpi->aspect ?? '',
            'description' => $kpi->description ?? '',
            'target'      => $targetValue,               // ← TARGET SUDAH DIGANTI JIKA KEHADIRAN
            'weight'      => $kpi->weight ?? 0,
            'unit'        => $unitSymbol ?? '',
            'achievement' => $this->achievement[$index] ?? 0,
            'result'      => $this->result[$index] ?? 0,
            'created_at'  => now(),
            'updated_at'  => now(),
        ];
    }


    return $details;
}

public function save()
{
    try {
        $this->validate();
    } catch (\Illuminate\Validation\ValidationException $e) {
        return $this->flashValidationError($e);
    }

    $month  = trim($this->month ?: date('n'));
    $year   = trim($this->year  ?: date('Y'));
    $userId = auth()->id();

    // duplicate check
    $exists = \App\Models\PerformanceKpiResult::where('employee_id', $this->employeeId)
        ->where('month', $month)
        ->where('year', $year)
        ->where('id', '!=', $this->kpiResultId)
        ->exists();

    if ($exists) {
        $this->dispatch('swal:error', message: 'KPI untuk periode ini sudah ada.');
        return;
    }

    // --- BUILD PAYLOAD ---
    $payloadBase = $this->baseKpiResultPayload($month, $year, $userId);

    // --- CREATE / UPDATE ---
    if ($this->isEditing && $this->kpiResultId) {
        $kpiResult = \App\Models\PerformanceKpiResult::find($this->kpiResultId);
        $kpiResult->update($payloadBase);
        $kpiResult->details()->delete();
    } else {
        $kpiResult = \App\Models\PerformanceKpiResult::create($payloadBase);
    }

    // --- DETAILS ---
    $details = $this->buildDetailPayload();
    $kpiResult->details()->createMany($details);

    return redirect()
        ->route('kpi.detail', ['id' => $kpiResult->id])
        ->with('success', 'KPI Berhasil Disimpan...');
}




    // public function save()
    // {
    //     try {
    //         $this->validate();
    //     } catch (\Illuminate\Validation\ValidationException $e) {
    //         $errorText = implode("\n", collect($e->errors())->flatten()->toArray());
    //         $this->dispatch('swal:error', message: $errorText);
    //         return;
    //     }

    //     $month = trim($this->month ?? date('F'));
    //     $year  = trim($this->year ?? date('Y'));
    //     $userId = auth()->id();

    //     $existsQuery = \App\Models\PerformanceKpiResult::where('employee_id', $this->employeeId)
    //         ->where('month', $month)
    //         ->where('year', $year)
    //         ->where('id', '!=', $this->kpiResultId);

    //     if ($existsQuery->exists()) {
    //         $this->dispatch('swal:error', message: 'KPI untuk karyawan ini pada periode tersebut sudah ada.');
    //         return;
    //     }

    //     if ($this->isEditing && $this->kpiResultId) {
    //         $kpiResult = \App\Models\PerformanceKpiResult::find($this->kpiResultId);

    //         $kpiResult->update([
    //             'user_updated' => $userId,
    //             'employee_id' => $this->employeeId,
    //             'kpi_id' => $this->kpiId,
    //             'month' => $month,
    //             'year' => $year,
    //             'grade' => $this->grade,
    //         ]);

    //         $kpiResult->details()->delete();
    //     } else {
    //         $kpiResult = \App\Models\PerformanceKpiResult::create([
    //             'user_created' => Auth::id(),
    //             'employee_id' => $this->employeeId,
    //             'kpi_id' => $this->kpiId,
    //             'month' => $month,
    //             'year' => $year,
    //             'grade' => $this->grade,
    //         ]);
    //     }
    //     $details = [];

    //     foreach ($this->kpis as $index => $kpi) {

    //         $unitSymbol = $kpi->unit;

    //         if (!$unitSymbol && isset($kpi->id)) {
    //             $unitSymbol = \App\Models\PerformanceKpi::with('units')
    //                 ->find($kpi->id)
    //                 ->units
    //                 ->symbol ?? '';
    //         }

    //         $details[] = [
    //             'aspect'      => $kpi->aspect ?? '',
    //             'description' => $kpi->description ?? '',
    //             'target'      => $kpi->target ?? 0,
    //             'weight'      => $kpi->weight ?? 0,
    //             'unit'        => $unitSymbol ?? '',
    //             'achievement' => $this->achievement[$index] ?? 0,
    //             'result'      => $this->result[$index] ?? 0,
    //             'created_at'  => now(),
    //             'updated_at'  => now(),
    //         ];
    //     }

    //     $kpiResult->details()->createMany($details);

    //     return redirect()->route('kpi.detail', ['id' => $kpiResult->id])
    //                     ->with('success', 'KPI Berhasil Disimpan...');

    // }

    public function render()
    {
        return view('livewire.kpi-form');
    }
}
