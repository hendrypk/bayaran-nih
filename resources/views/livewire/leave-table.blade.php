

<div class="card-puffy">
    <div class="card-puffy-header">
        <div class="flex flex-col lg:flex-row lg:items-center gap-3 w-full">
            <div class="w-full lg:w-64 flex-shrink-0">
                <x-ui.input-group
                    prefix="mdi:magnify"
                    wire:model.live.debounce.500ms="search"
                    type="text"
                    placeholder="Cari karyawan atau EID..."
                />
                </div>
            <div class="flex-shrink-0 min-w-[260px]" wire:ignore>
                <x-ui.date-range-picker 
                    :startDate="$startDate" 
                    :endDate="$endDate" 
                />
                </div>
            <div class="w-full lg:flex-1">
                <div class="overflow-x-auto scrollbar-hide">
                    <div class="min-w-max">
                        <x-ui.tab 
                            :active="$status"
                            :options="[
                                'all'      => ['label' => 'Semua', 'count' => $statusCounts['all'] ?? 0],
                                'pending'  => ['label' => 'Pending', 'count' => $statusCounts['pending'] ?? 0],
                                'approve' => ['label' => 'Disetujui', 'count' => $statusCounts['approve'] ?? 0],
                                'reject' => ['label' => 'Ditolak', 'count' => $statusCounts['reject'] ?? 0],
                            ]"
                        />
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-pffy-body">
        <div wire:loading class="absolute inset-0 bg-white/50 dark:bg-slate-900/50 z-10 flex items-center justify-center backdrop-blur-[1px]">
            <div class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 rounded-lg shadow-xl border border-slate-100 dark:border-slate-700">
                <svg class="animate-spin h-4 w-4 text-tosca-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                <span class="text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-widest">Memuat...</span>
            </div>
        </div>
        <x-ui.datatable 
            id="leaveTable" 
            :headers="['Karyawan', 'Tanggal', 'Kategori', 'Catatan', 'Status', 'Aksi']"
            :collection="$leaves">

            @forelse($leaves as $leave)
            <tr class="group transition-all border-b border-slate-100 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/50">
                
                {{-- Employee --}}
                <td class="py-4 px-6">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-tosca-100 dark:bg-tosca-900/30 flex items-center justify-center text-[10px] font-black text-tosca-600 border border-tosca-200 dark:border-tosca-800">
                            {{ substr($leave->employee->name, 0, 2) }}
                        </div>
                        <div>
                            <div class="text-sm font-bold text-slate-700 dark:text-slate-200">{{ $leave->employee->name }}</div>
                            <div class="text-[10px] text-slate-400 font-medium tracking-tight">EID: {{ $leave->employee->eid }}</div>
                        </div>
                    </div>
                </td>

                {{-- Dates --}}
                <td class="py-4 px-6 text-sm font-bold text-slate-700 dark:text-slate-200">
                    @if($leave->start_date === $leave->end_date)
                        {{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }}
                    @else
                        <div class="flex flex-col gap-0.5">
                            <span class="text-xs text-slate-400 uppercase font-black tracking-tighter">Mulai - Berakhir</span>
                            <span>{{ \Carbon\Carbon::parse($leave->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}</span>
                        </div>
                    @endif
                </td>

                {{-- Category --}}
                <td class="py-4 px-6">
                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400">
                        {{ ucfirst($leave->category) }}
                    </span>
                </td>

                {{-- Note --}}
                <td class="py-4 px-6 text-xs text-slate-500 max-w-xs truncate">
                    {{ $leave->note ?? '-' }}
                </td>

                {{-- Status --}}
                <td class="py-4 px-6">
                    @php
                        $statusConfig = match($leave->status) {
                            1 => ['bg' => 'bg-emerald-100 text-emerald-700', 'label' => 'Disetujui'],
                            0 => ['bg' => 'bg-rose-100 text-rose-700', 'label' => 'Ditolak'],
                            default => ['bg' => 'bg-amber-100 text-amber-700', 'label' => 'Pending'],
                        };
                    @endphp
                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest {{ $statusConfig['bg'] }}">
                        {{ $statusConfig['label'] }}
                    </span>
                </td>

                {{-- Actions --}}
                <td class="py-4 px-6 text-right">
                    @can('update leave')
                    <x-modal-trigger
                        class="inline-flex items-center p-2 bg-slate-100 text-slate-600 hover:bg-tosca-600 hover:text-white dark:bg-slate-800 dark:text-slate-400 dark:hover:bg-tosca-600 dark:hover:text-white rounded-xl transition-all"
                        modal="leave-manual-modal"
                        :args="['id' => $leave->id]"
                        title="Edit Data Izin/Cuti"
                        size="md">
                        <iconify-icon icon="lucide:edit-3" width="18"></iconify-icon>
                    </x-modal-trigger>
                    @endcan
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="6" class="py-12 text-center">
                    <div class="flex flex-col items-center gap-2">
                        <iconify-icon icon="lucide:clipboard-x" width="48" class="text-slate-200"></iconify-icon>
                        <span class="text-sm font-bold text-slate-400 italic">Tidak ada data izin/cuti ditemukan.</span>
                    </div>
                </td>
            </tr>
            @endforelse
        </x-ui.datatable>
    </div>
</div>