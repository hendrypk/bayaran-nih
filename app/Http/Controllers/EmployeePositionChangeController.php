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
    
        $employee = Employee::find($request->employee_id);
        $oldPosition = $employee->position_id;
        $newPosition = $request->newPosition;

        
        switch (true) {
            case ($oldPosition == $newPosition):
                return response()->json([
                    'success' => false,
                    'message' => 'The same position cannot be changed',
                ]);
        
            case (!$employee):
                return response()->json([
                    'success' => false,
                    'message' => 'Employee not found.'
                ]);
        
            default:
                // Proceed with the position change
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
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found.'
            ], 404);
        }

        $allChanges = EmployeePositionChange::where('employee_id', $data->employee_id)
            ->whereNull('deleted_at')
            ->orderBy('effective_date', 'desc') 
            ->get();
        $lastChange = $allChanges->first()->id;

        if ($lastChange !== $id) {
            return response()->json([
                'success' => false,
                'message' => 'Only the most recent position change can be deleted.'
            ]); 
        }
            
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
