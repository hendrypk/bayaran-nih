<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\{Position, Division, JobTitle, Department, Holiday, OfficeLocation, EmployeeStatus, LaporHrCategory};
use Illuminate\Support\Str;

class OptionModal extends Component
{
    public $tableId = '', $selectedId, $isEditing = false;
    public $name, $section, $job_title_id, $department_id, $division_id, $job_code, $latitude, $longitude, $date, $radius;
    public $jobTitles = [], $departments = [], $divisions = [];

    protected $listeners = ['editData' => 'openModal', 'setContext' => 'openModal'];

    public function mount($id = null, $tableId = null)
    {
        $this->loadReferences();
        if ($id && $tableId) $this->openModal($id, $tableId);
    }

    /**
     * Entry Point Utama untuk Tambah & Edit
     * Jika $id null = Tambah, Jika $id ada = Edit
     */
    public function openModal($id = null, $tableId = null)
    {
        $this->resetForm();
        $this->tableId = $tableId;
        
        if ($id) {
            $this->isEditing = true;
            $this->selectedId = $id;
            $this->loadDataEdit();
        }

        $this->dispatch('open-x-ilz-modal', modal: 'option-modal', args: [
            'tableId' => $tableId,
            'tableTitle' => $this->formatTitle($tableId),
            'isEditing' => $this->isEditing
        ]);
    }

    public function loadDataEdit()
    {
        $data = $this->getModelClass()::findOrFail($this->selectedId);
        $this->fill($data->only(['name', 'section', 'job_title_id', 'department_id', 'division_id', 'job_code', 'latitude', 'longitude', 'radius']));
        if ($data->date) {
        $this->date = is_object($data->date) ? $data->date->format('Y-m-d') : $data->date;
    }
    }

    public function save()
    {
        $this->validate($this->getValidationRules());

        $modelName = $this->getModelClass();
        
        // 1. Tentukan apakah ambil data lama atau buat object baru
        if ($this->isEditing) {
            $item = $modelName::findOrFail($this->selectedId);
            $message = 'Data berhasil diperbarui!';
        } else {
            $item = new $modelName;
            $message = 'Data berhasil ditambahkan!';
        }

        // 2. Isi properti secara manual (Ini bypass proteksi mass assignment)
        $item->name = $this->name;

        // Tambahkan logika kolom tambahan sesuai tableId
        if ($this->tableId === 'job_titles') {
            $item->section = $this->section;
        }

        if ($this->tableId === 'holidays') {
            $item->date = $this->date;
        }


        if ($this->tableId === 'positions') {
            $item->job_title_id = $this->job_title_id;
            $item->department_id = $this->department_id;
            $item->division_id = $this->division_id;
        }

        if ($this->tableId === 'divisions') {
            $item->department_id = $this->department_id;
        }

        if ($this->tableId === 'locations') {
            $item->latitude = $this->latitude;
            $item->longitude = $this->longitude;
            $item->radius = $this->radius;
        }
        // 3. Simpan langsung
        $item->save();

        // 4. Feedback & Reset
        $this->dispatch('swal:success', message: $message);
        $this->dispatch('close-modal');
        $this->dispatch('refresh-table'); 
        $this->resetForm();
    }

    private function getValidationRules()
    {
        $rules = ['name' => 'required|min:3'];
        if ($this->tableId === 'holidays') $rules['date'] = 'required|date';
        if ($this->tableId === 'job_titles') $rules['section'] = 'required';
        if ($this->tableId === 'positions') {
            $rules['job_title_id'] = 'required';
            $rules['department_id'] = 'required';
        }
        if ($this->tableId === 'locations') {
            $rules['latitude'] = 'required|numeric';
            $rules['longitude'] = 'required|numeric';
            $rules['radius'] = 'required|integer|min:10';
        }
        return $rules;
    }

    protected function getModelClass()
    {
        return match ($this->tableId) {
            'positions'     => Position::class,
            'divisions'     => Division::class,
            'job_titles'    => JobTitle::class,
            'departments'   => Department::class,
            'holidays'      => Holiday::class,
            'locations'     => OfficeLocation::class,
            'statuses'      => EmployeeStatus::class,
            'hr_categories' => LaporHrCategory::class,
            default         => throw new \Exception("Tipe tidak valid"),
        };
    }

    protected function prepareData()
    {
        $data = ['name' => $this->name];
        if ($this->tableId === 'job_titles') {
            $data['section'] = $this->section;
        }
        if ($this->tableId === 'holidays') {
            $data['date'] = $this->date;
        }
        if ($this->tableId === 'positions') {
            $data = array_merge($data, [
                'job_title_id' => $this->job_title_id,
                'department_id' => $this->department_id,
                'division_id' => $this->division_id,
            ]);
        }
        if ($this->tableId === 'locations') {
            $data['latitude'] = $this->latitude;
            $data['longitude'] = $this->longitude;
            $data['radius'] = $this->radius;
        }
        if ($this->tableId === 'divisions') $data['department_id'] = $this->department_id;
        return $data;
    }

    public function loadReferences()
    {
        $this->jobTitles = JobTitle::orderBy('name')->get();
        $this->departments = Department::orderBy('name')->get();
        $this->divisions = Division::orderBy('name')->get();
    }
    
    public function resetForm()
    {
        $this->reset(['name', 'section', 'job_title_id', 'department_id', 'division_id', 'date', 'latitude', 'longitude', 'radius']);
        $this->resetValidation();
    }
    private function formatTitle($string) { return Str::title(str_replace('_', ' ', $string)); }
    public function render() { return view('livewire.option-modal'); }
}