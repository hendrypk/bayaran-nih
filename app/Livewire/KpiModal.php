<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PerformanceKpiName;
use Illuminate\Validation\ValidationException;

class KpiModal extends Component
{
    public $name;
    public $indicators = [];
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

            $kpi = PerformanceKpiName::with('indicators')->findOrFail($id);

            $this->name = $kpi->name;

            $this->indicators = $kpi->indicators->map(function ($item) {
                return [
                    'aspect' => $item->aspect,
                    'description' => $item->description,
                    'target' => $item->target,
                    'weight' => $item->weight,
                ];
            })->toArray();
        } else {
            $this->indicators = [
                ['aspect' => '', 'target' => '', 'weight' => '']
            ];
        }

        $this->calculateTotalWeight();
    }

    public function addIndicator(): void
    {
        $this->indicators[] = ['aspect' => '', 'target' => 0, 'weight' => 0];
    }

    public function removeIndicator(int $index): void
    {
        unset($this->indicators[$index]);
        $this->calculateTotalWeight();
    }

    public function updatedIndicators($value, $key)
    {
        $nestedData = explode('.', $key);
        $index = $nestedData[0];
        $field = $nestedData[1] ?? null;

        if ($field === 'weight') {
            $this->calculateTotalWeight();
        }
    }

    private function calculateTotalWeight(): void
    {
        $totalWeight = 0;

        foreach ($this->indicators as $index => $indicator) {
            if (!isset($this->indicators[$index]['weight']) || !is_numeric($this->indicators[$index]['weight'])) {
                $this->indicators[$index]['weight'] = 0;
            }

            $totalWeight += (float) $this->indicators[$index]['weight'];
        }

        $this->totalWeight = $totalWeight;
    }


    public function rules()
    {
        return [
            'name' => 'required',
            'indicators.*.aspect' => 'required',
            'indicators.*.description' => 'nullable',
            'indicators.*.target' => 'required|numeric',
            'indicators.*.weight' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama KPI wajib diisi.',
            'indicators.*.aspect.required' => 'Semua indikator harus diisi.',
            'indicators.*.target.required' => 'Target wajib diisi.',
            'indicators.*.target.numeric' => 'Target harus berupa angka.',
            'indicators.*.weight.required' => 'Weight wajib diisi.',
            'indicators.*.weight.numeric' => 'Weight harus berupa angka.',
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
            $kpi = PerformanceKpiName::findOrFail($this->editingId);
            $kpi->update(['name' => $this->name]);
            $kpi->indicators()->delete(); 
        } else {
            $kpi = PerformanceKpiName::create(['name' => $this->name]);
        }

        foreach ($this->indicators as $item) {
            $kpi->indicators()->create($item);
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
            $kpi = PerformanceKpiName::findOrFail($id);
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
        return view('livewire.kpi-modal');
    }
}

