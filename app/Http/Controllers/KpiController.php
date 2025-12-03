<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\PerformanceKpiResult;

class KpiController extends Controller
{

//KPI Index
public function index(Request $request){
    $selectedMonth = $request->input('month', date('F'));
    $selectedYear = $request->input('year', date('Y'));    
    return view('performance.kpi.index', compact('selectedMonth', 'selectedYear'));
}

//Kpi Add
public function create(){
    return view('performance.kpi.add', [
        'isEditing' => false,
    ]);
}

public function edit($id){
    return view('performance.kpi.add', [
        'id' => $id,
        'isEditing' => true,
    ]);
}

//KPI Detail
public function detail($id)
{
    $kpi = PerformanceKpiResult::with('employees', 'details')->findOrFail($id);
    $employee = Employee::findOrFail($kpi->employee_id);
    return view('performance.kpi.detail', compact('kpi', 'employee'));
}

public function delete($id)
{
    $kpi = PerformanceKpiResult::with('details', 'employees')->findOrFail($id);
    if(!$kpi) {
        return response()->json([
            'success' => false,
            'message' => 'Kpi Tidak Ditemukan',
        ]);
        return;
    }

    $kpi->details()->delete();
    $kpi->delete();
    return response()->json([
        'success' => true,
        'message' => 'KPI berhasil dihapus',
        'redirect' => route('kpi.list')
    ]);
}

}
