<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{

//Index
    function index(Request $request){
        $employees = Employee::where('sales_status', '1')->get();
        $sales = Sales::with('employees')
            ->select('month', 'year', DB::raw('SUM(qty) as Qty'))
            ->groupBy('month', 'year')
            ->get();
            
        $month = $request->month;

        $selectedMonth = $request->input('month', date('F'));
        $selectedYear = $request->input('year', date('Y'));  
        
        $salesData = Sales::select('month', DB::raw('SUM(qty) as total_qty'))
        ->groupBy('month')
        ->get();

    $chartData = [
        'month' => $salesData->pluck('month'),
        'total_qty' => $salesData->pluck('total_qty') 
    ];

        return view('sales.index', compact('employees', 'sales', 'month', 'selectedMonth', 'selectedYear', 'salesData', 'chartData'));
    }

//Create
    function create(Request $request){
        $sales = $request->input('sales');
        $month = $request->month;
        $year = $request->year;

        foreach($sales as $sale){
            $employee_id = $sale['employee_id'];
            $qty = $sale['qty'];

            Sales::create([
                'month'=>$month,
                'year'=>$year,
                'employee_id'=>$employee_id,
                'qty'=>$qty,
            ]);
        }
        return redirect()->route('sales.list');
    }

//Sales Detail
    function detail(Request $request, $month, $year){
        $sales = Sales::with('employees')
            ->where('month', $month)
            ->where('year', $year)    
            ->get();
        $total = $sales->sum('qty');
        return view('sales.detail', compact('sales','total', 'month', 'year'));
    }

//Sales Edit
public function edit(Request $request, $month = null, $year = null){
    $employees = Employee::where('sales_status', '1')->get();
    $sales = Sales::with('employees')
        ->where('month', $month)
        ->where('year', $year)
        ->get();
    return view('sales.edit', compact('employees', 'sales', 'month', 'year'));
}

//Sales Update
function update(Request $request){
    $sales = $request->input('sales');
    $month = $request->month;
    $year = $request->year;
        // Hapus semua record penjualan untuk bulan dan tahun yang sama
        Sales::where('month', $month)
        ->where('year', $year)
        ->delete();

    // Tambahkan record penjualan baru
    foreach($sales as $sale) {
        $employee_id = $sale['employee_id'];
        $qty = $sale['qty'];

        $newSale = new Sales();
        $newSale->employee_id = $employee_id;
        $newSale->month = $month;
        $newSale->year = $year;
        $newSale->qty = $qty;
        $newSale->save();
    }
    return redirect()->route('sales.detail', [$month, $year]);
}


//Sales Delete
public function delete($month, $year){
    
    $sales = Sales::where('month', $month)
                             ->where('year', $year)
                             ->get();

    if ($sales->isEmpty()) {
        return redirect()->route('sales.list')->with('error', 'No records found for deletion.');
    }
    foreach ($sales as $record) {
        $record->delete();
    }
    return redirect()->route('sales.list')->with('success', 'Records deleted successfully.');
}

}
