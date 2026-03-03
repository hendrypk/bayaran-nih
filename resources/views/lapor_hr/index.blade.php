<x-layouts.app>
    <x-slot:title>{{ __('option.label.lapor_hr') }}</x-slot:title>
    <x-page-header>{{ __('option.label.lapor_hr') }}</x-page-header>

    <div class="flex flex-col gap-6 px-4 pb-10">
        
        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            @foreach([
                ['label' => 'Total Laporan', 'icon' => 'lucide:clipboard-list', 'color' => 'cyan', 'count' => $counts['total'] ?? 0],
                ['label' => 'Open', 'icon' => 'lucide:alert-circle', 'color' => 'blue', 'count' => $counts['open'] ?? 0],
                ['label' => 'On Progress', 'icon' => 'lucide:clock', 'color' => 'amber', 'count' => $counts['in_progress'] ?? 0],
                ['label' => 'Closed', 'icon' => 'lucide:check-circle', 'color' => 'emerald', 'count' => $counts['closed'] ?? 0]
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

        {{-- Main Table Container --}}
        <div class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            {{-- Header with Action Buttons --}}
            <div class="p-6 border-b border-slate-100 dark:border-slate-800">
                <div class="flex flex-col xl:flex-row gap-4 justify-end items-start xl:items-center">
                    <div class="flex flex-wrap items-center gap-2">
                        @can('create leave')
                            {{-- Add action buttons here if needed --}}
                            <x-action-button type="add" label="Tambah Lapor HR" modal="lapor-hr-form" modalTitle="Tambah Lapor HR" />
                        @endcan
                    </div>
                </div>
            </div>

            @livewire('lapor-hr-table')
        </div>
    </div>
</x-layouts.app>

