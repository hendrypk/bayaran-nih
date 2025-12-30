<?php

namespace App\Livewire;

use App\Models\Leave;
use App\Models\Employee;
use Livewire\Component;
use Livewire\Attributes\On;

class LeaveManualModal extends Component
{
    // Properties
    public $leaveId;
    public $employee_id, $category, $note, $leave_dates, $status;
    public $isEditing = false;
    
    // Data list
    public $employees, $categories;

    public function mount($id = null)
    {
        $this->employees = Employee::orderBy('name')->get();
        $this->categories = ['leave', 'sick', 'permit', 'halfday']; 

        if ($id) {
            $this->isEditing = true;
            $this->loadLeave($id);
        }
    }

    // Listener untuk membuka modal saat edit diklik
    public function loadLeave($id)
    {
        $this->resetErrorBag();
        $this->leaveId = $id;
        $this->isEditing = true;

        $leave = Leave::findOrFail($id);
        $this->employee_id = $leave->employee_id;
        $this->category = $leave->category;
        $this->note = $leave->note;
        $this->status = $leave->status;
        
        // Untuk edit, biasanya hanya 1 tanggal. Jika multiple, sesuaikan formatnya.
        $this->leave_dates = $leave->start_date;

        // Trigger flatpickr di browser untuk update tampilan tanggal
        $this->dispatch('set-datepicker', date: $this->leave_dates);
        $this->dispatch('open-modal', 'leave-manual-modal');
    }

    // Reset form saat tombol "Add New" diklik (jika modal dipakai berulang)
    #[On('reset-leave-form')]
    public function resetForm()
    {
        $this->reset(['leaveId', 'employee_id', 'category', 'note', 'leave_dates', 'isEditing']);
        $this->resetErrorBag();
        $this->dispatch('clear-datepicker');
    }

    protected function rules()
    {
        return [
            'employee_id' => 'required',
            'category'    => 'required',
            'leave_dates' => 'required', 
        ];
    }
/**
     * Set status khusus untuk mode editing (Accept/Reject)
     * Karena status di DB sekarang Boolean (1/0/null)
     */
    public function setStatus($newStatus)
    {
        if ($this->isEditing) {
            $this->status = $newStatus;
        }
    }

    public function save()
    {
        try {
            // 1. Validasi
            $this->validate([
                'employee_id' => 'required',
                'category'    => 'required',
                'leave_dates' => 'required',
            ]);

            // 2. Persiapan Data (Base Data)
            $commonData = [
                'employee_id' => $this->employee_id,
                'category'    => $this->category,
                'note'        => $this->note,
            ];

            if ($this->isEditing) {
                // 3. Logic Update
                $data = array_merge($commonData, [
                    'start_date' => $this->leave_dates,
                    'end_date'   => $this->leave_dates,
                    'status'     => $this->status, // Mengikuti status yang di-set di modal edit
                ]);

                Leave::findOrFail($this->leaveId)->update($data);
                $message = 'Data izin/cuti berhasil diperbarui.';
                
            } else {
                // 4. Logic Create (Multiple Dates)
                $dates = explode(', ', $this->leave_dates);
                
                foreach ($dates as $date) {
                    Leave::create(array_merge($commonData, [
                        'start_date' => $date,
                        'end_date'   => $date,
                        'status'     => 1, // Default otomatis 'Accepted' untuk input manual
                    ]));
                }
                $message = 'Data izin/cuti baru berhasil dibuat.';
            }

            // 5. Response & Reset
            $this->dispatch('refreshLeaveTable');
            
            // Gunakan helper closeModalWithNotify (pastikan method ini ada di Base Component atau Trait Anda)
            if (method_exists($this, 'closeModalWithNotify')) {
                $this->closeModalWithNotify($message);
            } else {
                $this->dispatch('swal:success', message: $message);
                $this->dispatch('close-modal', 'leave-manual-modal');
                $this->resetForm();
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Pastikan method flashValidationError tersedia
            if (method_exists($this, 'flashValidationError')) {
                $this->flashValidationError($e);
            } else {
                throw $e;
            }
        } catch (\Exception $e) {
            $this->dispatch('swal:error', message: 'Terjadi kesalahan: ' . $e->getMessage());
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
        return view('livewire.leave-manual-modal');
    }
}