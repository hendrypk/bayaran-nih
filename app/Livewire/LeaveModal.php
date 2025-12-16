<?php

namespace App\Livewire;

use App\Models\Employee;
use App\Models\Leave;
use App\Models\Presence;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class LeaveModal extends Component
{
    public $employees, $categories, $date;
    public $employeeId, $category, $leaveDates, $startDate, $endDate, $note, $status;
    public $isEditing = false;
    public $leaveId;

    public function mount($leaveId = null)
    {
        $user = Auth::user();
        
        $this->employees = Employee::whereNull('resignation')
            ->whereHas('position', function ($q) use ($user) {
                $q->when($user->division_id && !$user->department_id,
                    fn ($q) => $q->where('division_id', $user->division_id)
                )->when(!$user->division_id && $user->department_id,
                    fn ($q) => $q->where('department_id', $user->department_id)
                );
            })->get();
        $this->categories = [
            PRESENCE::STATUS_LEAVE,
            PRESENCE::STATUS_HALFDAY,
            PRESENCE::STATUS_PERMIT,
            PRESENCE::STATUS_SICK,
        ];
        if ($leaveId) {
            $this->isEditing = true;
            $this->loadLeaveData($leaveId);
        }

    }

    public function loadLeaveData($leaveId)
    {
        $l = Leave::findOrFail($leaveId);
        $this->employeeId = $l->employee_id;
        $this->date = $l->start_date;
        $this->note = $l->note;
        $this->status = $l->status;
        $this->category = $l->category;
    }

    public function getTotalDaysProperty()
    {
        if (!$this->startDate || !$this->endDate) {
            return 0;
        }

        $start = Carbon::parse($this->startDate);
        $end   = Carbon::parse($this->endDate);

        if ($end->lt($start)) {
            return 0;
        }

        return $start->diffInDays($end) + 1;
    }

    public function rules()
    {
        return [
            'employeeId' => 'required|exists:employees,id',
            'category'   => 'required|string',
            'date'  => 'required|date',
        ];
    }

    private function flashValidationError($e)
    {
        $errorText = collect($e->errors())->flatten()->implode("\n");
        $this->dispatch('swal:error', message: $errorText);
    }

    public function save()
    {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->flashValidationError($e);
        }

        $employee = Employee::with('workDay.days')->findOrFail($this->employeeId);

        $schedule = $employee->workDay->first();

        if (!$schedule) {
            return $this->dispatch('swal:error', message: 'Work schedule tidak ditemukan');
        }

        $data = [
            'employee_id' => $this->employeeId,
            'start_date'  => $this->date,
            'end_date'    => $this->date,
            'category'    => $this->category,
            'note'        => $this->note,
            'status'      => $this->status,
        ];

        if ($this->isEditing && $this->leaveId) {
            $leave = Leave::find($this->leaveId);
            if (!$leave) {
                $this->dispatch('swal:error', message: 'Ijin karyawan tidak ditemukan.');
                return;
            }

            $leave->update($data);
            $this->dispatch('swal:success', message: 'Ijin karyawan berhasil diperbarui.');
        } else {
            $exists = Leave::where('employee_id', $this->employeeId)
                ->where('start_date', $this->date)
                ->where('status', Leave::LEAVE_ACC)
                ->whereNull('deleted_at')
                ->first();

            if ($exists) {
                $this->dispatch('swal:error', message: 'Ijin karyawan untuk karyawan ini pada tanggal tersebut sudah ada.');
                return;
            }

            $leave = Leave::create($data);
            $this->dispatch('swal:success', message: 'Ijin karyawan berhasil dibuat.');
        }

        $leave = Leave::updateOrCreate(
            ['id' => $this->leaveId],
            array_merge($data, ['status' => $this->status])
        );

        $presenceStatus = $this->status === Leave::LEAVE_ACC
            ? $this->category
            : PRESENCE::STATUS_ABSENCE;

        \App\Models\Presence::updateOrCreate(
            [
                'employee_id' => $this->employeeId,
                'date'        => $this->date,
            ],
            [
                'status'     => $presenceStatus,
                'note'       => $this->note,
                'updater' => auth()->id(),
            ]
        );

        $this->dispatch(
            'swal:success',
            message: $this->leaveId ? 'Ijin karyawan berhasil diperbarui.' : 'Ijin karyawan berhasil dibuat.'
        );



    }

    public function delete($id = null)
    {
        $id = $id ?? $this->editingId;

        if (!$id) {
            $this->dispatch('swal:error', ['message' => 'Tidak ada data untuk dihapus']);
            return;
        }

        try {
            $kpi = Leave::findOrFail($id);
            $kpi->delete();

            $this->dispatch('swal:success', message: 'Ijin karyawan berhasil dibuat.');
        } catch (\Exception $e) {
            $this->dispatch('swal:error', ['message' => 'Gagal menghapus data: '.$e->getMessage()]);
        }
    }


    public function render()
    {
        return view('livewire.leave-modal');
    }
}
