<div class="card-puffy">

    <div class="card-puffy-header">
        <div class="flex items-center gap-3 w-full lg:w-auto">
            <div class="flex items-center gap-2">
                <x-ui.input-group
                    prefix="mdi:magnify"
                    wire:model.live.debounce.500ms="search"
                    type="text"
                    placeholder="Cari sesuatu di sini..."
                    />
                </div>
            <div class="relative" wire:ignore>
                <x-ui.date-range-picker 
                    :startDate="$startDate" 
                    :endDate="$endDate" 
                    />
                </div>
            <x-ui.tab 
                :active="$status"
                :options="[
                    'pending' => 'Pending', 
                    'approve'  => 'Disetujui', 
                    'reject'     => 'Ditolak', 
                    ]" 
                />
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
            @can('create overtime')
                <x-action-button 
                    type="add" 
                    label="Overtime" 
                    modal="overtime-manual-modal"
                    modalTitle="Tambah Lembur" 
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
        <div 
            x-data="showMap" 
            class="flex flex-col lg:flex-row gap-6 px-4 pb-10 items-start">

            <div 
                :class="active ? 'lg:w-3/4' : 'w-full'" 
                class="transition-all duration-500 ease-in-out">

                <x-ui.datatable 
                    id="overtimeTable" 
                    :headers="['Tanggal', 'Karyawan', 'Status', 'Waktu Lembur', 'Durasi', 'Edit']"
                    :collection="$overtimes">
                    
                    @forelse($overtimes as $data)

                        <tr 
                            @click="toggleDetail({{ \Illuminate\Support\Js::from($data) }})"
                            :class="selectedData && selectedData.id === {{ $data->id }} ? 'bg-tosca-50/50 dark:bg-tosca-900/20 ring-1 ring-inset ring-tosca-500/30' : ''"
                            class="group transition-all border-b border-slate-100 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/40 cursor-pointer">  
                            <td class="py-4 px-6 text-sm font-bold text-slate-700 dark:text-slate-200">
                                {{ $data->date->format('d M Y') }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-[10px] font-black text-slate-500 border border-slate-200 dark:border-slate-700">
                                        {{ substr($data->employee->name, 0, 2) }}
                                    </div>
                                    <div class="text-sm font-bold text-slate-700 dark:text-slate-200">{{ $data->employee->name }}</div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest 
                                    {{ is_null($data->status) ? 'bg-amber-100 text-amber-700' : ($data->status ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700') }}">
                                    {{ is_null($data->status) ? 'Pending' : ($data->status ? 'Approved' : 'Rejected') }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center text-sm font-bold text-slate-700 dark:text-slate-200">
                                {{ $data->start_at->format('H:i') }} - {{ $data->end_at ? $data->end_at->format('H:i') : '--:--' }}
                            </td>
                            <td class="py-4 px-6 text-xs text-tosca-600 font-bold">
                                {{ $data->duration ?? '-' }}
                            </td>
                            <td @click.stop>
                                @can('update user')
                                    <x-modal-trigger
                                        class="inline-flex items-center p-1 bg-emerald-100 text-emerald-600 hover:bg-emerald-600 hover:text-white dark:bg-emerald-900/30 dark:text-emerald-400 dark:hover:bg-emerald-600 dark:hover:text-white rounded-lg transition-all"
                                        modal="overtime-manual-modal"
                                        :args="['id' => $data->id]"
                                        title="Edit Lembur Karyawan">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m12 15l8.385-8.415a2.1 2.1 0 0 0-2.97-2.97L9 12v3zm4-10l3 3"/><path d="M9 7.07A7 7 0 0 0 10 21a7 7 0 0 0 6.929-6"/></g></svg>
                                    </x-modal-trigger>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-12 text-center text-slate-400 italic">Data lembur tidak ditemukan</td></tr>
                    @endforelse
                </x-ui.datatable>
            </div>
        <x-overtime.panel-detail />
    </div>
</div>

