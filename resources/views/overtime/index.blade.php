<x-layouts.app>
    <x-slot:title>Daftar Lembur</x-slot:title>
    <x-page-header :links="[
        ['label' => 'Lembur', 'url' => route('overtime.list')],
        ['label' => 'Log Presensi']
    ]">
        Log Lembur
    </x-page-header>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pb-4">
        @foreach([
            'all' => ['label' => 'Total Lembur', 'icon' => 'lucide:clock', 'color' => 'blue', 'count' => $counts['all'] ?? 0],
            'pending' => ['label' => 'Menunggu Persetujuan', 'icon' => 'lucide:timer', 'color' => 'amber', 'count' => $counts['pending'] ?? 0],
            'approved' => ['label' => 'Disetujui', 'icon' => 'lucide:check-circle', 'color' => 'emerald', 'count' => $counts['approved'] ?? 0]
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
    @livewire('overtime-table')
</x-layouts.app>