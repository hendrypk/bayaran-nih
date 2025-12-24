<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Position;
use App\Models\Division;
use App\Models\JobTitle;
use App\Models\Department;
use App\Models\Holiday;
use App\Models\OfficeLocation;
use App\Models\EmployeeStatus;
use App\Models\LaporHrCategory;
use Illuminate\Support\Str;

class OptionModal extends Component
{
    // Properti Form Dinamis
    public $tableId = '';
    public $type; // ID Tabel (positions, divisions, dll)
    public $isEditing = false;
    public $name, $section, $job_title_id, $department_id, $division_id;
    
    // Properti untuk Dropdown (Data referensi)
    public $jobTitles = [], $departments = [], $divisions = [];

    /**
     * Mount: Dijalankan sekali saat komponen dimuat.
     * Mengambil semua data referensi untuk dropdown di modal.
     */
    public function mount()
    {
        $this->loadReferences();
    }

    /**
     * Memuat data untuk keperluan dropdown select
     */
    public function loadReferences()
    {
        $this->jobTitles = JobTitle::orderBy('name')->get();
        $this->departments = Department::orderBy('name')->get();
        $this->divisions = Division::orderBy('name')->get();
    }

    /**
     * Listener untuk menangkap event dari Alpine.js / Modal Trigger
     * Dipanggil lewat: @click="$wire.setContext('positions')"
     */
    public function setContext($id)
    {
        $this->tableId = $id; // Set ID tabel di sisi server
        $this->resetForm();
        // Opsional: kirim event ke browser jika Alpine masih butuh title
        $this->dispatch('context-set', id: $id); 
    }

    public function resetForm()
    {
        $this->reset(['name', 'section', 'job_title_id', 'department_id', 'division_id']);
        $this->resetValidation();
    }

    /**
     * Fungsi Save Dinamis
     */
    public function save()
    {
        // 1. Validasi Dinamis
        $rules = ['name' => 'required|min:3'];
        
        if ($this->type === 'job_titles') $rules['section'] = 'required';
        if ($this->type === 'positions') {
            $rules['job_title_id'] = 'required';
            $rules['department_id'] = 'required';
        }

        $this->validate($rules);

        // 2. Mapping Model berdasarkan Type
        $model = $this->getModelInstance();

        // 3. Eksekusi Simpan
        $model->create($this->prepareData());

        // 4. Feedback & Reset
        $this->dispatch('swal:success', message: 'Data berhasil ditambahkan!');
        $this->dispatch('close-modal'); // Tutup modal via Alpine/JS
        $this->resetForm();
    }

    protected function getModelInstance()
    {
        return match ($this->type) {
            'positions'     => new Position,
            'divisions'     => new Division,
            'job_titles'    => new JobTitle,
            'departments'   => new Department,
            'holidays'      => new Holiday,
            'locations'     => new OfficeLocation,
            'statuses'      => new EmployeeStatus,
            'hr_categories' => new LaporHrCategory,
            default         => throw new \Exception("Tipe tidak valid"),
        };
    }

    protected function prepareData()
    {
        $data = ['name' => $this->name];

        if ($this->type === 'job_titles') $data['section'] = $this->section;
        if ($this->type === 'positions') {
            $data['job_title_id'] = $this->job_title_id;
            $data['department_id'] = $this->department_id;
            $data['division_id'] = $this->division_id;
        }
        if ($this->type === 'divisions') $data['department_id'] = $this->department_id;

        return $data;
    }
    public function render()
    {
        return view('livewire.option-modal');
    }
}
