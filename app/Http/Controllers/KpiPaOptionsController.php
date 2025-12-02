<?php

namespace App\Http\Controllers;

use App\Models\AppraisalName;
use App\Models\KpiAspect;
use App\Models\Performance;
use Illuminate\Http\Request;
use App\Models\PerformanceKpi;
use App\Models\PerformanceAppraisal;
use App\Models\PerformanceKpiName;
use App\Models\Position;

use function PHPUnit\Framework\isEmpty;

class KpiPaOptionsController extends Controller
{

//Index
    function index(){
        $positions = Position::get();
        $indicators = PerformanceKpi::select('kpi_id')->groupBy('kpi_id')->get(); 
        $kpi_id = KpiAspect::with('kpis')->get();
        $appraisals = PerformanceAppraisal::select('appraisal_id')->groupBy('appraisal_id')->get();
        $appraisal_id = AppraisalName::get();
        return view('performance.options.index', compact('positions', 'indicators', 'appraisals', 'kpi_id', 'appraisal_id'));
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
        'name' => 'required|string',
        'indicators' => 'required|array',  
        'indicators.*.id' => 'nullable|exists:performance_kpis,id', 
        'indicators.*.aspect' => 'required|string|max:255',
        'indicators.*.target' => 'required', 
        'indicators.*.bobot' => 'required|min:0|max:100', 
    ]);
    
    $kpi_name = KpiAspect::where('id', $kpi_id);
    if($kpi_name) {
        $kpi_name->update([
            'name' => $request->name
        ]);
    }

    $indicators = $request->input('indicators');

    foreach ($indicators as $indicator) {
        $id = $indicator['id'];
        $aspect = $indicator['aspect'];
        $target = $indicator['target'];
        $bobot = $indicator['bobot'];

        PerformanceKpi::updateOrCreate(
            ['id' => $indicator['id']],
            [
                'kpi_id' => $kpi_id,
                'aspect' => $aspect,
                'target' => $target,
                'bobot' => $bobot
            ]
        );
    }

    // foreach ($validatedData['indicators'] as $indicator) {
    //     if (isset($indicator['id'])) {
    //     // Update existing aspect
    //         $existingIndicator = PerformanceKpi::find($indicator['id']);
    //         if ($existingIndicator) {
    //             $existingIndicator->update([
    //                 'aspect' => $indicator['aspect'],
    //                 'target' => $indicator['target'],
    //                 'bobot' => $indicator['bobot']
    //             ]);
    //         }
    //     } else {
    //         // Add new aspect
    //         PerformanceKpi::create([
    //             'kpi_id' => $kpi_id,
    //             'aspect' => $indicator['aspect'],
    //             'target' => $indicator['target'],
    //             'bobot' => $indicator['bobot']
    //         ]);
    //     }
    // }    
    return redirect()->route('indicator.detail', $kpi_id)->with('success', 'KPI updated successfully');
}

//Indicator Delete
public function indicatorDelete($id){

    $kpi = PerformanceKpiName::find($id);

    if (!$kpi) {
        return; // atau throw error
    }

    $kpi->indicators()->delete(); // hapus semua indikator terkait
    
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

// Add Appraisal Modal
    public function addAppraisalForm() {
        return view('performance.options.pa-add');
    }

// Add Appraisal
    function appraisalAdd(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'appraisals' => 'required|array',
            'appraisals.*.aspect' => 'required|string',
        ]);

        $appraisal_name = AppraisalName::create([
            'name' => $request->name
        ]);

        $appraisal_id = AppraisalName::where('name', $request->name)->value('id');
        $appraisals = $request->input('appraisals');

        foreach ($appraisals as $appraisal) {
            if (isset($appraisal['aspect'])) {
                PerformanceAppraisal::create([
                    'appraisal_id' => $appraisal_id,
                    'aspect' => $appraisal['aspect'],
                ]);
            }
        }
        return redirect()->route('kpi.pa.options.index')->with('success', 'Appraisal data added successfully!');
    }

//Detail Appraisal
    public function appraisalDetail($appraisal_id) {
        $appraisals = PerformanceAppraisal::where('appraisal_id', $appraisal_id)->get();
        $appraisal_id = AppraisalName::where('id', $appraisal_id)->first();
        $name = $appraisal_id->name;

        return view('performance.options.pa-detail', compact('appraisals', 'appraisal_id', 'name'));
    }

//Update Appraisal
    function appraisalUpdate(Request $request, $appraisal_id){
        $request->validate([
            'name' => 'required|string',
            'appraisals' =>  'required|array',
            'appraisals.*.aspect' => 'required|string',
        ]);
        
        $appraisal_name = AppraisalName::where('id', $appraisal_id);
        if($appraisal_name) {
            $appraisal_name->update([
                'name' => $request->name
            ]);
        }

        $appraisals = $request->input('appraisals');
        foreach ($appraisals as $appraisal) {
            PerformanceAppraisal::updateOrCreate(
                ['id' => $appraisal['id'] ?? null], // Cari berdasarkan ID, jika tidak ada ID akan cari berdasarkan null
                [
                    'appraisal_id' => $appraisal_id, 
                    'aspect' => $appraisal['aspect']
                ]
            );
        }

        return redirect()->route('appraisal.detail', $appraisal_id)->with('success', 'Appraisal updated successfully');
    }

    // function appraisalAdd(Request $request){
    //     $appraisal = new PerformanceAppraisal();
    //     $appraisal->id = $request->id; // Ensure this ID is unique and valid
    //     $appraisal->name = $request->name;
    //     $appraisal->save();
    //     return redirect()->route('kpi.pa.options.index')->with('success', ' ');
    // }

// Edit Appraisal 
    // function appraisalEdit($id){
    //     $appraisal = PerformanceAppraisal::findOrFail($id);
    //     return view('appraisal.edit', compact('appraisal'));
    // }

    // function appraisalUpdate(Request $request, $id){
    //     $appraisal = PerformanceAppraisal::findOrFail($id);
    //     $request->validate([
    //         'name'=> 'string',
    //     ]);
    //     $appraisal->name = $request->name;
    //     $appraisal->save();
    //     return redirect()->route('kpi.pa.options.index')->with('success', ' ');
    // }

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
