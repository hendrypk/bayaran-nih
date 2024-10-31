<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Employee;
use App\Models\JobTitle;
use App\Models\Position;
use App\Models\Department;
use App\Models\KpiOptions;
use App\Models\SalesPerson;
use App\Models\WorkCalendar;
use App\Models\WorkSchedule;
use Illuminate\Http\Request;
use App\Models\OnDayCalendar;
use App\Models\EmployeeStatus;
use App\Models\OfficeLocation;
use App\Models\PerformanceAppraisal;
use App\Models\PerformanceKpi;

class OptionsController extends Controller
{


    function index(){
        $positions = Position::get();
        $divisions = Division::get();
        $job_titles = JobTitle::get();
        $departments = Department::get();
        $calendars = WorkCalendar::get();
        $salesPerson = SalesPerson::get();
        $employees = Employee::get();
        $schedules = WorkSchedule::get();
        $statuses = EmployeeStatus::get();
        $officeLocation = OfficeLocation::get();
        return view('options.index', compact('positions', 'divisions', 'job_titles', 'departments','calendars',
        'salesPerson', 'employees', 'schedules', 'statuses', 'officeLocation'));
    }

    // function IndexKpiPa(){
    //     $indicators = KpiOptions::select('position_id')->groupBy('position_id')->distinct()->get();
    //     $appraisals = PerformanceAppraisal::get();
    //     return view('options.kpi-pa-index', compact('indicators', 'appraisals'));
    // }

//position add
    function positionAdd(Request $request){
        $request->validate([
            'position' => 'required|string|unique:positions,name,',
        ], [
            'position.required' => 'Position Name is required',
            'position.string' => 'Invalid Character',
            'position.unique' => 'Position Name Already Exist'
        ]);
        
        try {
            Position::updateOrCreate(
                ['id' => $request->id],  // Search for the record by its 'id'
                ['name' => $request->position]  // Set the 'name' to be updated or created
            );
    
            return redirect()->route('options.list')->with('success', 'Position added successfully.');
    
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

//position edit
    function positionEdit($id){
        $position = Position::findOrFail($id);
        return view('position.edit');
    
    }

    function positionUpdate(Request $request, $id){
        $position = Position::findOrFail($id);
        $request->validate([
            'name'=> 'string',
        ]);
        $position->name = $request->name;

        $position->save();

        return redirect()->route('options.list')->with('success', 'Position updated successfully.');
    }

//position delete
    public function positionDelete($id){
        $position = Position::find($id);
        $position->delete();

        return response()->json([
            'success' => true,
            'message' => 'The location has been deleted.',
            'redirect' => route('options.list') 
        ]);
        // return redirect()->route('options.list')->with('success', 'Position deleted successfully.');
    }
        
//jobtitle add
    function jobTitleAdd(Request $request){
        $jobTitle = new JobTitle();
        $jobTitle->id = $request->id;
        $jobTitle->name = $request->name;
        $jobTitle->section = $request->section;
        $jobTitle->save();

        return redirect()->route('options.list')->with('success', ' ');
    }

//jobtitle edit
    function jobTitleEdit($id){
        $jobTitle = JobTitle::findOrFail($id);
        return view('jobTitle.edit', compact('jobTitle'));
    }

    function jobTitleUpdate(Request $request, $id){
        $jobTitle = JobTitle::findOrFail($id);
        $request->validate([
            'name'=> 'string',
        ]);
        $jobTitle->name = $request->name;
        $jobTitle->section = $request->section;
        $jobTitle->save();

        return redirect()->route('options.list')->with('success', ' ');
    }

//jobtitle delete
    public function jobTitleDelete($id){
        $jobTitle = JobTitle::find($id);
        $jobTitle->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'The location has been deleted.',
            'redirect' => route('options.list')
        ]);
    }

//division
    function divisionAdd(Request $request){
        $division = new Division();
        $division->id = $request->id;
        $division->name = $request->name;
        $division->save();
        return redirect()->route('options.list')->with('success', ' ');
    }

//division edit
    function divisionEdit($id){
        $division = Division::findORFail($id);
        return view('division.edit', compact('division'));
    }
    function divisionUpdate(Request $request, $id){
        $division = Division::findOrFail($id);
        $request->validate([
            'name'=>'string',
        ]);
        $division->name = $request->name;
        $division->save();
        return redirect()->route('options.list')->with('success', ' ');
    }

//division delete
    public function divisionDelete($id)
    {
        $division = Division::find($id);
        $division->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'The location has been deleted.',
            'redirect' => route('options.list')
        ]);
    }

