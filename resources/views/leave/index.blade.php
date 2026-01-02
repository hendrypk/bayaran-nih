<x-layouts.app>
    <x-slot:title>@lang('sidebar.label.leaves')</x-slot:title>

    {{-- Page Header --}}
    <x-page-header>Manajemen Cuti & Izin</x-page-header>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 pb-4">
        @foreach([
            'leave'   => ['label' => 'Cuti Karyawan', 'icon' => 'lucide:palm-tree', 'color' => 'cyan', 'count' => $typeCounts['leave'] ?? 0],
            'permit'  => ['label' => 'Izin', 'icon' => 'lucide:clipboard-list', 'color' => 'indigo', 'count' => $typeCounts['permit'] ?? 0],
            'sick'    => ['label' => 'Sakit', 'icon' => 'lucide:activity', 'color' => 'amber', 'count' => $typeCounts['sick'] ?? 0],
            'absence' => ['label' => 'Ketidakhadiran', 'icon' => 'lucide:user-x', 'color' => 'rose', 'count' => $typeCounts['absence'] ?? 0],
        ] as $key => $val)
        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center gap-4 group transition-all">
            <div class="w-12 h-12 rounded-xl bg-{{ $val['color'] }}-100 dark:bg-{{ $val['color'] }}-900/30 flex items-center justify-center text-{{ $val['color'] }}-600 transition-transform group-hover:scale-110">
                <iconify-icon icon="{{ $val['icon'] }}" width="24"></iconify-icon>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $val['label'] }}</p>
                <h3 class="text-xl font-bold text-slate-800 dark:text-white">{{ $val['count'] }}</h3>
            </div>
        </div>
        @endforeach
    </div>
    @livewire('leave-table')
</x-layouts.app>
