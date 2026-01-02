<div class="space-y-4">
    {{-- Header & Filters --}}
    <div class="px-4 py-4">
        <div class="flex flex-col lg:flex-row gap-4 justify-between items-end">
            <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
                
                {{-- Month & Year Picker (Custom Component) --}}
                <div class="w-full md:w-auto">
                     <x-month-year-picker :action="route('pa.list')" :selectedMonth="$selectedMonth" :selectedYear="$selectedYear"/>
                </div>

                {{-- Show Per Page --}}
                <div class="w-full md:w-28">
                    <select wire:model.live="perPage" class="w-full px-3 py-2 text-sm border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 font-bold outline-none text-tosca-600 cursor-pointer">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
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
            id="paTable" 
            :headers="['Karyawan', 'Periode', 'Jenis Appraisal', 'Grade', 'Input Oleh', 'Aksi']"
            :collection="$appraisals">
            
            @forelse($appraisals as $pa)
                <tr 
                    @click="showDetail = true; selectedPA = {{ $pa->load('details', 'employees', 'appraisalName') }}" 
                    class="group transition-all border-b border-slate-100 dark:border-slate-800 hover:bg-tosca-50/30 dark:hover:bg-tosca-900/10 cursor-pointer">
                     
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-[10px] font-black text-tosca-600 border border-slate-200 dark:border-slate-700 uppercase">
                                {{ substr($pa->employees->name, 0, 2) }}
                            </div>
                            <div class="text-sm font-bold text-slate-700 dark:text-slate-200">{{ $pa->employees->name }}</div>
                        </div>
                    </td>

                    <td class="py-4 px-6 text-sm font-bold text-slate-600 dark:text-slate-400">
                        {{ DateTime::createFromFormat('!m', $pa->month)->format('F') }} {{ $pa->year }}
                    </td>

                    <td class="py-4 px-6 text-sm text-slate-700 dark:text-slate-300">
                        {{ $pa->appraisalName->name ?? '-' }}
                    </td>

                    <td class="py-4 px-6">
                        <span class="px-3 py-1 rounded-lg text-sm font-black bg-tosca-100 text-tosca-700 dark:bg-tosca-900/30 dark:text-tosca-400">
                            {{ $pa->grade }}
                        </span>
                    </td>

                    <td class="py-4 px-6 text-xs text-slate-400 italic">
                        {{ $pa->creator->name ?? 'System' }}
                    </td>

                    <td class="py-4 px-6 text-right">
                        @can('update kpi')
                        <div @click.stop>
                            <x-modal-trigger
                                class="inline-flex items-center p-2 bg-amber-100 text-amber-600 hover:bg-amber-600 hover:text-white dark:bg-amber-900/30 dark:text-amber-400 dark:hover:bg-amber-600 dark:hover:text-white rounded-xl transition-all"
                                modal="pa-form"
                                :args="['paId' => $pa->id]"
                                title="Edit Appraisal"
                                size="xl">
                                <iconify-icon icon="lucide:edit-3" width="18"></iconify-icon>
                            </x-modal-trigger>
                        </div>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="py-10 text-center text-slate-400 italic">Tidak ada data appraisal ditemukan.</td>
                </tr>
            @endforelse
        </x-ui.datatable>
    </div>
    
    <div class="mt-4 px-4">
        {{ $appraisals->links() }}
    </div>
</div>