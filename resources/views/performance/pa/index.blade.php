<x-layouts.app>
    <x-slot:title> {{ __('Performance - PA') }} </x-slot:title>
    <x-page-header>{{ __('performance.label.employee_appraisal') }}</x-page-header>

    <div x-data="{ showDetail: false, selectedPA: null }" 
        class="flex flex-col lg:flex-row gap-6 px-4 pb-10 items-start">

        <div :class="showDetail ? 'lg:w-2/3' : 'w-full'" class="transition-all duration-500 ease-in-out">
            
            {{-- Bagian 1: Stats Cards (Muted Colors) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                @foreach([
                    ['label' => 'Total Appraisal', 'icon' => 'lucide:file-text', 'color' => 'tosca', 'count' => $totalAppraisals ?? 0],
                    ['label' => 'Rata-rata Grade', 'icon' => 'lucide:trending-up', 'color' => 'indigo', 'count' => $avgGrade ?? '-'],
                    ['label' => 'Butuh Review', 'icon' => 'lucide:clock', 'color' => 'amber', 'count' => $pendingReview ?? 0],
                ] as $val)
                <div class="bg-white dark:bg-slate-900 p-4 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $val['label'] }}</p>
                            <h3 class="text-2xl font-bold text-slate-800 dark:text-white mt-1">{{ $val['count'] }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-emerald-500">
                            <iconify-icon icon="{{ $val['icon'] }}" width="24"></iconify-icon>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Bagian 2: Main Table & Filter Container --}}
            <div class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                {{-- Header Tabel (Filter & Action Digabung) --}}
                <div class="p-6 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex flex-col xl:flex-row gap-4 justify-end items-start xl:items-center">
                        <div class="flex flex-wrap items-center gap-2">
                            <x-action-button type="download" label="Export" />
                            <x-action-button type="import" :href="route('presence.import')" label="Import" />
                            @can('create presence')
                                <x-action-button type="add" label="PA Baru" modal="pa-form" modalTitle="Tambah PA Baru Karyawan" />
                            @endcan
                        </div>
                    </div>
                </div>

                @livewire('appraisal-table')
            </div>
        </div>
        <x-performance.appraisal-panel-detail />

    </div>
</x-layouts.app>