<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Presence;
use Illuminate\Support\Facades\Auth;

class PresenceDetailModal extends Component
{
    public $presenceId;

    public $employeeId, $name, $eid, $workDayName, $position;
    public $checkInTime, $checkInLocation, $checkInPhoto;
    public $checkOutTime, $checkOutLocation, $checkOutPhoto;
    public $date, $lateArrival, $lateCheckIn, $checkOutEarly;

    public function mount($id = null)
    {
        if ($id) {
            $this->loadPresence($id);
        }
    }

    public function loadPresence($id)
    {
        $this->presenceId = $id;

        $presence = Presence::with('employee', 'employee.position')->find($id);
        if (!$presence) return;

        $this->employeeId = $presence->employee_id;
        $this->name = $presence->employee->name;
        $this->eid = $presence->employee->eid;
        $this->position = $presence->employee->position->name;
        $this->date = $presence->date;

        $this->lateArrival = $presence->late_arrival;
        $this->checkOutEarly = $presence->check_out_early;
        $this->lateCheckIn = $presence->late_check_in;

        // Check In
        $this->checkInTime     = $presence->check_in;
        $this->checkInLocation = $presence->location_in;
        $this->checkInPhoto    = $presence->getFirstMediaUrl('presence-in');
        // dd($this->checkInPhoto);
        // Check Out
        $this->checkOutTime     = $presence->check_out;
        $this->checkOutLocation = $presence->location_out;
        $this->checkOutPhoto    = $presence->getFirstMediaUrl('presence-out');

        // Trigger JS untuk update peta
        $this->dispatch('load-presence-map', 
            checkInLocation: $this->checkInLocation,
            checkOutLocation: $this->checkOutLocation
        );
    }

    public function render()
    {
        return view('livewire.presence-detail-modal');
    }
}
