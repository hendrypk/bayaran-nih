<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\EmployeePositionChange;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class EmployeePositionChangeController extends Controller
{
    //index
    public function index () {
        $positionChange = EmployeePositionChange::with('employees')->get();
        $employees = Employee::with('position')->whereNull('resignation')->get();
        $category = [
            'mutation',
            'promotion',
            'demotion'
        ];
        $positions = Position::get();
        $latestPositionChanges = $positionChange->groupBy('employees.id')->map(function ($changes) {
            return $changes->sortByDesc('effective_date')->first();  // Get the most recent position change
        });
        return view('employee_position_change.index', compact('positionChange', 'employees', 'category', 'positions', 'latestPositionChanges'));
    }

    //updare and create
    public function store(Request $request) {
        $request->validate([
            'employee_id' => 'required|exists:employees,id', 
            // 'oldPosition' => 'required',
            'newPosition' => 'required|different:oldPosition',
            'date' => 'required|date',
            'note' => 'required',
        ]);

        $position = Position::with('job_title')->find($request->newPosition);
    $section = $position?->job_title?->section;

    if ($section) {
        $formattedId = str_pad($request->employee_id, 3, '0', STR_PAD_LEFT);
        $eid = $section . $formattedId;
    } else {
        \Log::error('Section is null', [
            'newPosition' => $request->newPosition,
            'employeeId' => $request->employee_id,
        ]);
        abort(404, 'Section not found');
    }

    
        // $position = Position::with('job_title')->find($request->newPosition);
        // $section = $position->job_title->section;
        // $formattedId = str_pad($$request->employee_id, 3, '0', STR_PAD_LEFT);
        // $eid = $section . $formattedId;

        $employee = Employee::find($request->employee_id);
        $oldPosition = $employee->position_id;
        $newPosition = $request->newPosition;

        if($oldPosition == $newPosition) {
            return response()->json([
                'success' => false,
                'message' => 'The same position cannot be changed',
            ]);
        } else {
            EmployeePositionChange::updateOrCreate(
                ['id' => $request->id],
                [
                    'employee_id' => $request->employee_id,
                    'old_position' => $oldPosition,
                    'new_position' => $newPosition,
                    'effective_date' => $request->date,
                    'reason' => $request->note,
                    'category' => $request->category,
                ]
            );
    
            // Update employee position
            $employee->update([
                'eid' => $eid,
                'position_id' => $newPosition,
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Position change saved successfully.',
                'redirect' => route('position.change.index')
            ]);
        }
    }

    //delete
    public function delete($id){
        $data = EmployeePositionChange::find($id);               
        $employee = Employee::find($data->employee_id);
        $oldPosition = $data->old_position;
        $employee->update([
            'position_id' => $oldPosition
        ]);
    
        $data->delete();

        
        return response()->json([
            'success' => true,
            'message' => 'Position change deleted successfully.',
            'redirect' => route('position.change.index')
        ]);
    }
    
    
}
