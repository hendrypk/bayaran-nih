<?php

namespace App\Livewire;

use App\Models\Employee;
use App\Models\PerformanceAppraisalResult;
use App\Models\User;
use Livewire\Component;

class PaForm extends Component
{

    public $employeeId;
    public $employees;
    public $eid;
    public $positionName;
    public $paId;
    public $paName;
    public $pas;
    public $achievement;
    public $month;
    public $year;
    public $paResultId;
    public $isEditing;
    public $created;
    public $updated;
    public $creator;
    public $updater;

    public function mount($paId = null)
    {
        $this->employees = Employee::all();

        $this->month = $this->month ?: date('n');
        $this->year  = $this->year ?: date('Y');

        if ($paId) {
            $this->isEditing = true;
            $this->loadPaResult($paId);
        }
    }
    
    public function updatedEmployeeId($value)
    {
        $this->loadEmployeeData($value);
    }

    public function loadEmployeeData($id, $paResult = null)
    {
        $employee = Employee::with('position', 'pas.appraisals')->find($id);

        if(!$employee) {
            $this->eid = '';
            $this->positionName = '';
            $this->paName = '';
            $this->pas = collect();
            return;
        }

        $this->eid = $employee->eid ?? '';
        $this->positionName = $employee->position->name ?? '';
        $this->paName = $employee->pas->name ?? '';
        $this->paId = $employee->pas->id ?? null;

        if($paResult) {
            $this->pas = $employee->pas ? $employee->pas->appraisals : collect();
        } else {
            $this->pas = $employee->pas ? $employee->pas->appraisals : collect();
            $this->achievement = [];
        }
    }

    public function getGradeProperty()
    {
        if (empty($this->achievement)) {
            return 0;
        }

        return round(array_sum($this->achievement) / count($this->achievement), 2);
    }

    public function loadPaResult($id)
    {
        $paResult = PerformanceAppraisalResult::with('employees.position', 'details', 'appraisalName')
            ->findOrFail($id);

        $this->paResultId  = $paResult->id;
        $this->employeeId  = $paResult->employee_id;
        $this->month       = $paResult->month;
        $this->year        = $paResult->year;
        
        $this->creator = User::find($paResult->user_created)?->name ?? '-';
        $this->updater = User::find($paResult->user_updated)?->name ?? null;
        $this->created     = $paResult->created_at;
        $this->updated     = $paResult->updated_at;
        $this->achievement = $paResult->details->pluck('achievement')->toArray();

        $this->loadEmployeeData($this->employeeId, $paResult);

    }

    public function rules()
    {
        return [
            'paId' => 'required|exists:performance_appraisal_name,id',
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

    private function basePaResultPayload($month, $year, $userId)
    {
        return [
            'employee_id'  => $this->employeeId,
            'pa_id'       => $this->paId,
            'month'        => $month,
            'year'         => $year,
            'grade'        => $this->grade,
            $this->isEditing ? 'user_updated' : 'user_created' => $userId,
        ];
    }
    
    private function buildDetailPayload()
    {
        $details = [];

        foreach ($this->pas as $index => $pa) {
            $targetValue = $pa->target;

            $details[] = [
                'aspect'      => $pa->aspect ?? '',
                'description' => $pa->description ?? '',
                'achievement' => $this->achievement[$index] ?? 0,
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
        $userId = auth()->id();;

        $exists = \App\Models\PerformanceAppraisalResult::where('employee_id', $this->employeeId)
            ->where('month', $month)
            ->where('year', $year)
            ->where('id', '!=', $this->paResultId)
            ->exists();

        if ($exists) {
            $this->dispatch('swal:error', message: 'PA untuk karyawan ini pada periode tersebut sudah ada.');
            return;
        }

        $payloadBase = $this->basePaResultPayload($month, $year, $userId);

        if ($this->isEditing && $this->paResultId) {
            $paResult = \App\Models\PerformanceAppraisalResult::find($this->paResultId);
            $paResult->update($payloadBase);
            $paResult->details()->delete();
        } else {
            $paResult = \App\Models\PerformanceAppraisalResult::create($payloadBase);
        }

        $details = $this->buildDetailPayload();
        $paResult->details()->createMany($details);

        return redirect()
            ->route('pa.list')
            ->with('success', 'KPI Berhasil Disimpan...');
    }
        
    public function delete($id = null)
    {
        $id = $id ?? $this->paResultId;

        if (!$id) {
            $this->dispatch('swal:error', ['message' => 'Tidak ada data untuk dihapus']);
            return;
        }

        try {
            $pa = PerformanceAppraisalResult::with('details')->findOrFail($id);

            $pa->details()->delete();
            $pa->delete();

            $this->dispatch('closeModal');
            $this->dispatch('swal:success', ['message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            $this->dispatch('swal:error', ['message' => 'Gagal menghapus data: ' . $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.pa-form');
    }
}
