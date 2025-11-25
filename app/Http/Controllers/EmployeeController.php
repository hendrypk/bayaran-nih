<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Models\WorkDay;
use App\Models\Division;
use App\Models\Employee;
use App\Models\JobTitle;
use App\Models\Overtime;
use App\Models\Position;
use App\Models\KpiAspect;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\AppraisalName;
use App\Models\EmployeeStatus;
use App\Models\OfficeLocation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\EmployeeRequest;
use App\Models\EmployeePositionChange;
use App\Models\Presence;
use App\Models\WorkScheduleGroup;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    //Employee List
    function employeelist()
    {
        $employee = Employee::whereNull('resignation')->get();
        return view('employee.index', compact('employee'));
    }

    //Employee Form
    public function form($id = null)
    {
        $employee = $id ? Employee::with(['workDay', 'officeLocations'])->findOrFail($id) : new Employee();
        $position = Position::all();
        $job_title = JobTitle::all();
        $division = Division::all();
        $department = Department::all();
        $workScheduleGroups = WorkScheduleGroup::all();
        $officeLocations = OfficeLocation::all();
        $pa_id = AppraisalName::all();
        $kpi_id = KpiAspect::all();
        $status = EmployeeStatus::all();
        $options = Employee::options();
        $genders = $options['genders'];
        $marriages = $options['marriages'];
        $bloods = $options['bloods'];
        $religions = $options['religions'];
        $banks = $options['banks'];
        $educations = $options['educations'];

        return view('employee.form', compact(
            'employee', 'position', 'job_title', 'division',
            'officeLocations', 'department', 'status',
            'pa_id', 'kpi_id', 'bloods', 'marriages',
            'genders', 'religions', 'educations', 'banks', 'workScheduleGroups'
        ));
    }

    //employee detail
    public function detail($id)
    {
        $employee = Employee::with('job_title', 'position', 'workDay', 'kpis', 'positionChange.position', 'positionChange.oldPosition')->findOrFail($id);
        $presences = Presence::where('employee_id', $id)
            ->whereNotNull('leave')
            ->get();
        $careers = $employee->positionChange()->orderBy('effective_date', 'desc')->get();
        
        $startDate = new DateTime($employee->joining_date);
        $dateBirth = new DateTime($employee->date_birth);
        $currentDate = new DateTime();
        $yo = $startDate->diff($currentDate);
        $joining_date = $startDate->diff($currentDate);

        $years = $joining_date->y;
        $months = $joining_date->m;
        $days = $joining_date->d;

        $totalOvertime = Overtime::where('employee_id', $employee->eid)
            ->sum('total');
        return view('employee.detail', compact('employee', 'presences', 'yo', 'years', 'months', 'days', 'totalOvertime', 'careers'));
    }

    //submit employee
    public function submit(EmployeeRequest $request)
    {
        $data = $request->validated();
        $position = Position::with('job_title')->findOrFail($data['position_id']);
        $section = $position->job_title->section ?? 'XXX';

        $isUpdate = isset($data['id']) && Employee::find($data['id']);

        if (!$isUpdate) {
            $id = Employee::max('id') + 1; 
            $position = Position::with('job_title')->find($request->position_id);
            $section = $position->job_title->section;
            $formattedId = str_pad($id, 3, '0', STR_PAD_LEFT);
            $eid = $section . $formattedId;

            $rawPassword = \Carbon\Carbon::parse($data['date_birth'])->format('dmY');
            $data['password'] = Hash::make($rawPassword);
            $data['eid'] = $eid;
            $data['username'] = $eid;
        } else {
            $eid = $data['eid'] ?? null;
        }

        $employee = Employee::updateOrCreate(
            ['id' => $data['id'] ?? null],
            $data
        );

        $employee->workDay()->sync($request->workDay ?? []);
        $employee->officeLocations()->sync($request->officeLocations ?? []);

        return response()->json([
            'success' => true,
            'message' => 'Employee saved successfully',
            'route' => route('employee.detail', ['id' => $employee->id])
        ]);
    }

    //Reset Username Password
    public function resetUsernamePassword(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|regex:/^\S*$/|unique:employees,username',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $username = $request->username;
        $password = $request->password;
        $employee = Employee::find($id);
        $employee->update ([
            'username' => $username,
            'password' => Hash::make($password),
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Account reset successfully', 
            'route' => route('employee.detail', ['id' => $employee->id])
        ], 200);
    }

    //employee delete
    function delete($id)
    {
        $employee = Presence::where('employee_id', $id)->first();
        if($employee) {
            return response()->json([
                'success' => false,
                'message' => 'Karyawan yang sudah melakukan presensi, tidak dapat dihapus'
            ], 200);
        } else {
            $employee = Employee::find($id);
            $employee->delete();
        }
        return redirect()->route('employee.list');
    }

    //direct upload profile
    public function upload(Request $request, $id)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $employee = Employee::find($id);
        // dd($id);
        if (!$employee->exists) {
        return back()->with('error', 'Employee not found.');
            }

        if ($request->hasFile('profile_photo') && $request->file('profile_photo')->isValid()) {
            $employee->clearMediaCollection('profile_photos');
            $employee->addMediaFromRequest('profile_photo')->toMediaCollection('profile_photos', 'public');
        }
                
        return back()->with('success', 'Foto berhasil diunggah!');
    }
}
