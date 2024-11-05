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
            'message' => 'The Job Title has been deleted.',
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
            'message' => 'The division has been deleted.',
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
            'message' => 'The department has been deleted.',
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
            'message' => 'The employee status has been deleted.',
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
    public function editLocation(Request $request, $id){
        try {

        $request->validate([
            'name' => 'string',
            'latitude' => 'required',
            'longitude' => 'required',
            'radius' => 'integer'
        ]);

        $officeLocation = OfficeLocation::updateOrCreate(
            ['id' => $id], // Kriteria untuk mencari data
            [ // Data yang akan diperbarui atau dibuat
                'name' => $request->name,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'radius' => $request->radius
            ]
        );
        
        $message = $officeLocation->wasRecentlyCreated ? 'Office Location Added Successfully.' : 'Office Location Updated Successfully.';

        return redirect()->route('options.list')->with('success', $message);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log the validation errors
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            // Log any other exception
            return redirect()->back()->with('error', 'There was an error updating the office location.');
        }
        
    }

//Office Location Delete
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


