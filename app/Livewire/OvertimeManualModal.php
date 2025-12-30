<?php

namespace App\Livewire;

use App\Models\Employee;
use App\Models\Overtime;
use Carbon\Carbon;
use Livewire\Component;

class OvertimeManualModal extends Component
{
    public $overtimeId, $employeeId, $date, $start, $end, $note;
    public $isEditing = false;

    protected $rules = [
        'employeeId' => 'required|exists:employees,id',
        'date'       => 'required|date',
        'start'      => 'required',
        'end'        => 'required',
        'note'       => 'required|min:5',
    ];

    public function mount()
    {
        $this->date = Carbon::now()->format('Y-m-d');
    }

    public function save()
    {
        $this->validate();

        // Hitung total jam (contoh sederhana)
        $startTime = Carbon::parse($this->start);
        $endTime = Carbon::parse($this->end);
        $total = $startTime->diffInHours($endTime) . ' Jam ' . ($startTime->diffInMinutes($endTime) % 60) . ' Menit';

        $data = [
            'employee_id' => $this->employeeId,
            'date'        => $this->date,
            'start_at'    => $this->start,
            'end_at'      => $this->end,
            'total'       => $total,
            'note_in'     => $this->note,
            'status'      => 1, // Auto approve untuk input manual oleh admin
        ];

        if ($this->isEditing) {
            Overtime::find($this->overtimeId)->update($data);
            $message = 'Lembur berhasil diperbarui.';
        } else {
            Overtime::create($data);
            $message = 'Lembur berhasil ditambahkan.';
        }

        $this->dispatch('close-modal');
        $this->dispatch('swal:success', message: $message);
        $this->reset(['employeeId', 'start', 'end', 'note', 'isEditing']);
    }

    public function render()
    {
        return view('livewire.overtime-manual-modal', [
            'employees' => Employee::orderBy('name')->get()
        ]);
    }
}