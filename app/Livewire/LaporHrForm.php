<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Employee;
use App\Models\LaporHr;
use App\Models\LaporHrCategory;
use App\Models\LaporHrAttachment;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class LaporHrForm extends Component
{
    use WithFileUploads;

    public $laporHrId;
    public $employeeId;
    public $categoryId;
    public $reportDate;
    public $reportDescription;
    public $solveDate;
    public $solveDescription;
    public $status = 'open';

    // File Uploads
    public $reportAttachments = [];
    public $solveAttachments = [];

    // Existing Attachments (for display/delete)
    public $existingReportAttachments = [];
    public $existingSolveAttachments = [];

    public $isEditing = false;
    public $employees = [];
    public $categories = [];

    protected function rules()
    {
        return [
            'employeeId' => 'required|exists:employees,id',
            'categoryId' => 'required|exists:lapor_hr_categories,id',
            'reportDate' => 'required|date',
            'reportDescription' => 'required|string',
            'solveDate' => 'nullable|date',
            'solveDescription' => 'nullable|string',
            'status' => 'required|in:open,on progress,close,rejected',
            'reportAttachments.*' => 'nullable|file|max:10240', // 10MB max
            'solveAttachments.*' => 'nullable|file|max:10240',
        ];
    }

    public function mount($id = null)
    {
        $this->employees = Employee::orderBy('name')->get()->map(function ($emp) {
            return ['id' => $emp->id, 'name' => $emp->name . ' - ' . $emp->eid];
        })->toArray();

        $this->categories = LaporHrCategory::all()->toArray();
        $this->reportDate = now()->format('Y-m-d');

        if ($id) {
            $this->isEditing = true;
            $this->loadLaporHr($id);
        }
    }

    public function loadLaporHr($id)
    {
        $laporHr = LaporHr::with('attachments')->findOrFail($id);

        $this->laporHrId = $laporHr->id;
        $this->employeeId = $laporHr->employee_id;
        $this->categoryId = $laporHr->category_id;
        $this->reportDate = $laporHr->report_date;
        $this->reportDescription = $laporHr->report_description;
        $this->solveDate = $laporHr->solve_date;
        $this->solveDescription = $laporHr->solve_description;
        $this->status = $laporHr->status;

        $this->existingReportAttachments = $laporHr->attachments->where('type', LaporHrAttachment::TYPE_REPORT);
        $this->existingSolveAttachments = $laporHr->attachments->where('type', LaporHrAttachment::TYPE_SOLVE);
    }

    public function save()
    {
        $this->validate();

        $data = [
            'employee_id' => $this->employeeId,
            'category_id' => $this->categoryId,
            'report_date' => $this->reportDate,
            'report_description' => $this->reportDescription,
            'solve_date' => $this->solveDate,
            'solve_description' => $this->solveDescription,
            'status' => $this->status,
        ];

        if ($this->isEditing) {
            $laporHr = LaporHr::findOrFail($this->laporHrId);
            $laporHr->update($data);
            $message = 'Laporan berhasil diperbarui.';
        } else {
            $laporHr = LaporHr::create($data);
            $message = 'Laporan berhasil dibuat.';
        }

        // Handle File Uploads
        $this->saveAttachments($laporHr, $this->reportAttachments, LaporHrAttachment::TYPE_REPORT);
        $this->saveAttachments($laporHr, $this->solveAttachments, LaporHrAttachment::TYPE_SOLVE);

        $this->dispatch('refreshTable');
        $this->dispatch('close-modal');
        $this->dispatch('swal:success', message: $message);
    }

    private function saveAttachments($laporHr, $files, $type)
    {
        foreach ($files as $file) {
            $ext = $file->getClientOriginalExtension() ?: 'jpg';
            $filename = time() . '_' . uniqid() . '.' . $ext;
            $path = $file->storeAs('lapor-hr', $filename, 'public');

            LaporHrAttachment::create([
                'lapor_hr_id' => $laporHr->id,
                'file_path' => $path,
                'type' => $type
            ]);
        }
    }

    public function deleteAttachment($attachmentId)
    {
        $attachment = LaporHrAttachment::findOrFail($attachmentId);

        // Delete file from storage
        if (Storage::disk('public')->exists($attachment->file_path)) {
            Storage::disk('public')->delete($attachment->file_path);
        }

        $attachment->delete();

        // Refresh existing attachments list
        if ($this->isEditing) {
            $this->loadLaporHr($this->laporHrId);
        }
    }

    public function delete($id)
    {
        if (!$id)
            return;

        $laporHr = LaporHr::findOrFail($id);
        $laporHr->delete();

        $this->dispatch('refreshTable');
        $this->dispatch('close-modal');
        $this->dispatch('swal:success', message: 'Laporan berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.lapor-hr-form');
    }
}
