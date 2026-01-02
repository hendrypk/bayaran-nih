<div class="card-puffy">
    <div class="card-puffy-header">
        <div class="flex flex-col lg:flex-row lg:items-center gap-3 w-full">

            <div class="w-full lg:w-64 flex-shrink-0">
                <x-ui.input-group
                    prefix="mdi:magnify"
                    wire:model.live.debounce.500ms="search"
                    type="text"
                    placeholder="Cari sesuatu di sini..."
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
                                'presence' => ['label' => 'Hadir', 'count' => $this->statusCounts['presence']],
                                'absence'  => ['label' => 'Alpa',  'count' => $this->statusCounts['absence']],
                                'permit'   => ['label' => 'Ijin',  'count' => $this->statusCounts['permit']],
                                'sick'     => ['label' => 'Sakit', 'count' => $this->statusCounts['sick']],
                                'leave'    => ['label' => 'Cuti',  'count' => $this->statusCounts['leave']],
                            ]"
                        />
                    </div>
                </div>
            </div>

        </div>

        
        <div class="flex items-center gap-3 w-full lg:w-auto justify-end">
            <x-action-button 
                type="download" 
                modal="coming-soon" 
                />
            <x-action-button 
                type="import" 
                modal="coming-soon" 
                />
            @can('create presence')
                <x-action-button 
                    type="add" 
                    label="Presensi" 
                    modal="presence-manual-modal"
                    modalTitle="Tambah Presensi" 
                    />
            @endcan
        </div>
    </div>

    <div class="card-puffy-body">
        <div wire:loading class="absolute inset-0 bg-white/50 dark:bg-slate-900/50 z-10 flex items-center justify-center backdrop-blur-[1px]">
            <div class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 rounded-lg shadow-xl border border-slate-100 dark:border-slate-700">
                <svg class="animate-spin h-4 w-4 text-tosca-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                <span class="text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-widest">Memuat...</span>
            </div>
        </div>


        {{-- <div 
            x-data="presenceDetailMap" 
            class="flex flex-col lg:flex-row gap-6 px-4 pb-10 items-start"> --}}
        <div x-data="showMap('presence')" x-cloak class="flex flex-col lg:flex-row gap-6 px-4 pb-10 items-start">
            <div 
                :class="active ? 'lg:w-3/4' : 'w-full'" 
                class="transition-all duration-500 ease-in-out">

                <x-ui.datatable 
                    id="presenceTable" 
                    :headers="['Tanggal', 'Karyawan', 'Status', 'Waktu In/Out', 'Keterangan', 'Edit']"
                    :collection="$presences">
                    
                    @forelse($presences as $data)
                        @php 
                            $isAbs = is_array($data);
                            $emp = $isAbs ? $data['employee'] : $data->employee;
                            $status = $isAbs ? 'absence' : $data->status;
                        @endphp
                        <tr 
                            @click="{{ $status === 'presence' ? 'toggleDetail(' . \Illuminate\Support\Js::from($data) . ')' : '' }}" 
                            class="group transition-all border-b border-slate-100 dark:border-slate-800 
                            {{ $status === 'presence' ? 'hover:bg-tosca-50/30 dark:hover:bg-tosca-900/10 cursor-pointer' : 'cursor-default' }}">
                            
                            <td>
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-700 dark:text-slate-200">
                                        {{ formatDate($data['date']) }}
                                    </span>
                                    
                                    <span class="text-[10px] font-medium text-slate-400 dark:text-slate-500 uppercase tracking-wider">
                                        {{ formatDateTime($data['date'], 'dddd') }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-[10px] font-black text-slate-500 border border-slate-200 dark:border-slate-700">
                                        {{ substr($emp->name, 0, 2) }}
                                    </div>
                                    <div class="text-sm font-bold text-slate-700 dark:text-slate-200">{{ $emp->name }}</div>
                                </div>
                            </td>
                            <td>
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest 
                                    {{ $status === 'presence' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                    {{ $status }}
                                </span>
                            </td>
                            <td>
                                <div class="flex flex-col items-start justify-center gap-1">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-bold text-slate-700 dark:text-slate-200">
                                            {{ $isAbs ? '--:--' : ($data->check_in ?? '--:--') }}
                                        </span>
                                        <span class="text-slate-300 dark:text-slate-600">-</span>
                                        <span class="text-sm font-bold text-slate-700 dark:text-slate-200">
                                            {{ $isAbs ? '--:--' : ($data->check_out ?? '--:--') }}
                                        </span>
                                    </div>
                                    <div class="flex gap-2">
                                        <span class="text-[9px] font-black uppercase tracking-tighter text-slate-400">Masuk</span>
                                        <span class="text-[9px] font-black uppercase tracking-tighter text-slate-400">Pulang</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="flex flex-col gap-1">
                                    @if(!$isAbs && $data->late_check_in)
                                        <div class="flex items-start gap-1 text-[10px] font-bold text-rose-500 bg-rose-50 dark:bg-rose-900/20 px-2 py-0.5 rounded-md w-fit">
                                            <iconify-icon icon="lucide:clock-alert" width="12"></iconify-icon>
                                            <span>Telat {{ $data->late_check_in }}m</span>
                                        </div>
                                    @endif

                                    @if(!$isAbs && $data->check_out_early)
                                        <div class="flex items-start gap-1 text-[10px] font-bold text-amber-600 bg-amber-50 dark:bg-amber-900/20 px-2 py-0.5 rounded-md w-fit">
                                            <iconify-icon icon="lucide:log-out" width="12"></iconify-icon>
                                            <span>Duluan {{ $data->check_out_early }}m</span>
                                        </div>
                                    @endif

                                    @if($isAbs || (!$data->late_check_in && !$data->check_out_early))
                                        <span class="text-slate-400 text-xs">-</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @can('update presence')
                                    @if(!$isAbs && $status === 'presence')
                                    <div @click.stop>
                                        <x-action-button 
                                            type="edit" 
                                            modal="presence-manual-modal"
                                            modalTitle="Tambah Presensi" 
                                            :modalArgs="['presenceId' => $data->id]"
                                            />
                                    </div>
                                    @else
                                        <div 
                                            title="Hanya data presensi yang dapat diedit"
                                            class="inline-flex items-center p-1 bg-slate-100 text-slate-400 dark:bg-slate-800/50 dark:text-slate-600 rounded-lg cursor-not-allowed opacity-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m12 15l8.385-8.415a2.1 2.1 0 0 0-2.97-2.97L9 12v3zm4-10l3 3"/><path d="M9 7.07A7 7 0 0 0 10 21a7 7 0 0 0 6.929-6"/></g></svg>
                                        </div>
                                    @endif
                                @endcan
                            </td>
                        </tr>
                    @empty
                    @endforelse
                    
                </x-ui.datatable>
            </div>
            <x-presence.panel-detail />
        </div>
    </div>
</div>