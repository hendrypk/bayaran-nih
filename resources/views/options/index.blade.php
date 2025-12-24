<x-layouts.app>
    <x-slot:title>@lang('sidebar.label.options')</x-slot>

    <div class="px-6 py-6 mb-6 border-b rounded-[2rem] border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-slate-800 dark:text-white uppercase tracking-tight">Master Konfigurasi</h1>
                <p class="text-xs text-slate-500 font-medium uppercase tracking-widest mt-1">Total: 8 Kategori Data</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="animate-pulse w-2 h-2 bg-emerald-500 rounded-full"></span>
                <span class="text-[10px] font-bold text-slate-400 uppercase">Sistem Sinkron Aktif</span>
            </div>
        </div>
    </div>

    <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-6">
        
        @php
            $tables = [
                ['id' => 'positions', 'title' => 'Posisi', 'data' => $positions, 'color' => 'bg-cyan-500', 'icon' => 'mdi:briefcase-variant-outline'],
                ['id' => 'job_titles', 'title' => 'Jabatan', 'data' => $job_titles, 'color' => 'bg-indigo-500', 'icon' => 'mdi:account-tie-outline'],
                ['id' => 'divisions', 'title' => 'Divisi', 'data' => $divisions, 'color' => 'bg-emerald-500', 'icon' => 'mdi:sitemap-outline'],
                ['id' => 'departments', 'title' => 'Departemen', 'data' => $departments, 'color' => 'bg-rose-500', 'icon' => 'mdi:office-building-outline'],
                ['id' => 'statuses', 'title' => 'Status Karyawan', 'data' => $statuses, 'color' => 'bg-amber-500', 'icon' => 'mdi:card-account-details-outline'],
                ['id' => 'holidays', 'title' => 'Hari Libur', 'data' => $holidays, 'color' => 'bg-purple-500', 'icon' => 'mdi:calendar-star-outline'],
                ['id' => 'locations', 'title' => 'Lokasi Kantor', 'data' => $officeLocation, 'color' => 'bg-blue-500', 'icon' => 'mdi:map-marker-radius-outline'],
                ['id' => 'hr_categories', 'title' => 'Kategori Lapor', 'data' => $laporHrCategory, 'color' => 'bg-orange-500', 'icon' => 'mdi:face-agent'],
            ];
        @endphp

        @foreach($tables as $table)
        <div class="flex flex-col bg-white dark:bg-slate-900 shadow-sm rounded-[2rem] border border-slate-200 dark:border-slate-800 overflow-hidden h-[500px] transition-all duration-300 hover:shadow-xl hover:shadow-slate-200/50 dark:hover:shadow-none group">
            
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-50 dark:border-slate-800 bg-white dark:bg-slate-900 sticky top-0 z-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 {{ $table['color'] }} bg-opacity-10 rounded-xl flex items-center justify-center transition-transform group-hover:scale-110">
                        <iconify-icon icon="{{ $table['icon'] }}" class="{{ str_replace('bg-', 'text-', $table['color']) }} text-2xl"></iconify-icon>
                    </div>
                    <div>
                        <h5 class="font-black text-slate-800 dark:text-slate-100 text-xs uppercase tracking-wider">{{ $table['title'] }}</h5>
                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-tighter">{{ count($table['data']) }} Data Record</p>
                    </div>
                </div>
                @can('create options')
                <div x-data>
<x-modal-trigger
    modal="option-modal"
    title="Tambah {{ $table['title'] }}"
    {{-- Gunakan .defer atau panggil langsung sebelum modal render --}}
    wire:click="setContext('{{ $table['id'] }}')"
    {{-- Masukkan ID ke dalam args agar dibaca Alpine Modal --}}
    :args="['tableId' => $table['id'], 'tableTitle' => $table['title']]"
>
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3c7.2 0 9 1.8 9 9s-1.8 9-9 9s-9-1.8-9-9s1.8-9 9-9m3 9H9m3-3v6"/>
    </svg>
</x-modal-trigger>
                </div>
                @endcan
            </div>

            <div class="flex-1 overflow-y-auto p-4 custom-scrollbar">
                <table class="w-full text-xs text-left border-separate border-spacing-y-1">
                    <thead class="sticky top-0 bg-white dark:bg-slate-900 z-10 text-[9px] font-black text-slate-400 uppercase tracking-widest">
                        <tr>
                            <th class="pb-2 px-2">Nama</th>
                            <th class="pb-2 px-2 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                        @forelse($table['data'] as $item)
                        <tr class="group/row hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="py-3 px-2 font-bold text-slate-700 dark:text-slate-300">
                                {{ $item->name ?? $item->category_name ?? $item->location_name ?? $item->holiday_name }}
                                @if(isset($item->code) || isset($item->section))
                                    <span class="block text-[9px] font-medium text-slate-400 italic">
                                        {{ $item->code ?? $item->section }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-2 text-right">
                                <div class="flex justify-end gap-1 opacity-75 group-hover/row:opacity-100 transition-opacity">
                                    <button class="p-1.5 text-cyan-500 hover:bg-cyan-50 rounded-lg">
                                        <iconify-icon icon="mdi:pencil-outline"></iconify-icon>
                                    </button>
                                    <button onclick="confirmDelete({{ $item->id }}, '{{ $item->name }}', '{{ $table['id'] }}')" 
                                        class="p-1.5 text-rose-500 hover:bg-rose-50 rounded-lg">
                                        <iconify-icon icon="mdi:trash-can-outline"></iconify-icon>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="py-8 text-center text-[10px] text-slate-400 font-bold uppercase italic">Data Kosong</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-5 py-3 border-t border-slate-50 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-900 flex justify-between items-center">
                <div class="flex gap-1">
                    <div class="w-1 h-1 rounded-full bg-slate-300"></div>
                    <div class="w-1 h-1 rounded-full bg-slate-300"></div>
                    <div class="w-1 h-1 rounded-full bg-slate-300"></div>
                </div>
                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">View Detailed Report</span>
            </div>
        </div>
        @endforeach

    </div>
</x-layouts.app>

<style>
    /* Styling Scrollbar Card agar halus */
    .custom-scrollbar::-webkit-scrollbar { width: 3px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { 
        @apply bg-slate-200 dark:bg-slate-700 rounded-full; 
    }
</style>