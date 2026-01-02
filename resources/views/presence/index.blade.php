<x-layouts.app>
    <x-slot:title> @lang('sidebar.label.presences') </x-slot:title>
    <x-page-header :links="[
        ['label' => 'Kehadiran', 'url' => route('presence.list.admin')],
        ['label' => 'Log Presensi']
    ]">
        Log Kehadiran
    </x-page-header>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        @foreach([
            ['label' => 'Total Hadir', 'icon' => 'lucide:user-check', 'color' => 'cyan', 'count' => $counts['presence'] ?? 0],
            ['label' => 'Terlambat', 'icon' => 'lucide:user-x', 'color' => 'amber', 'count' => $counts['late'] ?? 0],
            ['label' => 'Sakit/Izin', 'icon' => 'lucide:clipboard-list', 'color' => 'indigo', 'count' => $counts['sick_leave'] ?? 0],
            ['label' => 'Alpa', 'icon' => 'lucide:alert-circle', 'color' => 'rose', 'count' => $counts['absence'] ?? 0]
        ] as $val)
        <div class="bg-white dark:bg-slate-900 p-4 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $val['label'] }}</p>
                    <h3 class="text-2xl font-bold text-slate-800 dark:text-white mt-1">{{ $val['count'] }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-{{ $val['color'] }}-50 dark:bg-{{ $val['color'] }}-900/20 flex items-center justify-center text-{{ $val['color'] }}-600">
                    <iconify-icon icon="{{ $val['icon'] }}" width="24"></iconify-icon>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @livewire('presence-table')
</x-layouts.app>