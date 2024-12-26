<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class ResignationController extends Controller
{
//Index
    public function index() {
        $employees = Employee::get();
        $resignEmployees = Employee::whereNotNull('resignation_date')->get();
        $category = [
            'Non Aktif',
            'Mengundurkan Diri',
            'Diberhentikan'
        ];
        return view('resignation.index', compact('employees', 'resignEmployees', 'category'));
    }

//Store
    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'note' => 'required',
            'date' => 'required'
        ]);
        
        $employee = Employee::where('id', $request->name)->first();
        if($employee && $employee->resignation_date !== null) {
            return response()->json([
                'success' => false,
                'message' => 'This employee has already resigned and cannot be added.'
            ]);
        }

        $employee->update([
            'resignation'=> $request->category,
            'resignation_note' => $request->note,
            'resignation_date' => $request->date
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Resiganation saved successfully.',
        ]);
    }

//Update
    public function update(Request $request) {
        $request->validate([
            'name' => 'required|exists:employees,id',
            'category' => 'required',
            'note' => 'required',
            'date' => 'required'
        ]);

        $employee = Employee::find($request->name);
        // if($employee && $employee->resignation_date !== null) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'This employee has already resigned and cannot be added.'
        //     ]);
        // }
           
        $employee->update([
            'resignation'=> $request->category,
            'resignation_note' => $request->note,
            'resignation_date' => $request->date
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Resiganation saved successfully.',
        ]);
    }
    
//Delete
    public function delete($id) {
        $employee = Employee::find($id);
        $employee->update([
            'resignation' => null,
            'resignation_date' => null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Resignation has been deleted.',
            'redirect' => route('resignation.index') 
        ]);
    }
}
