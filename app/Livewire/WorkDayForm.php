<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\WorkScheduleGroup;
use App\Models\WorkScheduleDay;
use Illuminate\Support\Facades\DB;

class WorkDayForm extends Component
{
    public $selectedId, $isEditing = false;
    
    // Properti Model Utama
    public $name, $tolerance = 0, $count_late = 1;

    // Properti Array untuk Days
    // Format: $daysData['Monday'] = ['is_offday' => false, 'arrival' => '08:00', ...]
    public $daysData = [];

    protected $listeners = ['editWorkDay' => 'loadData', 'createWorkDay' => 'resetForm'];

    public function mount($id = null)
        {
            $this->initDefaultDays();
            
            // Cek apakah ada ID yang dikirim (untuk mode Edit)
            if ($id) {
                $this->isEditing = true;
                $this->selectedId = $id; // Simpan ID ke properti class
                $this->loadData($id);    // Kirim ID ke fungsi loadData
            }
        }

    public function initDefaultDays()
    {
        // Gunakan huruf kecil agar sama dengan database
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        foreach ($days as $day) {
            $this->daysData[$day] = [
                'is_offday'   => false,
                'arrival'     => '08:00',
                'start_time'  => '08:30',
                'end_time'    => '17:30',
                'break_start' => '12:00',
                'break_end'   => '13:00',
                'is_break'    => true,
            ];
        }
    }

    public function loadData($id)
    {
        $this->selectedId = $id;
        $group = WorkScheduleGroup::with('days')->findOrFail($id);

        $this->name = $group->name;
        $this->tolerance = $group->tolerance;
        $this->count_late = $group->count_late;

        foreach ($group->days as $dayModel) {
            // Paksa menjadi lowercase agar cocok dengan key di initDefaultDays
            $dayKey = strtolower($dayModel->day);

            if (isset($this->daysData[$dayKey])) {
                $this->daysData[$dayKey] = [
                    'is_offday'   => (bool)$dayModel->is_offday,
                    'arrival'     => formatTimeHI($dayModel->arrival),
                    'start_time'  => formatTimeHI($dayModel->start_time),
                    'end_time'    => formatTimeHI($dayModel->end_time),
                    'break_start' => formatTimeHI($dayModel->break_start),
                    'break_end'   => formatTimeHI($dayModel->break_end),
                    'is_break'    => (bool)$dayModel->count_break, // Sesuaikan nama kolom DB mu (count_break)
                ];
            }
        }
    }

    public function applyToAll($field)
    {
        $sourceValue = $this->daysData['monday'][$field];
        
        foreach ($this->daysData as $day => $data) {
            if (!$this->daysData[$day]['is_offday']) {
                $this->daysData[$day][$field] = $sourceValue;
            }
        }
    }
    public function save()
    {
        $this->validate([
            'name' => 'required|min:3',
            'tolerance' => 'required|numeric',
        ]);

        DB::transaction(function () {
            $group = WorkScheduleGroup::updateOrCreate(
                ['id' => $this->selectedId],
                [
                    'name' => $this->name,
                    'tolerance' => $this->tolerance,
                    'count_late' => $this->count_late,
                ]
            );

            // Simpan atau Update tiap hari
            foreach ($this->daysData as $dayName => $data) {
                $group->days()->updateOrCreate(
                    ['day' => $dayName],
                    [
                        'is_offday'  => $data['is_offday'],
                        'arrival'    => $data['is_offday'] ? null : $data['arrival'],
                        'start_time' => $data['is_offday'] ? null : $data['start_time'],
                        'end_time'   => $data['is_offday'] ? null : $data['end_time'],
                        'break_start'=> $data['is_offday'] ? null : $data['break_start'],
                        'break_end'  => $data['is_offday'] ? null : $data['break_end'],
                        'is_break'   => $data['is_break'],
                    ]
                );
            }
        });

        $this->dispatch('swal:success', message: 'Pola kerja berhasil disimpan!');
        $this->dispatch('close-modal');
        $this->dispatch('refresh-table');
    }

    public function resetForm()
    {
        $this->reset(['name', 'tolerance', 'count_late', 'selectedId', 'isEditing']);
        $this->initDefaultDays();
    }

    public function delete($selectedId)
{
    // 1. Cek apakah pola kerja ini sedang digunakan oleh karyawan
    $isUsed = DB::table('employee_work_schedules')
                ->where('work_schedule_group_id', $selectedId)
                ->exists();

    if ($isUsed) {
        // Jika sedang dipakai, kirim pesan error dan batalkan penghapusan
        $this->dispatch('swal:error', message: 'Gagal! Pola kerja ini tidak dapat dihapus karena masih digunakan oleh karyawan.');
        return;
    }

    // 2. Jika tidak digunakan, lakukan penghapusan
    try {
        DB::transaction(function () use ($selectedId) {
            $group = WorkScheduleGroup::findOrFail($selectedId);
            
            // Hapus detail hari terlebih dahulu (jika tidak menggunakan cascade delete di database)
            $group->days()->delete();
            
            // Hapus group utama
            $group->delete();
        });

        $this->dispatch('swal:success', message: 'Pola kerja berhasil dihapus!');
        $this->dispatch('close-modal');
        $this->dispatch('refresh-table');

    } catch (\Exception $e) {
        $this->dispatch('swal:error', message: 'Terjadi kesalahan saat menghapus data.');
    }
}

    public function render()
    {
        return view('livewire.work-day-form');
    }
}