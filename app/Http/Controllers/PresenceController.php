<?php

namespace App\Http\Controllers;

use App\DataTables\PresencesDataTable;
use Carbon\Carbon;
use App\Models\WorkDay;
use App\Models\Employee;
use App\Models\Overtime;
use App\Models\Presence;
use App\Models\WorkSchedule;
use Illuminate\Http\Request;
use App\Imports\PresenceImport;
use App\Exports\PresencesExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TemplateExportPresence;
use App\Models\WorkScheduleGroup;
use App\Services\PresenceService;
use Illuminate\Cache\RedisTagSet;

class PresenceController extends Controller
{
    protected $presenceService;

    public function __construct(PresenceService $presenceService)
    {
        $this->presenceService = $presenceService;
    }


//Presences List
    public function index(PresencesDataTable $dt){
        if (request()->ajax()) {
            return $dt->ajax();
        }
        $p = $dt->html();
        return view('presence.index', compact('p'));
    }

    //Import Prresences
    public function import(){
        return view('presence.import');
    }

    //import template
    public function template() {
        return Excel::download(new TemplateExportPresence, 'template_import.xlsx');
    }
    
    public function importStore(Request $request)
    {
        // Validasi file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        // Proses impor
        $import = new PresenceImport();
        Excel::import($import, $request->file('file'));

        // Dapatkan error dari import
        $errors = $import->getErrors();

        // Redirect dengan error jika ada
        if (!empty($errors)) {
            return redirect()->back()->withErrors(['import_errors' => $errors]);
        }

        return redirect()->back()->with('success', 'Data presensi berhasil diimpor.');
    }

//Presences Export
public function export(Request $request) 
{
    // Use input() or query() to avoid Symfony 7.4 deprecation
    $startDate = $request->input('start_date') ?: now()->startOfMonth()->format('Y-m-d');
    $endDate   = $request->input('end_date') ?: now()->format('Y-m-d');
    $status    = $request->input('status', 'presence');
    $search    = $request->input('search');

    try {
        $fileName = "presence_export_" . now()->format('Ymd_His') . ".xlsx";

        return Excel::download(
            new PresencesExport(
                $startDate, 
                $endDate, 
                $status, 
                Auth::user(), 
                $search
            ), 
            $fileName
        );
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => 'Export failed: ' . $e->getMessage()]);
    }
}

}


