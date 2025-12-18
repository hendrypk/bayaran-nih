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
    public function export(Request $request) {
        $startDate = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
        $endDate   = $request->end_date ?? now()->format('Y-m-d');
        $status    = $request->status;
        // dd($status);
        try {
            $formattedStartDate = Carbon::parse($startDate)->format('Y-m-d');
            $formattedEndDate   = Carbon::parse($endDate)->format('Y-m-d');

            $fileName = "presence_{$formattedStartDate}_to_{$formattedEndDate}.xlsx";

            return Excel::download(new PresencesExport($formattedStartDate, $formattedEndDate, $status), $fileName);
        } catch (\InvalidArgumentException $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

}


