<?php

namespace App\Livewire;

use App\Models\Employee;
use App\Models\PerformanceAppraisalResult;
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

    public function mount($paId = null)
    {
        $this->employees = Employee::all();
        $this->month = $this->month ?? date('F');
        $this->year = $this->year ?? date('Y');

        if($paId) {
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

        $this->paResultId = $paResult->id;
        $this->employeeId = $paResult->employee_id;
        $this->loadEmployeeData($this->employeeId, $paResult);
        $this->month = $paResult->month;
        $this->year = $paResult->year;
        $this->achievement = $paResult->details->pluck('achievement')->toArray();
    }

    public function rules()
    {
        return [
            'paId' => 'required|exists:performance_appraisal_name,id',
            'employeeId' => 'required|exists:employees,id',
            'achievement' => 'required|array',
            'achievement.*' => 'required|numeric|min:0|max:100',
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
        $year = trim($this->year ?? date('Y'));
        $userId = auth()->id();

        $existsQuery = \App\Models\PerformanceAppraisalResult::where('employee_id', $this->employeeId)
            ->where('month', $month)
            ->where('year', $year)
            ->where('id', '!=', $this->paResultId);

        if ($existsQuery->exists()) {
            $this->dispatch('swal:error', message: 'PA untuk karyawan ini pada periode tersebut sudah ada.');
            return;
        }

        if($this->isEditing && $this->paResultId) {
            $paResult = \App\Models\PerformanceAppraisalResult::find($this->paResultId);

            $paResult->update([
                'user_updated' => $userId,
                'employee_id' => $this->employeeId,
                'pa_id'=> $this->paId,
                'month' => $month,
                'year' => $year,
                'grade' => $this->grade,
            ]);

            $paResult->details()->delete();
        } else {
            $paResult = \App\Models\PerformanceAppraisalResult::create([
                'user_created' => $userId,
                'employee_id' => $this->employeeId,
                'pa_id'=> $this->paId,
                'month' => $month,
                'year' => $year,
                'grade' => $this->grade,
            ]);
        }

        $details = [];
        foreach ($this->pas as $index => $pa) {
            $details [] = [
                'aspect' => $pa->aspect,
                'description' => $pa->description,
                'achievement' => $this->achievement[$index],
            ];
        }

        $paResult->details()->createMany($details);

        $this->dispatch('closeModal');
        $this->dispatch('customer-updated');
        $this->dispatch('swal:success', [
            'message' => 'Kpi Berhasil Disimpan...'
        ]);
    }

    public function render()
    {
        return view('livewire.pa-form');
    }
}