//department
    function departmentAdd(Request $request){
        $department = new Department();
        $department->id = $request->id;
        $department->name = $request->name;
        $department->save();

        return redirect()->route('options.list')->with('success', ' ');
    }

//department edit
    function departmentEdit($id){
        $department = Department::findOrFail($id);
        return view('department.edit', compact('department'));

    }

    function departmentUpdate(Request $request, $id){
        $department = Department::findOrFail($id);
        $request->validate([
            'name'=> 'string',
        ]);
        $department->name = $request->name;

        $department->save();

        return redirect()->route('options.list')->with('success', ' ');
    }

//department delete
    public function departmentDelete($id){
        $department = Department::find($id);
        $department->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'The location has been deleted.',
            'redirect' => route('options.list')
        ]);
    }

// Add Employee Status
    function statusAdd(Request $request){
        $status = new EmployeeStatus();
        $status->id = $request->id; // Ensure this ID is unique and valid
        $status->name = $request->name;
        $status->save();
        return redirect()->route('options.list')->with('success', ' ');
    }

//Employee Status edit
    function statusEdit($id){
        $status = EmployeeStatus::findOrFail($id);
        return view('status.edit', compact('status'));
    }

    function statusUpdate(Request $request, $id){
        $status = EmployeeStatus::findOrFail($id);
        $request->validate([
            'name'=> 'string',
        ]);
        $status->name = $request->name;
        $status->save();
    return redirect()->route('options.list')->with('success', ' ');
    }

//Employee Status delete
    public function statusDelete($id){
        $status = EmployeeStatus::findOrFail($id);
        $status->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'The location has been deleted.',
            'redirect' => route('options.list')
        ]);
    }

//Add sales person
    function salesPersonAdd(Request $request){
        $employee = Employee::where('name', $request->salesPerson)->first();
        if (!$employee) {
            return redirect()->back()->withErrors(['salesPerson' => 'Employee not found.']);
        }

        $salesPerson = new SalesPerson();
        $salesPerson->id = $request->id; // Ensure this ID is unique and valid
        $salesPerson->eid = $employee->eid; // Save the employee's ID
        $salesPerson->employee_name = $request->salesPerson;
        $salesPerson->save();
        return redirect()->route('options.list')->with('success', ' ');
    }

//sales person edit
    function salesPersonEdit($id){
        $salesPerson = SalesPerson::findOrFail($id);
        return view('salesPerson.edit', compact('salesPerson'));

    }

    function salesPersonUpdate(Request $request, $id){
        $salesPerson = SalesPerson::findOrFail($id);
        $request->validate([
            'name'=> 'string',
            'eid'=> 'string',
        ]);
        $salesPerson->employee_name = $request->name;
        $salesPerson->eid = $request->eid;
        $salesPerson->save();

        return redirect()->route('options.list')->with('success', ' ');
    }

//sales person delete
    public function salesPersonDelete($id){
        $salesPerson = Salesperson::findOrFail($id);
        $salesPerson->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'The location has been deleted.',
            'redirect' => route('options.list')
        ]);
    }

