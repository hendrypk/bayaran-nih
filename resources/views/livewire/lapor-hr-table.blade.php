<div class="space-y-4">
    {{-- Header & Filters --}}
    <div class="px-4 py-4">
        <div class="flex flex-col lg:flex-row gap-4 justify-between items-end">
            <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
                {{-- Date Range --}}
                <div class="w-full md:w-64"
                    wire:key="picker-{{ $startDate }}-{{ $endDate }}"
                    x-data="{
                        picker: null,
                        init() {
                            this.picker = flatpickr($refs.input, {
                                mode: 'range',
                                dateFormat: 'Y-m-d',
                                defaultDate: ['{{ $startDate }}', '{{ $endDate }}'],
                                onClose: (dates) => {
                                    if(dates.length === 2) {
                                        $wire.setDateRange(
                                            this.picker.formatDate(dates[0], 'Y-m-d'),
                                            this.picker.formatDate(dates[1], 'Y-m-d')
                                        );
                                    }
                                }
                            });
                        }
                    }">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </span>
                        <input x-ref="input" readonly class="w-full pl-9 pr-4 py-2 text-sm border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 focus:ring-2 focus:ring-tosca-500 outline-none cursor-pointer font-bold text-slate-700 dark:text-slate-200">
                    </div>
                </div>

                {{-- Status Filter --}}
                <div class="w-full md:w-44">
                    <select wire:model.live="status" class="w-full px-3 py-2 text-sm border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 focus:ring-2 focus:ring-tosca-500 outline-none cursor-pointer font-bold text-slate-700 dark:text-slate-200">
                        <option value="all">Semua Status</option>
                        <option value="open">Open</option>
                        <option value="on progress">On Progress</option>
                        <option value="close">Close</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>

                {{-- Category Filter --}}
                <div class="w-full md:w-44">
                    <select wire:model.live="category" class="w-full px-3 py-2 text-sm border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 focus:ring-2 focus:ring-tosca-500 outline-none cursor-pointer font-bold text-slate-700 dark:text-slate-200">
                        <option value="all">Semua Kategori</option>
                        @foreach(\App\Models\LaporHrCategory::all() as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Show Per Page --}}
                <div class="w-full md:w-28">
                    <select wire:model.live="perPage" class="w-full px-3 py-2 text-sm border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 font-bold outline-none text-tosca-600 cursor-pointer">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="all">Semua</option>
                    </select>
                </div>
            </div>

            {{-- Search --}}
            <div class="relative w-full lg:w-72">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </span>
                <input wire:model.live.debounce.500ms="search" type="text" placeholder="Cari nama karyawan..." class="w-full pl-9 pr-4 py-2 text-sm border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 focus:ring-2 focus:ring-tosca-500 outline-none text-slate-700 dark:text-slate-200">
            </div>
        </div>
    </div>

    {{-- Datatable Section --}}
    <div class="relative">
        
        {{-- Loading Overlay --}}
        <div wire:loading class="absolute inset-0 bg-white/50 dark:bg-slate-900/50 z-10 flex items-center justify-center backdrop-blur-[1px]">
            <div class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 rounded-lg shadow-xl border border-slate-100 dark:border-slate-700">
                <svg class="animate-spin h-4 w-4 text-tosca-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                <span class="text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-widest">Memuat...</span>
            </div>
        </div>

        <x-ui.datatable 
            id="laporHrTable" 
            :headers="['Tanggal Lapor', 'Karyawan', 'Kategori', 'Deskripsi Laporan', 'Status', 'Tanggal Selesai', 'Lampiran', 'Aksi']"
            :collection="$laporHrs">
            
            @forelse($laporHrs as $data)
                <tr class="group transition-all border-b border-slate-100 dark:border-slate-800 hover:bg-slate-50/30 dark:hover:bg-slate-800/30">
                     
                    <td class="py-4 px-6 text-sm font-bold text-slate-700 dark:text-slate-200">
                        {{ \Carbon\Carbon::parse($data->report_date)->format('d M Y') }}
                    </td>
                    
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-[10px] font-black text-slate-500 border border-slate-200 dark:border-slate-700">
                                {{ substr($data->employee->name, 0, 2) }}
                            </div>
                            <div>
                                <div class="text-sm font-bold text-slate-700 dark:text-slate-200">{{ $data->employee->name }}</div>
                                <div class="text-xs text-slate-400">{{ $data->employee->eid }}</div>
                            </div>
                        </div>
                    </td>
                    
                    <td class="py-4 px-6 text-sm font-semibold text-slate-600 dark:text-slate-300">
                        {{ $data->category->name }}
                    </td>
                    
                    <td class="py-4 px-6 text-sm text-slate-600 dark:text-slate-400 max-w-xs truncate">
                        {{ $data->report_description }}
                    </td>
                    
                    <td class="py-4 px-6">
                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest 
                            {{ $data->status === 'open' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $data->status === 'on progress' ? 'bg-amber-100 text-amber-700' : '' }}
                            {{ $data->status === 'close' ? 'bg-emerald-100 text-emerald-700' : '' }}
                            {{ $data->status === 'rejected' ? 'bg-rose-100 text-rose-700' : '' }}">
                            {{ $data->status }}
                        </span>
                    </td>
                    
                    <td class="py-4 px-6 text-sm text-slate-600 dark:text-slate-300">
                        {{ $data->solve_date ? \Carbon\Carbon::parse($data->solve_date)->format('d M Y') : '-' }}
                    </td>
                    
                    <td class="py-4 px-6">
                        <div class="flex gap-2">
                            @if($data->report_attachments->isNotEmpty())
                                <span class="text-xs text-slate-400">
                                    {{ $data->report_attachments->count() }} Files
                                </span>
                            @endif
                        </div>
                    </td>
                    
                    <td class="py-4 px-6">
                        @can('update leave')
                            <x-modal-trigger
                                class="inline-flex items-center p-1 bg-emerald-100 text-emerald-600 hover:bg-emerald-600 hover:text-white dark:bg-emerald-900/30 dark:text-emerald-400 dark:hover:bg-emerald-600 dark:hover:text-white rounded-lg transition-all"
                                modal="lapor-hr-form"
                                :args="['id' => $data->id]"
                                title="Edit Lapor HR"
                                size="max-w-4xl"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m12 15l8.385-8.415a2.1 2.1 0 0 0-2.97-2.97L9 12v3zm4-10l3 3"/><path d="M9 7.07A7 7 0 0 0 10 21a7 7 0 0 0 6.929-6"/></g></svg>
                            </x-modal-trigger>
                        @endcan                                
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="py-8 text-center text-slate-400">
                        <div class="flex flex-col items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span class="font-bold">Tidak ada data laporan</span>
                        </div>
                    </td>
                </tr>
            @endforelse
        </x-ui.datatable>
    </div>

</div>
