<?php

namespace App\Http\Controllers;

use App\Models\KpiAspect;
use App\Models\Performance;
use Illuminate\Http\Request;
use App\Models\PerformanceKpi;
use App\Models\PerformanceAppraisal;
use App\Models\Position;

class KpiPaOptionsController extends Controller
{

//Index
    function index(){
        $positions = Position::get();
        $indicators = PerformanceKpi::select('kpi_id')->groupBy('kpi_id')->get(); 
        $kpi_id = KpiAspect::with('kpis')->get();
        $appraisals = PerformanceAppraisal::get();
        return view('performance.options.index', compact('positions', 'indicators', 'appraisals', 'kpi_id'));
    }

//Indicator Add
function indicatorAdd(Request $request){
    $request->validate([
        'name' => 'required|string',
        'indicators.*.aspect' => 'required|string',
        'indicators.*.target' => 'required|integer',
        'indicators.*.bobot' => 'required|integer',
    ]);

    $kpi_name = KpiAspect::create([
        'name' => $request->name
    ]);

    $kpi_id = KpiAspect::where('name', $request->name)->value('id');

    $indicators = $request->input('indicators');

    foreach ($indicators as $indicator) {
        $aspect = $indicator['aspect'];
        $target = $indicator['target'];
        $bobot = $indicator['bobot'];
        $performanceKpi = PerformanceKpi::create([
            'kpi_id' => $kpi_id,
            'aspect' => $aspect,
            'target' => $target,
            'bobot' => $bobot,    
        ]);
    }
    return redirect()->route('kpi.pa.options.index')->with('success', 'KPI Successfully Added.');
}

//Indicator Detail
public function indicatorDetail($kpi_id)
{
    $kpi_aspect = KpiAspect::with('kpis')->get();
    $indicators = PerformanceKpi::where('kpi_id', $kpi_id)->get();
    $totalBobot = $indicators->sum('bobot');
    $kpi_id = KpiAspect::where('id', $kpi_id)->get();
    
    if ($indicators->isEmpty()) {
        return redirect()->route('kpi.pa.options.index')->with('error', 'No indicators found for the selected name.');
    }

    $totalBobot = $indicators->sum('bobot');

    return view('performance.options.kpi-detail', compact('kpi_aspect', 'indicators', 'totalBobot', 'kpi_id', 'totalBobot'));
}


//indicator update
    function indicatorUpdate(Request $request, $position_id) {
        $indicators = $request->input('indicators', []);
        $existingIds = array_filter(array_column($indicators, 'id')); // Extract existing ids from form data

        // Delete any indicators that were removed
        foreach ($indicators as $indicator) {
            $name = $indicator['name'];
            $target = $indicator['target'];
            $bobot = $indicator['bobot'];

            KpiPaOptionsController::create([
                'name' => $name,
                'position_id' => $position_id,
                'target' => $target,
                'bobot' => $bobot,
            ]);
        }
        return redirect()->route('indicator.detail', $position_id)->with('success', 'Indikator KPI berhasil di-update.');
    }

//Indicator Delete
public function indicatorDelete($id){
    $indicators = PerformanceKpi::where('kpi_id', $id);
    $indicators->delete();

    $kpi_id = KpiAspect::findOrFail($id);
    $kpi_id->delete();
    
    return response()->json([
        'success' => true,
        'message' => 'The appraisal has been deleted.',
        'redirect' => route('kpi.pa.options.index')
    ]);
}

// Add Appraisal
    function appraisalAdd(Request $request){
        $appraisal = new PerformanceAppraisal();
        $appraisal->id = $request->id; // Ensure this ID is unique and valid
        $appraisal->name = $request->name;
        $appraisal->save();
        return redirect()->route('kpi.pa.options.index')->with('success', ' ');
    }

// Edit Appraisal 
    function appraisalEdit($id){
        $appraisal = PerformanceAppraisal::findOrFail($id);
        return view('appraisal.edit', compact('appraisal'));
    }

    function appraisalUpdate(Request $request, $id){
        $appraisal = PerformanceAppraisal::findOrFail($id);
        $request->validate([
            'name'=> 'string',
        ]);
        $appraisal->name = $request->name;
        $appraisal->save();
        return redirect()->route('kpi.pa.options.index')->with('success', ' ');
    }

//Delete Appraisal
    public function appraisalDelete($id){
        $appraisal = PerformanceAppraisal::findOrFail($id);
        $appraisal->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'The appraisal has been deleted.',
            'redirect' => route('kpi.pa.options.index')
        ]);
    }

}
