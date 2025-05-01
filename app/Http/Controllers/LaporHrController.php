<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\LaporHr;
use App\Models\LaporHrAttachment;
use App\Models\LaporHrCategory;
use Illuminate\Http\Request;

class LaporHrController extends Controller
{
    public function index() {
        $laporHr = LaporHr::with('attachments')->get();

        $laporHr->map(function ($report) {
            $report->report_attachments = $report->attachments
                ? $report->attachments->where('type', LaporHrAttachment::TYPE_REPORT)->values()
                : collect();
            $report->solve_attachments = $report->attachments
                ? $report->attachments->where('type', LaporHrAttachment::TYPE_SOLVE)->values()
                : collect();
            return $report;
        });
        
        $employees = Employee::get();
        $reportCategory = LaporHrCategory::get();
        $status = ['open' => 'open', 'on progress' => 'on progress', 'close' => 'close', 'rejected' => 'rejected'];
        return view('lapor_hr.index', compact('laporHr', 'employees', 'reportCategory', 'status'));
    }

    public function submit (Request $request) {
        $request->validate([
            // 'report_attachment' => 'required|array',
            // 'report_attachment.*' => 'file|mimes:jpg,jpeg,png,pdf,mp4,mov,avi,mkv|max:5120',
        
            'solve_attachment' => 'nullable|array',
            'solve_attachment.*' => 'file|mimes:jpg,jpeg,png,pdf,mp4,mov,avi,mkv|max:5120',
        ], [
            // 'report_attachment.*.file' => 'Setiap file harus berupa file yang valid.',
            // 'report_attachment.*.mimes' => 'File harus berformat: jpg, jpeg, png, pdf, mp4, mov, avi, atau mkv.',
            // 'report_attachment.*.max' => 'Ukuran maksimal file adalah 5MB.',
        
            'solve_attachment.*.file' => 'Setiap file harus berupa file yang valid.',
            'solve_attachment.*.mimes' => 'File harus berformat: jpg, jpeg, png, pdf, mp4, mov, avi, atau mkv.',
            'solve_attachment.*.max' => 'Ukuran maksimal file adalah 5MB.',
        ]);       

        $laporHr = LaporHr::updateOrCreate(
            ['id' => $request->id],
            [
            // 'employee_id' => $request->employee_id,
            // 'category_id' => $request->report_category,
            // 'report_date' => $request->report_date,
            // 'report_description' => $request->report_description,
            'solve_date' => $request->solve_date,
            'solve_description' => $request->solve_description,
            'status' => $request->status,
        ]);
        if ($request->hasFile('report_attachment')) {
            foreach ($request->file('report_attachment') as $file) {
                $ext = $file->getClientOriginalExtension() ?: 'jpg';
                $filename = time() . '_' . uniqid() . '.' . $ext;
                $path = $file->storeAs('lapor-hr', $filename, 'public');
        
                LaporHrAttachment::create([
                    'lapor_hr_id' => $laporHr->id,
                    'file_path' => $path,
                    'type' => LaporHrAttachment::TYPE_REPORT
                ]);
            }
        }

        if ($request->hasFile('solve_attachment')) {
            foreach ($request->file('solve_attachment') as $file) {
                $ext = $file->getClientOriginalExtension() ?: 'jpg';
                $filename = time() . '_' . uniqid() . '.' . $ext;
                $path = $file->storeAs('lapor-hr', $filename, 'public');
        
                LaporHrAttachment::create([
                    'lapor_hr_id' => $laporHr->id,
                    'file_path' => $path,
                    'type' => LaporHrAttachment::TYPE_SOLVE
                ]);
            }
        }
    
        return redirect()->route('lapor_hr.index')->with('success', 'Lapor HR Successfully Saved.');

    }
}
