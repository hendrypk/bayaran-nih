<div class="space-y-4">
    <div class="px-4 py-4 ">
        <div class="flex flex-col lg:flex-row gap-4 justify-between items-end">
            <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
                {{-- Date Range --}}
<div class="w-full md:w-64"
    wire:ignore {{-- Mencegah Livewire menghancurkan elemen --}}
    wire:key="overtime-range-picker" {{-- Gunakan key statis agar tidak ter-render ulang --}}
    x-data="{
        picker: null,
        init() {
            this.picker = flatpickr($refs.input, {
                mode: 'range',
                dateFormat: 'Y-m-d',
                // Ambil nilai awal dari state Livewire saat ini
                defaultDate: [ @js($startDate), @js($endDate) ],
                onClose: (dates) => {
                    if(dates.length === 2) {
                        $wire.setDateRange(
                            this.picker.formatDate(dates[0], 'Y-m-d'),
                            this.picker.formatDate(dates[1], 'Y-m-d')
                        );
                    }
                }
            });

            // Sinkronisasi jika variabel di Livewire berubah (misal setelah reset)
            this.$watch('$wire.startDate', (val) => {
                this.picker.setDate([$wire.startDate, $wire.endDate], false);
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
                    {{-- <label class="text-[10px] font-bold text-slate-400 uppercase ml-1">Filter Status</label> --}}
                    <select wire:model.live="status" class="w-full px-3 py-2 text-sm border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 focus:ring-2 focus:ring-tosca-500 outline-none cursor-pointer font-bold text-slate-700 dark:text-slate-200">
                        <option value="all">Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="approve">Approve</option>
                        <option value="reject">Reject</option>
                    </select>
                </div>

                {{-- Show Per Page --}}
                <div class="w-full md:w-28">
                    {{-- <label class="text-[10px] font-bold text-slate-400 uppercase ml-1">Baris</label> --}}
                    <select wire:model.live="perPage" class="w-full px-3 py-2 text-sm border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800 font-bold outline-none text-tosca-600 cursor-pointer">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="all">Semua</option> {{-- Tombol All --}}
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

<x-ui.datatable 
    id="overtimeTable" 
    :headers="['Tanggal', 'Karyawan', 'Status', 'Waktu Lembur', 'Durasi', 'Edit']"
    :collection="$overtimes">
    
    @forelse($overtimes as $data)
        @php 
            $emp = $data->employee;
            // Persiapkan data untuk dikirim ke Alpine
            $mappedData = [
                'id' => $data->id,
                'employee' => ['name' => $emp->name],
                'date_display' => $data->date->translatedFormat('d F Y'),
                'start_at_time' => $data->start_at->format('H:i'),
                'end_at_time' => $data->end_at ? $data->end_at->format('H:i') : '--:--',
                'duration' => $data->duration ?? '-',
                'status' => $data->status,
                'note_in' => $data->note_in ?? '-',
                'note_out' => $data->note_out ?? '-',
                'photo_in_url' => $data->photo_in ? asset('storage/'.$data->photo_in) : null,
                'photo_out_url' => $data->photo_out ? asset('storage/'.$data->photo_out) : null,
            ];
        @endphp
        <tr 
            @click="toggleOvertimeDetail({{ json_encode($mappedData) }})"
            :class="selectedOvertime && selectedOvertime.id === {{ $data->id }} ? 'bg-tosca-50 dark:bg-tosca-900/20 ring-1 ring-inset ring-tosca-500' : ''"
            class="group transition-all border-b border-slate-100 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/40 cursor-pointer">
                
            <td class="py-4 px-6 text-sm font-bold text-slate-700 dark:text-slate-200">
                {{ $data->date->format('d M Y') }}
            </td>
            <td class="py-4 px-6">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-[10px] font-black text-slate-500 border border-slate-200 dark:border-slate-700">
                        {{ substr($emp->name, 0, 2) }}
                    </div>
                    <div class="text-sm font-bold text-slate-700 dark:text-slate-200">{{ $emp->name }}</div>
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