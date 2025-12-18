<?php

namespace App\Http\Controllers;

use App\DataTables\LeaveDataTable;
use Carbon\Carbon;
use App\Models\Leave;
use App\Models\Employee;
use App\Models\Presence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{

//Index
    public function index(Request $request)
    {
        $today = now();

        $startDate = Carbon::parse(
            $request->input('start_date', $today->copy()->startOfMonth())
        );

        $endDate = Carbon::parse(
            $request->input('end_date', $today->copy()->endOfDay())
        )->endOfDay();

        $dateType = $request->input('date_type', 'created_at');

        $user = Auth::user();
        $userDivision = Auth::user()->division_id;
        $userDepartment = Auth::user()->department_id;
        
        $employees = Employee::whereNull('resignation')
            ->sameOrg($user)
            ->get();

        $leaves = Leave::whereBetween($dateType, [$startDate, $endDate])
            ->whereHas('employee', fn ($q) => $q->sameOrg($user))
            ->get();



        // $category = [
        //     PRESENCE::STATUS_LEAVE,
        //     PRESENCE::STATUS_HALFDAY,
        //     PRESENCE::STATUS_PERMIT,
        //     PRESENCE::STATUS_SICK,
        // ];

        return view('leave.index', compact(
            'leaves',
            // 'employees',
            // 'category',
            'startDate',
            'endDate'
        ));
    }




    public function save (Request $request) {
        $id = $request->id;
        $employeeId = $request->input('employee_id');
        $leaveDates = $request->input('leave_dates');
        if (is_array($leaveDates)) {
            $leaveDates = explode(',', $leaveDates[0]);
        } else {
            $leaveDates = explode(',', $leaveDates);
        }
        $leaveDates = array_map('trim', $leaveDates);
        $category = $request->input('category');
        $note = $request->input('note');
            $action = $request->input('action');

        $status = match ($action) {
            'accept' => true,
            'reject' => false,
            default => null,
        };

        $employee = Employee::where('id', $employeeId)->first();
        $name = $employee->name;
        $eid = $employee->eid;

        $existPresence = Presence::where('employee_id', $employeeId)
            ->whereIn('date', $leaveDates)
            ->whereNotNull('check_in')
            ->pluck('date')->toArray();

        if($existPresence) {
            return redirect()->back()->withErrors('Karyawan hadir pada tanggal tersebut. Silahkan hapus presensi untuk menyetujui ijin.');
        }

        $existLeave = Presence::where('employee_id', $employeeId)
            ->whereIn('date', $leaveDates)
            ->whereNotNull('leave_status')
            ->pluck('date')->toArray();

        if(count($existLeave) >= 1 && $status === 1) {
            return redirect()->back()->withErrors(['leave_dates' => 'There have been applications for leave on several dates.']);
        }

        $request->validate([
            'employee_id' => 'required',
            'category' => 'required',
            'note' => 'required'
        ]);

        $leaveCount = count($leaveDates);
        if ($category === Presence::LEAVE_ANNUAL) {
            if ($employee->annual_leave < $leaveCount) {
                return redirect()->back()->withErrors('Sisa cuti tahunan tidak mencukupi untuk pengajuan ini.');
            }
        }

        $annualLeaveCount = 0;

        foreach ($leaveDates as $date) {
            Presence::updateOrCreate(
                ['id' => $id 
            ], [    
                'employee_id' => $employeeId,
                'eid' => $eid,
                'date' => $date,
                'leave' => $category,
                'leave_status' => $status,
                'leave_note' => $note,
            ]);
            
            if ($status === true) {
                $annualLeaveCount++;
            }
        }

        if($annualLeaveCount > 0 && $category === Presence::LEAVE_ANNUAL) {
            $employee = Employee::find($employeeId);
            $employee->decrement('annual_leave', $annualLeaveCount);
        }

        return redirect()->back()->with('success', 'Leave for ' . $name . ' saved successfully');
    }

    public function destroy ($id) {
        $leave = Presence::findOrFail($id);
        $leave->update([
            'leave' => null,
            'leave_status' => null,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Leave has been deleted.',
            'redirect' => url()->previous()
        ]);
    }

}
