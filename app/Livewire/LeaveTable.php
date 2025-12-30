<?php

namespace App\Livewire;

use App\Models\Leave;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class LeaveTable extends Component
{
    use WithPagination;

    // Filter Properties
    public $search = '';
    public $status = ''; // null, 0, atau 1
    public $category = '';
    public $perPage = 10;
    
    public $startDate;
    public $endDate;

    // Listener agar tabel refresh saat modal selesai simpan data
    protected $listeners = ['refreshLeaveTable' => '$refresh'];

    public function mount()
    {
        // Default: Tampilkan data sebulan terakhir
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function setDateRange($start, $end)
    {
        $this->startDate = $start;
        $this->endDate = $end;
        $this->resetPage();
    }

    public function updated($property)
    {
        // Reset ke halaman 1 setiap kali filter berubah
        if (in_array($property, ['search', 'status', 'category', 'perPage'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $leaves = Leave::query()
            ->with('employee') // Eager load untuk performa
            ->when($this->search, function($q) {
                $q->whereHas('employee', function($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('eid', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->category, function($q) {
                $q->where('category', $this->category);
            })
            ->when($this->status !== '', function($q) {
                $q->where('status', $this->status);
            })
            ->where(function($q) {
                // Filter tanggal: mencari data yang beririsan dengan range yang dipilih
                $q->whereBetween('start_date', [$this->startDate, $this->endDate])
                  ->orWhereBetween('end_date', [$this->startDate, $this->endDate]);
            })
            ->latest('start_date')
            ->paginate($this->perPage === 'all' ? Leave::count() : $this->perPage);

        return view('livewire.leave-table', [
            'leaves' => $leaves
        ]);
    }
}