//schedule add
    function scheduleAdd(Request $request){
        $schedule = new WorkSchedule();
        $schedule->id = $request->id;
        $schedule->name = $request->name;
        $schedule->arrival = $request->arrival;
        $schedule->start_at = $request->start;
        $schedule->end_at = $request->end;
        $schedule->save();
        return redirect()->route('options.list')->with('success', ' ');
    }

//schedule edit
    function scheduletEdit($id){
        $schedule = WorkSchedule::findOrFail($id);
        return view('schedule.edit', compact('schedule'));

    }

    function scheduleUpdate(Request $request, $id){
        $schedule = WorkSchedule::findOrFail($id);
        $request->validate([
            'name'=> 'string',
            'arrival'=> ['regex:/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/'],
            'start'=> ['regex:/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/'],
            'end'=> ['regex:/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/'],
        ]);
        $schedule->name = $request->name;
        $schedule->arrival = $request->arrival;
        $schedule->start_at = $request->start;
        $schedule->end_at = $request->end;
        $schedule->save();

        return redirect()->route('options.list')->with('success', ' ');
    }

//schedule delete
    function scheduleDelete($id){
        $schedule = WorkSchedule::find($id);
        $schedule->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'The location has been deleted.',
            'redirect' => route('options.list')
        ]);
    }

//on day calendar
    function onDayCalendarAdd(Request $request){
        $calendars = new WorkCalendar();
        $calendars->id = $request->id;
        $calendars->name = $request->name;
        $calendars->jan = $request->jan;
        $calendars->feb = $request->feb;
        $calendars->mar = $request->mar;
        $calendars->apr = $request->apr;
        $calendars->may = $request->may;
        $calendars->jun = $request->jun;
        $calendars->jul = $request->jul;
        $calendars->aug = $request->aug;
        $calendars->sep = $request->sep;
        $calendars->oct = $request->oct;
        $calendars->nov = $request->nov;
        $calendars->dec = $request->dec;
        $calendars->save();
        return redirect()->route('options.list')->with('success', ' ');
    }

// Edit Appraisal 
    function onDayCalendarEdit($id){
        $calendars = WorkCalendar::findOrFail($id);
        return view('onDayCalendar.edit', compact('calendars'));
        }
        
        function onDayCalendarUpdate(Request $request, $id){
        $calendars = WorkCalendar::findOrFail($id);
        $calendars->id = $request->id;
        $calendars->name = $request->name;
        $calendars->jan = $request->jan;
        $calendars->feb = $request->feb;
        $calendars->mar = $request->mar;
        $calendars->apr = $request->apr;
        $calendars->may = $request->may;
        $calendars->jun = $request->jun;
        $calendars->jul = $request->jul;
        $calendars->aug = $request->aug;
        $calendars->sep = $request->sep;
        $calendars->oct = $request->oct;
        $calendars->nov = $request->nov;
        $calendars->dec = $request->dec;
        $calendars->save();
        return redirect()->route('options.list')->with('success', ' ');
    }

//on day delete
    function onDayCalendarDelete($id){
        $calendars = WorkCalendar::find($id);
        $calendars->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'The location has been deleted.',
            'redirect' => route('options.list')
        ]);
    }

//Office Location Add
    public function addLocation(Request $request){
        $ol = OfficeLocation::create([
            'name' => $request->name,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'radius' => $request->radius
        ]);
        return redirect()->route('options.list')->with('success', 'Office Location Added Successfully.');
    }

//Office Location Edit
    // public function editLocation($id){
    //     $ol = OfficeLocation::find($id);
    //     $ol->update([
    //         'name' => $request->name,
    //         'latitude' => $request->latitude,
    //         'longitude' => $request->longitude,
    //         'radius' => $request->radius
    //     ]);
    //     return redirect()->route('options.list')->with('success', ' ');
    // }

//Office Location Edit
public function deleteLocation($id){
    $ol = OfficeLocation::find($id);
    $ol->delete();
    
    return response()->json([
        'success' => true,
        'message' => 'The location has been deleted.',
        'redirect' => route('options.list')
    ]);
}
}


