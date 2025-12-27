<?php

namespace App\Livewire;

use App\Models\Employee;
use App\Models\EmployeeStatus;
use App\Models\OfficeLocation;
use App\Models\PerformanceAppraisalName;
use App\Models\PerformanceKpiName;
use App\Models\Position;
use App\Models\WorkScheduleGroup;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;

class EmployeeForm extends Component
{
    // --- STEP 1: PERSONAL ---
    public $name, $email, $whatsapp, $placeBirth, $dateBirth;
    public $city, $domicile;
    public $bloods, $genders, $religions, $marriages, $educations;

    // --- STEP 2: JOB ---
    public $positionId, $joining_date, $statuses; // Menggunakan 'statuses' sesuai rules & blade Anda
    public $workDay = []; // Inisialisasi array untuk multiple select
    public $officeLocations = [];

    // --- STEP 3: PERFORMANCE & LEAVE ---
    public $managers, $dueLeave, $leaveStock;
    public $kpis = [];
    public $appraisals = [];

    // --- STEP 4: PAYROLL ---
    public $bank, $bank_number;

    // --- OPTIONS DATA ---
    public $bloodsOptions, $gendersOptions, $religionsOptions, $marriagesOptions, $educationsOptions;
    public $positionsOptions, $statusesOptions, $workDayOptions, $officeLocationsOptions;
    public $managersOptions, $kpiCategories, $appraisalCategories, $banksOptions;

    // --- STATE HELPERS ---
    public $isEditing = false;
    public $editingId = null;
    public $isReadOnly = false; // Tambahkan ini
    public $currentStep = 0; // Sesuaikan dengan tab Alpine (mulai dari 0)

    public function mount($id = null)
    {
        // 1. Load Semua Options (seperti yang sudah ada sebelumnya)
        $this->loadOptions();

        // 2. Jika ID ada, mode EDIT aktif
        if ($id) {
            $this->isEditing = true;
            $this->editingId = $id;
            if (request()->routeIs('employee.detail')) {
                $this->isReadOnly = true;
            }
            
            $employee = Employee::with(['workDay', 'OfficeLocations', 'appraisals', 'kpis'])->findOrFail($id);
            
            // Mapping Data Karyawan ke Properti Livewire
            $this->name         = $employee->name;
            $this->email        = $employee->email;
            $this->whatsapp     = $employee->whatsapp;
            $this->placeBirth   = $employee->place_birth;
            $this->dateBirth    = $employee->date_birth;
            $this->bloods       = $employee->blood_type;
            $this->genders      = $employee->gender;
            $this->religions    = $employee->religion;
            $this->marriages    = $employee->marriage;
            $this->educations   = $employee->education;
            $this->city         = $employee->city;
            $this->domicile     = $employee->domicile;
            
            // Job Data
            $this->positionId      = $employee->position_id;
            $this->statuses        = $employee->employee_status;
            $this->joining_date    = $employee->joining_date;
            $this->leaveStock      = $employee->leave_count; // Sesuaikan nama kolom DB
            $this->dueLeave        = $employee->leave_date;  // Sesuaikan nama kolom DB
            
            // Payroll
            $this->bank            = $employee->bank;
            $this->bank_number     = $employee->bank_number;

            // Relation Data (Sync Many-to-Many ke Array)
            $this->workDay         = $employee->workDay->pluck('id')->toArray();
            $this->officeLocations = $employee->OfficeLocations->pluck('id')->toArray();
            $this->appraisals      = $employee->appraisals->pluck('id')->toArray();
            $this->kpis            = $employee->kpis->pluck('id')->toArray();
        }
    }

