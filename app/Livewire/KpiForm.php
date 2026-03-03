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
    public $kpiResult;
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
    public $created;
    public $updated;
    public $creator;
    public $updater;

    private function getPeriod()
    {
        $year  = $this->year ?: date('Y');
        $month = $this->month ?: date('n');

        $start = Carbon::create($year, $month, 1)->startOfDay();
        $end   = $start->copy()->endOfMonth()->endOfDay();

        return [$start, $end];
    }

    public function mount($id = null)
    {
        $this->employees = Employee::all();

        $this->month = $this->month ?: date('n');
        $this->year  = $this->year ?: date('Y');

        if ($id) {
            $this->isEditing = true;
            $this->loadKpiResult($id);
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
        $this->creator     = $kpiResult->creator->name ?? '-';
        $this->updater     = $kpiResult->updater->name ?? null;
        $this->created     = $kpiResult->created_at;
        $this->updated     = $kpiResult->updated_at;

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

            $targetValue = $kpi->target;

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
            ->route('kpi.list')
            ->with('success', 'KPI Berhasil Disimpan...');
    }

    public function delete($id = null)
    {
        $id = $id ?? $this->kpiResultId;

        if (!$id) {
            $this->dispatch('swal:error', ['message' => 'Tidak ada data untuk dihapus']);
            return;
        }

        try {
            $kpi = PerformanceKpiResult::with('details')->findOrFail($id);

            $kpi->details()->delete();
            $kpi->delete();

            $this->dispatch('closeModal');
            $this->dispatch('swal:success', ['message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            $this->dispatch('swal:error', ['message' => 'Gagal menghapus data: ' . $e->getMessage()]);
        }
    }


    public function render()
    {
        return view('livewire.kpi-form');
    }
}
