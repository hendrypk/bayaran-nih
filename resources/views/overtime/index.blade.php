<x-layouts.app>
    <x-slot:title>Daftar Lembur</x-slot:title>
    <x-page-header>Kelola Lembur Karyawan</x-page-header>

    <div x-data="{ 
            selectedOvertime: null,
            showDetail: false,
            
            toggleOvertimeDetail(data) {
                // Jika klik data yang sama, tutup panel. Jika beda, ganti data.
                if (this.showDetail && this.selectedOvertime?.id === data.id) {
                    this.showDetail = false;
                    this.selectedOvertime = null;
                } else {
                    this.selectedOvertime = data;
                    this.showDetail = true;
                }
            }
        }" 
        class="flex flex-col lg:flex-row gap-6 px-4 pb-10 items-start">

        {{-- Sisi Kiri: Konten Utama (Tabel) --}}
        <div :class="showDetail ? 'lg:w-3/4' : 'w-full'" class="transition-all duration-500 ease-in-out">
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

            <div class="flex flex-col sm:flex-row sm:items-center justify-end gap-4 px-4 mb-4">
                <div class="flex items-center gap-2">
                    <x-action-button 
                        type="download" 
                        {{-- :href="route('presence.import')"  --}}
                        label="Export" 
                    />
                    <x-action-button 
                        type="import" 
                        {{-- :href=""  --}}
                        label="Import" 
                    />
                    @can('create overtime')
                        <x-action-button 
                            type="add" 
                            label="Tambah Lembur"
                            modal="overtime-manual-modal"
                            modalTitle="Input Lembur Manual"
                            modalSize="max-w-4xl"
                        />
                    @endcan
                </div>
            </div>
            @livewire('overtime-table')
        </div>
        <x-overtime.panel-detail />
    </div>
</x-layouts.app>