    private function loadOptions()
    {
        $this->statusesOptions = EmployeeStatus::all();
        $this->positionsOptions = Position::all();
        $this->workDayOptions = WorkScheduleGroup::all();
        $this->officeLocationsOptions = OfficeLocation::all();
        $this->managersOptions = Employee::all();
        $this->kpiCategories = PerformanceKpiName::all();
        $this->appraisalCategories = PerformanceAppraisalName::all();

        $options = \App\Models\Employee::options();
        $this->bloodsOptions     = $options['bloods'];
        $this->gendersOptions    = $options['genders'];
        $this->religionsOptions  = $options['religions'];
        $this->marriagesOptions  = $options['marriages'];
        $this->educationsOptions = $options['educations'];
        $this->banksOptions      = $options['banks'];
    }

    protected function rules()
    {
        return [
            // --- DATA PRIBADI (Step 1) ---
            'name'        => 'required|string|min:3|max:255',
            'email'       => 'required|email',
            'email'    => [
                'required',
                'email',
                'unique:employees,email,' . ($this->editingId ?? 'NULL')
            ],
            'whatsapp'    => 'required|numeric|digits_between:10,15',
            'whatsapp'    => [
                'required',
                'unique:employees,whatsapp,' . ($this->editingId ?? 'NULL')
            ],
            'placeBirth' => 'required',
            'dateBirth'  => 'required|date|before:today',
            
            'city'        => 'nullable',
            'domicile'    => 'nullable',
            
            // --- DROPDOWN OPSIONAL (ENUM/OPTIONS) ---
            'bloods'      => 'nullable',
            'genders'     => 'required', // Sesuaikan dengan value di model
            'religions'   => 'nullable',
            'marriages'   => 'nullable',
            'educations'  => 'nullable',

            // --- PENEMPATAN & JABATAN (Step 2) ---
            'positionId'     => 'required|exists:positions,id',
            'joining_date'    => 'required|date',
            'statuses' => 'required|exists:employee_status,id',
            
            // Multiple Select (Array Validation)
            'workDay'         => 'required|array|min:1',
            'workDay.*'       => 'exists:work_schedule_groups,id',
            'officeLocations' => 'required|array|min:1',
            'officeLocations.*' => 'exists:office_locations,id',

            // --- KINERJA / KPI (Step 3) ---
            'kpis'            => 'nullable|array',
            'kpis.*'          => 'exists:performance_kpi_names,id',
            'appraisals'      => 'nullable|array',
            'appraisals.*'    => 'exists:performance_appraisal_names,id',
            'managers'        => 'nullable|exists:employees,id', // Untuk penilai/atasan

            'dueLeave' => 'nullable|date',
            'leaveStock' => 'nullable|integer'
            // --- PAYROLL / BANK ---
            // 'banks'           => 'nullable|string',
            // 'bank_number'     => 'nullable|numeric|digits_between:5,25',
        ];
    }

    public function nextStep()
    {
        $this->validateStep();
        $this->currentStep++;
    }

    public function prevStep()
    {
        $this->currentStep--;
    }

    // public function validateStep()
    // {
    //     if ($this->currentStep == 1) {
    //         $this->validate(['name' => 'required', 'email' => 'required|email']);
    //     }
    // }

