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
use App\Models\WorkCalendar;
use App\Models\WorkSchedule;
use Illuminate\Http\Request;
use App\Models\AppraisalName;
use App\Models\EmployeeStatus;
use App\Models\OfficeLocation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{

    //Employee List
    function employeelist(){
        $employee = Employee::with('job_title', 'position')->get();
        return view('employee.index', compact('employee'));
    }

    //Add employee modal
    function create(){
        $position = Position::all();
        $job_title = JobTitle::all();
        $division = Division::all();
        $department = Department::all();
        $workDay = WorkDay::select(DB::raw('MIN(id) as id'), 'name')
            ->groupBy('name')
            ->get();
        $officeLocations = OfficeLocation::all();
        $pa_id = AppraisalName::all();
        $kpi_id = KpiAspect::all();
        $status = EmployeeStatus::all();
        $genders = ['unkown', 'Male', 'Female'];
        $bloods = ['unkown', 'A', 'B', 'AB', 'O'];
        $marriage = ['unkown', 'Single', 'Married', 'Divorced', 'Widowed'];
        $religions = [
            'unkown', 
            'Islam', 
            'Christian', 
            'Catholic', 
            'Hindu', 
            'Buddha', 
            'Confucianism', 
            'Others'
        ];
        $educations = [
            'unkown', 
            'Junior School',
            'High School', 
            'Diploma', 
            'Bachelor\'s Degree', 
            'Master\'s Degree', 
            'Doctorate'
        ];
        $banks = [
            'unkown', 
            'Bank Mandiri', 
            'Bank BNI', 
            'Bank BRI', 
            'Bank BCA', 
            'Bank BTN', 
            'Bank Syariah Indonesia',
            'Bank Danamon', 
            'CIMB Niaga', 
            'Bank Permata', 
            'Bank Mega'
        ];
        return view('employee.add', compact('position', 'job_title', 'division', 'workDay', 'officeLocations', 'department', 'status',
        'pa_id', 'kpi_id', 'bloods', 'marriage', 'genders', 'religions', 'educations', 'banks'));
    }

    //submit new employee
    function submit(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'name' => 'required',
            'city' => 'required',
            'domicile' => 'required',
            'place_birth' => 'required',
            'date_birth' => 'required|date',
            'blood_type' => 'required',
            'gender' => 'required',
            'religion' => 'required',
            'marriage' => 'required',
            'education' => 'required',
            'whatsapp' => 'required|regex:/^[0-9]+$/',
            'bank' => 'required',
            'bank_number' => 'required|numeric',
            'position_id' => 'required|integer',
            'job_title_id' => 'required|integer',
            'joining_date' => 'required|date',
            'employee_status' => 'required',
            'sales_status' => 'required',
            'workDay' => 'required|array|min:1',
            'officeLocations' => 'required|array|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }


        $section = JobTitle::find($request->job_title_id);
        $id = Employee::max('id') + 1; 
        $formattedId = str_pad($id, 3, '0', STR_PAD_LEFT);
        $eid = $section->section . $formattedId;
        $password = Carbon::parse($request->date_birth)->format('dmY');
        $defaultPassword = Hash::make($password);

        $employee = Employee::create([
            'eid' => $eid,
            'email' => $request->email,
            'username' => $eid,
            'password' => $defaultPassword,
            'name' => $request->name,
            'city' => $request->city,
            'domicile' => $request->domicile,
            'place_birth' => $request->place_birth,
            'date_birth' => $request->date_birth,
            'blood_type' => $request->blood_type,
            'gender' => $request->gender,
            'religion' => $request->religion,
            'marriage' => $request->marriage,
            'education' => $request->education,
            'whatsapp' => $request->whatsapp,
            'bank' => $request->bank,
            'bank_number' => $request->bank_number,
            'position_id' => $request->position_id,
            'job_title_id' => $request->job_title_id,
            'division_id' => $request->division_id,
            'department_id' => $request->department_id,
            'joining_date' => $request->joining_date,
            'employee_status' => $request->employee_status,
            'sales_status' => $request->sales_status,
            'pa_id' => $request->pa_id,
            'kpi_id' => $request->kpi_id,
            'bobot_kpi' => $request->bobot_kpi,
        ]);
        $employee->workDay()->sync($request->workDay);
        $employee->officeLocations()->sync($request->officeLocations);

        return redirect()->route('employee.list');
    }
    
    //employee detail
    public function detail($id){
        $employee = Employee::with('job_title', 'position', 'workDay', 'kpis')->findOrFail($id);

        // Menghitung interval hari dari joiningDate hingga sekarang
        $startDate = new DateTime($employee->joining_date);
        $currentDate = new DateTime();
        $interval = $startDate->diff($currentDate);

        // Menghitung tahun, bulan, dan hari dari interval
        $years = $interval->y;
        $months = $interval->m;
        $days = $interval->d;

        //overtime
        $totalOvertime = Overtime::where('employee_id', $employee->eid)
        ->sum('total');
        return view('employee.detail', compact('employee', 'years', 'months', 'days', 'totalOvertime'));
    }

    //employee edit
    public function edit($id){
        $employee = Employee::findOrFail($id);
        $position = Position::all();
        $job_title = JobTitle::all();
        $division = Division::all();
        $department = Department::all();
        $workDay = WorkDay::select(DB::raw('MIN(id) as id'), 'name')
        ->groupBy('name')
        ->get();
        $officeLocations = OfficeLocation::all();
        $pa_id = AppraisalName::all();
        $kpi_id = KpiAspect::all();
        $status = EmployeeStatus::all();
        $genders = ['unkown', 'Male', 'Female'];
        $bloods = ['unkown', 'A', 'B', 'AB', 'O'];
        $marriage = ['unkown', 'Single', 'Married', 'Divorced', 'Widowed'];
        $religions = [
            'Islam', 
            'Christian', 
            'Catholic', 
            'Hindu', 
            'Buddha', 
            'Confucianism', 
            'Others'
        ];
        $educations = [
            'Junior School',
            'High School', 
            'Diploma', 
            'Bachelor\'s Degree', 
            'Master\'s Degree', 
            'Doctorate'
        ];
        $banks = [
            'Bank Mandiri', 
            'Bank BNI', 
            'Bank BRI', 
            'Bank BCA', 
            'Bank BTN', 
            'Bank Syariah Indonesia',
            'Bank Danamon', 
            'CIMB Niaga', 
            'Bank Permata', 
            'Bank Mega'
        ];
        return view('employee.edit', compact('employee', 'position', 'job_title', 'division', 'workDay', 'officeLocations', 'department', 'kpi_id', 'status',
        'pa_id', 'bloods', 'marriage', 'genders', 'religions', 'educations', 'banks'));
    }
    
    public function update(Request $request, $id){

        $section = JobTitle::find($request->job_title_id);
        $formattedId = str_pad($id, 3, '0', STR_PAD_LEFT);
        $eid = $section->section . $formattedId;

        //find employeeId
        $employee = Employee::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'name' => 'required',
            'city' => 'required',
            'domicile' => 'required',
            'place_birth' => 'required',
            'date_birth' => 'required|date',
            'blood_type' => 'required',
            'gender' => 'required',
            'religion' => 'required',
            'marriage' => 'required',
            'education' => 'required',
            'whatsapp' => 'required|regex:/^[0-9]+$/',
            'bank' => 'required',
            'bank_number' => 'required|numeric',
            'position_id' => 'required|integer',
            'job_title_id' => 'required|integer',
            'joining_date' => 'required|date',
            'employee_status' => 'required',
            'sales_status' => 'required',
            'workDay' => 'required|array|min:1',
            'officeLocations' => 'required|array|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $employee->update([
            'eid' => $eid,
            'email' => $request->email,
            'name' => $request->name,
            'city' => $request->city,
            'domicile' => $request->domicile,
            'place_birth' => $request->place_birth,
            'date_birth' => $request->date_birth,
            'blood_type' => $request->blood_type,
            'gender' => $request->gender,
            'religion' => $request->religion,
            'marriage' => $request->marriage,
            'education' => $request->education,
            'whatsapp' => $request->whatsapp,
            'bank' => $request->bank,
            'bank_number' => $request->bank_number,
            'position_id' => $request->position_id,
            'job_title_id' => $request->job_title_id,
            'division_id' => $request->division_id,
            'department_id' => $request->department_id,
            'joining_date' => $request->joining_date,
            'employee_status' => $request->employee_status,
            'sales_status' => $request->sales_status,
            'pa_id' => $request->pa_id,
            'kpi_id' => $request->kpi_id,
            'bobot_kpi' => $request->bobot_kpi,
        ]);

        $employee->workDay()->sync($request->workDay);
        $employee->officeLocations()->sync($request->officeLocations);
        // Inside the update method
        return response()->json([
            'success' => true,
            'message' => 'Employee updated successfully', 
            'route' => route('employee.detail', ['id' => $employee->id])
        ], 200);

        // return redirect()->route('employee.detail', ['id' => $employee->id])->with('success', 'Employee updated successfully');
    }

    //employee delete
    function delete($id){
        $employee = Employee::find($id);
        $employee->delete();
        return redirect()->route('employee.list');
    }

}
