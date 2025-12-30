<?php

namespace App\Livewire;

use App\Models\Employee;
use App\Models\Overtime;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Validation\ValidationException;

class OvertimeManualModal extends Component
{
    // Properties
    public $overtimeId;
    public $employeeId;
    public $date;
    public $start;
    public $end;
    public $note;
    public $status = null;
    public $isEditing = false;

    /**
     * Rules validasi yang lebih ketat
     */
    protected function rules()
    {
        return [
            'employeeId' => 'required|exists:employees,id',
            'date'       => 'required|date',
            'start'      => 'required',
            'end'        => 'required',
            'note'       => 'required|min:5|string',
            'status'     => 'nullable|in:0,1',
        ];
    }

    public function mount($id = null)
    {
        $this->date = now()->format('Y-m-d');

        if ($id) {
            $this->isEditing = true;
            $this->loadOvertimeData($id);
        }
    }

    public function loadOvertimeData($id)
    {
        $overtime = Overtime::findOrFail($id);

        $this->overtimeId = $overtime->id;
        $this->employeeId = $overtime->employee_id;
        
        // Gunakan ?-> untuk keamanan jika data null
        $this->date       = $overtime->date?->format('Y-m-d');
        $this->start      = $overtime->start_at?->format('H:i');
        $this->end        = $overtime->end_at?->format('H:i');
        
        $this->note       = $overtime->note_in;
        $this->status     = $overtime->status;
    }

    /**
     * Computed Property: Menghitung durasi secara otomatis saat $start atau $end berubah.
     * Di Blade panggil dengan: {{ $this->duration }}
     */
    #[Computed]
    public function duration()
    {
        if (!$this->start || !$this->end) return '0j 0m';

        try {
            $startTime = Carbon::parse($this->start);
            $endTime = Carbon::parse($this->end);

            if ($endTime->lt($startTime)) {
                $endTime->addDay();
            }

            $diff = $startTime->diff($endTime);
            
            return "{$diff->h}j {$diff->i}m";
        } catch (\Exception $e) {
            return '--';
        }
    }

    public function setStatus($newStatus)
    {
        if ($this->isEditing) {
            $this->status = $newStatus;
        }
    }

    public function save()
    {
        try {
            $validated = $this->validate();
            
            $startTime = Carbon::parse($this->start);
            $endTime   = Carbon::parse($this->end);
            
            if ($endTime->lt($startTime)) {
                $endTime->addDay();
            }

            $data = [
                'employee_id' => $this->employeeId,
                'date'        => $this->date,
                'start_at'    => $this->start,
                'end_at'      => $this->end,
                'total'       => $endTime->diffInMinutes($startTime),
                'note_in'     => $this->note,
                'note_out'    => $this->note,
                'status'      => $this->status,
            ];

            if ($this->isEditing) {
                Overtime::findOrFail($this->overtimeId)->update($data);
                $message = 'Lembur berhasil diperbarui.';
            } else {
                Overtime::create($data);
                $message = 'Lembur baru berhasil dibuat.';
            }

            $this->dispatch('refreshOvertimeTable');
            $this->closeModalWithNotify($message);

        } catch (ValidationException $e) {
            $this->flashValidationError($e);
        } catch (\Exception $e) {
            $this->dispatch('swal:error', message: 'Terjadi kesalahan sistem.');
        }
    }

    private function flashValidationError($e)
    {
        $errorText = collect($e->errors())->flatten()->first(); // Ambil error pertama saja agar bersih
        $this->dispatch('swal:error', message: $errorText);
    }

    private function closeModalWithNotify($message)
    {
        $this->dispatch('close-modal');
        $this->dispatch('swal:success', message: $message);
        $this->reset(['employeeId', 'start', 'end', 'note', 'isEditing', 'status', 'overtimeId']);
    }

    public function render()
    {
        return view('livewire.overtime-manual-modal', [
            'employees' => Employee::query()->orderBy('name')->get()
        ]);
    }
}