    private function flashValidationError($e)
    {
        $errorText = collect($e->errors())->flatten()->implode("\n");
        $this->dispatch('swal:error', message: $errorText);
    }

// app/Livewire/EmployeeForm.php
public function save()
{
    // dd([
    //     'STEP_1_PERSONAL' => [
    //         'name'       => $this->name,
    //         'email'      => $this->email,
    //         'whatsapp'   => $this->whatsapp,
    //         'placeBirth' => $this->placeBirth,
    //         'dateBirth'  => $this->dateBirth,
    //         'city_ktp'   => $this->city,
    //         'domicile'   => $this->domicile,
    //         'bloods'     => $this->bloods,
    //         'genders'    => $this->genders,
    //         'gendersOptions'    => $this->gendersOptions,
    //         'religions'  => $this->religions,
    //         'marriages'  => $this->marriages,
    //         'educations' => $this->educations,
    //     ],
    //     'STEP_2_JOB' => [
    //         'positionId'      => $this->positionId,
    //         'joining_date'    => $this->joining_date,
    //         'statuses'        => $this->statuses,
    //         'workDay'         => $this->workDay,      // Harus Array
    //         'officeLocations' => $this->officeLocations, // Harus Array
    //     ],
    //     'STEP_3_PERFORMANCE_LEAVE' => [
    //         'managers'   => $this->managers,
    //         'dueLeave'   => $this->dueLeave,
    //         'leaveStock' => $this->leaveStock,
    //         'kpis'       => $this->kpis,       // Harus Array
    //         'appraisals' => $this->appraisals, // Harus Array
    //     ],
    //     'STEP_4_PAYROLL' => [
    //         'bank'        => $this->bank,
    //         'bank_number' => $this->bank_number,
    //     ],
    //     'COMPONENT_STATE' => [
    //         'isEditing' => $this->isEditing,
    //         'editingId' => $this->editingId,
    //     ]
    // ]);
    // 1. Validasi
    try {
        $this->validate();
    } catch (\Illuminate\Validation\ValidationException $e) {
        $errorText = implode("\n", collect($e->errors())->flatten()->toArray());
        $this->dispatch('swal:error', message: $errorText);
        return;
    }

    DB::beginTransaction();
    try {
        // 2. Tentukan data utama yang akan disimpan/diupdate
        $data = [
            'name'            => $this->name,
            'email'           => $this->email,
            'whatsapp'        => $this->whatsapp,
            'city'            => $this->city,
            'domicile'        => $this->domicile,
            'place_birth'     => $this->placeBirth,
            'date_birth'      => $this->dateBirth,
            'blood_type'      => $this->bloods,      // Sesuai public $bloods
            'gender'          => $this->genders,     // Sesuai public $genders
            'religion'        => $this->religions,   // Sesuai public $religions
            'marriage'        => $this->marriages,   // Sesuai public $marriages
            'education'       => $this->educations,  // Sesuai public $educations
            'bank'            => $this->bank,
            'bank_number'     => $this->bank_number,
            'position_id'     => $this->positionId,
            'joining_date'    => $this->joining_date,
            'employee_status' => $this->statuses,     // Sesuai public $statuses & rules
            'manager_id'      => $this->managers,     // Sesuai public $managers
            'is_active'       => 1,
        ];

        if (!$this->isEditing) {
            // 1. Logika Pembuatan EID Otomatis
            $nextId = (Employee::max('id') ?? 0) + 1;
            
            // Ambil kode section dari relasi Position -> JobTitle
            $position = Position::with('job_title')->find($this->positionId);
            $section  = $position->job_title->section ?? 'EMP'; // Fallback jika section kosong
            
            $formattedId = str_pad($nextId, 3, '0', STR_PAD_LEFT);
            $eid = $section . $formattedId;

            // 2. Logika Password Otomatis (Tanggal Lahir: ddmmyyyy)
            $rawPassword = \Carbon\Carbon::parse($this->dateBirth)->format('dmY');
            
            $data['eid']      = $eid;
            $data['username'] = $eid;
            $data['password'] = \Illuminate\Support\Facades\Hash::make($rawPassword);

            $employee = Employee::create($data);
        } else {
            $employee = Employee::findOrFail($this->editingId);
            $employee->update($data);
        }

        // 4. Sinkronisasi Relasi (Support Editing & Creating)
        // sync() akan menghapus yang lama dan mengganti dengan yang baru (otomatis handle editing)
        $employee->workDay()->sync($this->workDay ?? []);
        $employee->officeLocations()->sync($this->officeLocations ?? []);
        $employee->appraisals()->sync($this->appraisals ?? []);
        $employee->kpis()->sync($this->kpis ?? []);

        DB::commit();

        $this->dispatch('swal:success', message: 'Data Karyawan Berhasil Disimpan...');
        if($this->isEditing) {
            return redirect()->route('employee.detail', $this->editingId);
        }
        return redirect()->route('employee.list');

    } catch (\Exception $e) {
        DB::rollback();
        $this->dispatch('swal:error', message: 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

    public function render()
    {
        return view('livewire.employee-form');
    }
}
