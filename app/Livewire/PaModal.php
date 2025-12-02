<?php

namespace App\Livewire;

use App\Models\PerformanceAppraisalName;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class PaModal extends Component
{
    public $name;
    public $appraisals = [];
    public $isEditing = false;
    public $editingId;
    public $errorText = '';
    public $totalWeight= 0;

    protected $listeners = ['delete'];

    public function mount($id = null)
    {
        if ($id) {
            $this->isEditing = true;
            $this->editingId = $id;

            $kpi = PerformanceAppraisalName::with('appraisals')->findOrFail($id);

            $this->name = $kpi->name;

            $this->appraisals = $kpi->appraisals->map(function ($item) {
                return [
                    'aspect' => $item->aspect,
                    'description' => $item->description,
                ];
            })->toArray();
        } else {
            $this->appraisals = [
                ['aspect' => '', 'description' => '', 'target' => '', 'weight' => '']
            ];
        }
    }

    public function addAppraisal(): void
    {
        $this->appraisals[] = ['aspect' => '', 'description' => '', 'target' => 0, 'weight' => 0];
    }

    public function removeAppraisal(int $index): void
    {
        unset($this->appraisals[$index]);
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'appraisals.*.aspect' => 'required',
            'appraisals.*.description' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama KPI wajib diisi.',
            'appraisals.*.aspect.required' => 'Semua indikator harus diisi.',
        ];
    }

    public function save()
    {
        try {
            $this->validate();

            if($this->totalWeight > 100) {
                $this->dispatch('swal:error', message: 'Total Bobot Tidak Boleh Lebih Dari 100');
                return;
            }
        } catch (ValidationException $e) {
            $errorText = implode("\n", collect($e->errors())->flatten()->toArray());
            $this->dispatch('swal:error', message: $errorText);
            return;
        }

        if ($this->isEditing) {
            $kpi = PerformanceAppraisalName::findOrFail($this->editingId);
            $kpi->update(['name' => $this->name]);
            $kpi->appraisals()->delete(); 
        } else {
            $kpi = PerformanceAppraisalName::create(['name' => $this->name]);
        }

        foreach ($this->appraisals as $item) {
            $kpi->appraisals()->create($item);
        }

        $this->dispatch('closeModal');
        $this->dispatch('customer-updated');
        $this->dispatch('swal:success', [
            'message' => 'Kpi Berhasil Disimpan...'
        ]);
    }


    public function delete($id = null)
    {
        $id = $id ?? $this->editingId;

        if (!$id) {
            $this->dispatch('swal:error', ['message' => 'Tidak ada data untuk dihapus']);
            return;
        }

        try {
            $kpi = PerformanceAppraisalName::findOrFail($id);
            $kpi->delete();

            $this->dispatch('closeModal');
            $this->dispatch('customer-updated');
            $this->dispatch('swal:success', ['message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            $this->dispatch('swal:error', ['message' => 'Gagal menghapus data: '.$e->getMessage()]);
        }
    }
    
    public function render()
    {
        return view('livewire.pa-modal');
    }
}
