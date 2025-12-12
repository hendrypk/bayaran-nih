<?php

namespace App\Livewire;

use App\Models\Employee;
use App\Models\Holiday;
use App\Models\Presence;
use App\Models\WorkScheduleGroup;
use Carbon\Carbon;
use Livewire\Component;
use Maatwebsite\Excel\Concerns\ToArray;

class PresenceManualModal extends Component
{
    public $employees = [];
    public $employeeId;
    public $date;
    public $checkIn;
    public $checkOut;
    public $presenceId;
    public $workDays = [];
    public $workDayId;
    public $workDayName;
    public $lateCheckIn = 0;
    public $lateArrival = false;
    public $checkOutEarly = 0;
    public $isEditing = false;


    public function mount($presenceId = null)
    {
        // Ambil semua employee dan workDayIds mereka
        $this->employees = Employee::whereNull('resignation')
            ->with('workDay')
            ->get()
            ->map(function($emp){
                return [
                    'id' => (int) $emp->id,
                    'eid' => $emp->eid,
                    'name' => $emp->name,
                    'workDayIds' => $emp->workDay->pluck('id')->map(fn($id) => (int)$id)->toArray(),
                ];
            })->toArray();

        if ($presenceId) {
            $this->isEditing = true;
            $this->loadPresenceData($presenceId);
        }
    }

    public function loadPresenceData($presenceId)
    {
        $p = Presence::findOrFail($presenceId);

        $this->employeeId = (int) $p->employee_id;
        $this->workDayId  = (int) $p->work_day_id;

        // Format date supaya compatible dengan input type="date"
        $this->date = Carbon::parse($p->date)->format('Y-m-d');

        $this->checkIn = $p->check_in;
        $this->checkOut = $p->check_out;
        $this->lateArrival = $p->late_arrival;
        $this->checkOutEarly = $p->check_out_early;
        $this->lateCheckIn = $p->late_check_in;

        // Load workDays untuk employee yang terpilih
        $employee = collect($this->employees)->firstWhere('id', $this->employeeId);
        $this->workDays = collect($employee['workDayIds'])->map(function($id){
            // Bisa ambil nama workDay dari WorkScheduleGroup kalau perlu
            $group = WorkScheduleGroup::find($id);
            return [
                'id' => $group->id,
                'name' => $group->name,
            ];
        })->toArray();
    }


    public function updatedEmployeeId($value)
    {
        if (!$value) {
            $this->resetWorkDays();
            return;
        }

        $employee = Employee::with('workDay')->find($value);
        if (!$employee) {
            $this->resetWorkDays();
            return;
        }

        $this->workDays = $employee->workDay->map(fn($item) => [
            'id' => $item->id,
            'name' => $item->name,
        ])->toArray();

        $this->workDayId = null;
    }


    public function updatedWorkDayId()
    {
        $this->loadWorkDayData();
    }

    public function updatedDate()
    {
        $this->loadWorkDayData();
    }

    public function updatedCheckIn()
    {
        $this->loadWorkDayData();
    }

    public function updatedCheckOut()
    {
        $this->loadWorkDayData();
    }

    public function loadWorkDayData()
    {
        if (!$this->workDayId || !$this->date) {
            return;
        }

        $group = WorkScheduleGroup::with('days')->find($this->workDayId);
        if (!$group) return;

        $dayname = strtolower(Carbon::parse($this->date)->format('l'));
        $workDay = $group->days->firstWhere('day', $dayname);
        $parse = fn($t) => $t && $t !== 'N/A' ? Carbon::parse($t) : null;

        if (!$workDay) return;

        $params = (object)[
            'checkIn'    => $parse($this->checkIn),
            'checkOut'    => $parse($this->checkOut),
            'arrival'    => $parse($workDay->arrival),
            'start'      => $parse($workDay->start_time),
            'end'        => $parse($workDay->end_time),
            'breakStart' => $parse($workDay->break_start),
            'breakEnd'   => $parse($workDay->break_end),
            'countBreak' => $workDay->count_break,
            'countLate'  => $group->count_late,
            'tolerance'  => $group->tolerance,
        ];
        $this->lateCheckIn = $this->calculateLateCheckIn($params);
        if($this->lateCheckIn > 0) {
            $this->lateArrival = true;
        } else {
            $this->lateArrival = false;
        }
        $this->checkOutEarly = $this->calculateCheckOutEarly($params);
    }

    private function calculateCheckOutEarly($p)
    {
        // Pastikan actual check-out dan end time ada
        if (!$p->checkOut || !$p->end) {
            return 0;
        }

        $actualEnd   = $p->checkOut;
        $startTime   = $p->start;
        $endTime     = $p->end;
        $breakStart  = $p->breakStart;
        $breakEnd    = $p->breakEnd;
        $isCountLate = $p->countLate;
        $countBreak = $p->countBreak;

        // Hitung durasi break sekali saja
        $breakDuration = ($breakStart && $breakEnd)
            ? max($breakStart->diffInMinutes($breakEnd, false), 0)
            : 0;

        // Jika tidak dihitung late, return 0 langsung
        if ($isCountLate == false) {
            return 0;
        }

        // Kondisi awal
        $checkOutEarly = max($actualEnd->diffInMinutes($endTime, false), 0);

        // Jika break dihitung, kurangi durasi break jika pulang lewat atau diantara break
        if ($countBreak == true && $breakStart && $breakEnd) {
            if ($actualEnd->lt($breakStart)) {
                // Pulang sebelum break, kurangi durasi break
                $checkOutEarly = max($checkOutEarly - $breakDuration, 0);
            } elseif ($actualEnd->between($breakStart, $breakEnd)) {
                // Pulang di tengah break, hanya hitung sisa sampai endTime
                $checkOutEarly = max($breakEnd->diffInMinutes($endTime, false), 0);
            }
            // Lainnya: pulang setelah break, gunakan nilai awal $checkOutEarly
        }

        // Jika actualEnd lebih awal dari startTime (tidak mungkin early check-out), set 0
        if ($actualEnd->lt($startTime)) {
            $checkOutEarly = 0;
        }

        return $checkOutEarly;
    }

