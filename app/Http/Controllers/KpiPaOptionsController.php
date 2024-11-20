<?php

namespace App\Http\Controllers;

use App\Models\KpiAspect;
use App\Models\Performance;
use Illuminate\Http\Request;
use App\Models\PerformanceKpi;
use App\Models\PerformanceAppraisal;
use App\Models\Position;

use function PHPUnit\Framework\isEmpty;

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
        'indicators.*.target' => 'required',
        'indicators.*.bobot' => 'required',
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
    // $kpi_aspect = KpiAspect::with('kpis')->get();
    $indicators = PerformanceKpi::where('kpi_id', $kpi_id)->get();
    $totalBobot = $indicators->sum('bobot');
    $kpi_id = KpiAspect::where('id', $kpi_id)->first();
    $name = $kpi_id->name;
   
    return view('performance.options.kpi-detail', compact('indicators', 'totalBobot', 'kpi_id', 'name'));
}


//indicator update
public function indicatorUpdate(Request $request, $kpi_id) {
    $validatedData = $request->validate([
        'indicators' => 'required|array',  
        'indicators.*.id' => 'nullable|exists:performance_kpis,id', 
        'indicators.*.aspect' => 'required|string|max:255',
        'indicators.*.target' => 'required', 
        'indicators.*.bobot' => 'required|min:0|max:100', 
    ]);
    
    foreach ($validatedData['indicators'] as $indicator) {
        if (isset($indicator['id'])) {
        // Update existing aspect
            $existingIndicator = PerformanceKpi::find($indicator['id']);
            if ($existingIndicator) {
                $existingIndicator->update([
                    'aspect' => $indicator['aspect'],
                    'target' => $indicator['target'],
                    'bobot' => $indicator['bobot']
                ]);
            }
        } else {
            // Add new aspect
            PerformanceKpi::create([
                'kpi_id' => $kpi_id,
                'aspect' => $indicator['aspect'],
                'target' => $indicator['target'],
                'bobot' => $indicator['bobot']
            ]);
        }
    }    
    return redirect()->route('indicator.detail', $kpi_id)->with('success', 'KPI updated successfully');
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

//Indicator Delete
public function aspectDelete($id){
    $indicators = PerformanceKpi::where('id', $id);
    $indicators->delete();
    
    return response()->json([
        'success' => true,
        'message' => 'The aspect has been deleted.',
        'redirect' => back()
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
