<x-layouts.app>
    <x-slot:title> @lang('sidebar.label.leaves') </x-slot:title>
    <x-page-header>Manajemen Cuti & Izin</x-page-header>

    {{-- State Alpine untuk toggle detail panel jika diperlukan --}}
    <div class="flex flex-col lg:flex-row gap-6 px-4 pb-10 items-start">

        {{-- Main Content --}}
        <div :class="showDetail ? 'lg:w-3/4' : 'w-full'" class="transition-all duration-500 ease-in-out w-full">
            
            {{-- Bagian 1: Stats Cards (Disesuaikan dengan Konstanta Status Anda) --}}<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    @foreach([
        [
            'label' => 'Total Hadir', 
            'count' => ($counts['presence'] ?? 0) + ($counts['halfday'] ?? 0), 
            'icon' => 'lucide:user-check', 
            'color' => 'emerald',
            'sub'   => ($counts['halfday'] ?? 0) . ' Setengah Hari'
        ],
        [
            'label' => 'Izin & Sakit', 
            'count' => ($counts['permit'] ?? 0) + ($counts['sick'] ?? 0), 
            'icon' => 'lucide:clipboard-list', 
            'color' => 'indigo',
            'sub'   => ($counts['sick'] ?? 0) . ' Sakit'
        ],
        [
            'label' => 'Cuti Karyawan', 
            'count' => $counts['leave'] ?? 0, 
            'icon' => 'lucide:palm-tree', 
            'color' => 'cyan',
            'sub'   => 'Cuti Tahunan/Khusus'
        ],
        [
            'label' => 'Ketidakhadiran', 
            'count' => $counts['absence'] ?? 0, 
            'icon' => 'lucide:user-x', 
            'color' => 'rose',
            'sub'   => 'Tanpa Keterangan (Alpa)'
        ],
    ] as $val)
    <div class="group bg-white dark:bg-slate-900 p-5 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm transition-all duration-300 hover:shadow-xl hover:border-{{ $val['color'] }}-100 dark:hover:border-{{ $val['color'] }}-900/30">
        <div class="flex items-center justify-between">
            {{-- Info Section --}}
            <div class="space-y-1">
                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.12em]">
                    {{ $val['label'] }}
                </p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-black text-slate-800 dark:text-white tracking-tighter">
                        {{ number_format($val['count']) }}
                    </h3>
                    <span class="text-[10px] font-bold text-slate-400">Karyawan</span>
                </div>
                <p class="text-[9px] font-medium text-{{ $val['color'] }}-600/70 dark:text-{{ $val['color'] }}-400/50 italic">
                    {{ $val['sub'] }}
                </p>
            </div>

            {{-- Icon Section --}}
            <div class="relative">
                {{-- Glow Decor --}}
                <div class="absolute inset-0 bg-{{ $val['color'] }}-400 blur-2xl opacity-0 group-hover:opacity-20 transition-all duration-500"></div>
                
                <div class="relative w-16 h-16 rounded-[1.25rem] bg-{{ $val['color'] }}-50 dark:bg-{{ $val['color'] }}-900/20 flex items-center justify-center text-{{ $val['color'] }}-600 group-hover:rotate-6 group-hover:scale-110 transition-all duration-500">
                    <iconify-icon icon="{{ $val['icon'] }}" width="32"></iconify-icon>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

            {{-- Bagian 2: Main Table Container --}}
            <div class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                {{-- Header Tabel --}}
                <div class="p-6 border-b border-slate-100 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-900/50">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <h4 class="text-sm font-black uppercase tracking-tighter text-slate-700 dark:text-slate-300">Log Riwayat Cuti & Izin</h4>
                        
                        <div class="flex flex-wrap items-center gap-2">
                            <div class="flex items-center bg-slate-100 dark:bg-slate-800 p-1 rounded-xl mr-2">
                                <x-action-button type="download" label="Export" class="!bg-transparent !shadow-none hover:!bg-white dark:hover:!bg-slate-700 text-xs" />
                            </div>

                            @can('create leave')
                                <x-action-button 
                                    type="add" 
                                    label="Input Manual" 
                                    modal="leave-manual-modal" 
                                    modalTitle="Input Cuti/Izin"
                                    class="!rounded-xl shadow-lg shadow-tosca-100 dark:shadow-none" 
                                />
                            @endcan
                        </div>
                    </div>
                </div>

                {{-- Livewire Table untuk Leave --}}
                @livewire('leave-table')
            </div>
        </div>

    </div>
</x-layouts.app>