    private function calculateLateCheckIn($p)
    {
        // Pastikan actual check-in dan start time ada
        if (!$p->checkIn || !$p->start) {
            return 0;
        }

        $actual     = $p->checkIn;
        $startTime  = $p->start;
        $breakStart = $p->breakStart;
        $breakEnd   = $p->breakEnd;
        $isCountLate = $p->countLate;
        $countBreak  = $p->countBreak;

        // Hitung durasi break sekali saja
        $breakDuration = ($breakStart && $breakEnd)
            ? max($breakStart->diffInMinutes($breakEnd, false), 0)
            : 0;

        // Jika tidak dihitung telat
        if (!$isCountLate) {
            return 0;
        }

        // Default: selisih menit actual - startTime
        $lateMinutes = max($startTime->diffInMinutes($actual, false), 0);

        // Jika break dihitung, kurangi durasi break sesuai kondisi
        if ($countBreak == true && $breakStart && $breakEnd) {
            if ($actual->between($breakStart, $breakEnd)) {
                // Check-in di tengah break, hitung sampai break mulai
                $lateMinutes = max($startTime->diffInMinutes($breakStart, false), 0);
            } elseif ($actual->gt($breakEnd)) {
                // Check-in setelah break selesai
                $lateMinutes = max($lateMinutes - $breakDuration, 0);
            }
            // Check-in sebelum break tetap gunakan lateMinutes default
        }

        return $lateMinutes;
    }

    private function resetWorkDays()
    {
        $this->workDays = [];
        $this->workDayId = null;
    }
    
    private function flashValidationError($e)
    {
        $errorText = collect($e->errors())->flatten()->implode("\n");
        $this->dispatch('swal:error', message: $errorText);
    }

    public function checkDayOff()
    {

    }

    public function rules()
    {
        return [
            'employeeId' => 'required|exists:employees,id',
            'workDayId' => 'required|exists:work_schedule_groups,id',
            'date' => 'required',
            'checkIn' => 'required',
            'checkOut' => 'required'
        ];
    }

    public function save()
    {
        // Validasi input
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->flashValidationError($e);
        }

        // Ambil data employee
        $employee = Employee::find($this->employeeId);
        $group = WorkScheduleGroup::with('days')->find($this->workDayId);
        $dayname = strtolower(Carbon::parse($this->date)->format('l'));
        $workDay = $group->days->firstWhere('day', $dayname);
        $holiday = Holiday::where('date', $this->date)->first();
        
        if ($workDay->is_offday || $holiday) {
            $this->dispatch('swal:error', message: 'Hari libur, biarkan karyawan istirahat dulu ya 😊');
            return;
        }

        // Pastikan nilai late/early selalu integer / 0
        $lateCheckIn   = (int) $this->lateCheckIn;
        $lateArrival   = $this->lateArrival ? 1 : 0;
        $checkOutEarly = (int) $this->checkOutEarly;

        // Data yang akan disimpan
        $data = [
            'employee_id'     => $this->employeeId,
            'eid'             => $employee->eid ?? $this->employeeId,
            'employee_name'   => $employee->name ?? '-',
            'work_day_id'     => $this->workDayId,
            'date'            => $this->date,
            'check_in'        => $this->checkIn,
            'check_out'       => $this->checkOut,
            'late_check_in'   => $lateCheckIn,
            'late_arrival'    => $lateArrival,
            'check_out_early' => $checkOutEarly,
        ];

        if ($this->isEditing && $this->presenceId) {
            // UPDATE existing presence
            $presence = Presence::find($this->presenceId);
            if (!$presence) {
                $this->dispatch('swal:error', message: 'Presensi tidak ditemukan.');
                return;
            }
            $data['updater'] = auth()->id();
            $presence->update($data);
            $this->dispatch('swal:success', message: 'Presensi berhasil diperbarui.');
        } else {
            // CEK apakah presensi sudah ada untuk employee + tanggal
            $exists = Presence::where('employee_id', $this->employeeId)
                ->where('date', $this->date)
                ->whereNull('deleted_at')

                ->first();

            if ($exists) {
                $this->dispatch('swal:error', message: 'Presensi untuk karyawan ini pada tanggal tersebut sudah ada.');
                return;
            }

            // CREATE new presence
            $data['creator'] = auth()->id();
            Presence::create($data);
            $this->dispatch('swal:success', message: 'Presensi berhasil dibuat.');
        }

        // Event untuk close modal
        $this->dispatch('close-modal');

        // Event untuk reload data
        $this->dispatch('reload-data');
    }



    public function render()
    {
        return view('livewire.presence-manual-modal');
    }
}
