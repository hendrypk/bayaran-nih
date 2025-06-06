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
        $employee = Employee::whereNull('resignation')->get();
        return view('employee.index', compact('employee'));
    }
    public function customColumns(Request $request)
    {
        // Ambil kolom yang dipilih dari form
        $selectedColumns = $request->input('columns', []);

        // Fetch data dengan hanya kolom yang dipilih
        $columnsToSelect = array_merge(['id'], $selectedColumns); // Tambahkan 'id' untuk routing detail
        $employees = Employee::select($columnsToSelect)->get();

        return view('employee.index', compact('employees', 'selectedColumns'));
    }

    public function updateTableColumns(Request $request)
    {
        // Ambil kolom yang dipilih
        $selectedColumns = $request->input('columns', []);

        // Kolom valid yang bisa dipilih
        $validColumns = [
            'eid', 'name', 'employee_status', 'position_id', 'job_title_id',
            'division_id', 'department_id', 'sales_status'
        ];

        // Filter kolom yang dipilih, hanya yang valid
        $columnsToQuery = array_intersect($selectedColumns, $validColumns);

        // Query data karyawan dengan kolom yang dipilih
        $employees = Employee::select($columnsToQuery)->get();

        // Kirimkan kolom dan data karyawan sebagai response
        return response()->json([
            'columns' => $columnsToQuery,
            'employees' => $employees
        ]);
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
        $genders = ['Male', 'Female'];
        $bloods = ['A', 'B', 'AB', 'O'];
        $marriage = ['single', 'married', 'widowed'];
        $religions = ['buddha', 'catholic', 'christian', 'hindu', 'islam', 'konghuchu'];
        $educations = [
            'elementary_school',
            'junior_school',
            'high_school',
            'diploma',
            'bachelor',
            'master',
            'doctorate',
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
            'gender' => 'required',
            'religion' => 'required',
            'marriage' => 'required',
            'education' => 'required',
            'whatsapp' => 'required|regex:/^[0-9]+$/',
            'bank' => 'required',
            'bank_number' => 'required|numeric',
            'position_id' => 'required|integer',
            // 'job_title_id' => 'required|integer',
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
        $position = Position::with('job_title')->find($request->position_id);
        $section = $position->job_title->section;
        $formattedId = str_pad($id, 3, '0', STR_PAD_LEFT);
        $eid = $section . $formattedId;
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
            // 'job_title_id' => $request->job_title_id,
            // 'division_id' => $request->division_id,
            // 'department_id' => $request->department_id,
            'joining_date' => $request->joining_date,
            'employee_status' => $request->employee_status,
            'sales_status' => $request->sales_status,
            'pa_id' => $request->pa_id,
            'kpi_id' => $request->kpi_id,
            'bobot_kpi' => $request->bobot_kpi,
        ]);
        $employee->workDay()->sync($request->workDay);
        $employee->officeLocations()->sync($request->officeLocations);

        return response()->json([
            'success' => true,
            'message' => 'Employee added successfully', 
            'route' => route('employee.detail', ['id' => $employee->id])
        ], 200);
    }
    
    //employee detail
    public function detail($id){
        $employee = Employee::with('job_title', 'position', 'workDay', 'kpis')->findOrFail($id);

        $startDate = new DateTime($employee->joining_date);
        $currentDate = new DateTime();
        $interval = $startDate->diff($currentDate);

        $years = $interval->y;
        $months = $interval->m;
        $days = $interval->d;

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
        $genders = ['Male', 'Female'];
        $bloods = ['A', 'B', 'AB', 'O'];
        $marriage = ['single', 'married', 'widowed'];
        $religions = ['buddha', 'catholic', 'christian', 'hindu', 'islam', 'konghuchu'];
        $educations = [
            'elementary_school',
            'junior_school',
            'high_school',
            'diploma',
            'bachelor',
            'master',
            'doctorate',
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

        // $position = Position::with('job_title')->find($request->position_id);
        // $section = $position->job_title->section;
        // $formattedId = str_pad($id, 3, '0', STR_PAD_LEFT);
        // $eid = $section . $formattedId;

        //find employeeId
        $employee = Employee::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'city' => 'required',
            'domicile' => 'required',
            'place_birth' => 'required',
            'date_birth' => 'required',
            'place_birth' => 'required',
            'gender' => 'required',
            'religion' => 'required',
            'marriage' => 'required',
            'education' => 'required',
            'whatsapp' => 'required',
            'bank' => 'required',
            'bank_number' => 'required',
            // 'job_title_id' => 'required',
            'joining_date' => 'required',
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
            // 'eid' => $eid,
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
            // 'position_id' => $request->position_id,
            // 'job_title_id' => $request->job_title_id,
            // 'division_id' => $request->division_id,
            // 'department_id' => $request->department_id,
            'joining_date' => $request->joining_date,
            'employee_status' => $request->employee_status,
            'sales_status' => $request->sales_status,
            'pa_id' => $request->pa_id,
            'kpi_id' => $request->kpi_id,
            'bobot_kpi' => $request->bobot_kpi,
        ]);

        $employee->workDay()->sync($request->workDay);
        $employee->officeLocations()->sync($request->officeLocations);
        
        return response()->json([
            'success' => true,
            'message' => 'Employee updated successfully', 
            'route' => route('employee.detail', ['id' => $employee->id])
        ], 200);
    }
//Reset Username Password
    public function resetUsernamePassword(Request $request, $id) {
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
    function delete($id){
        $employee = Employee::find($id);
        $employee->delete();
        return redirect()->route('employee.list');
    }

}
