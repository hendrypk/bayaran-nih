<x-ui.modal id="option-modal" 
x-data="{ tableTitle: '', isEdit: false }" 
    @open-x-ilz-modal.window="
        if($event.detail.modal === 'option-modal') {
            tableTitle = $event.detail.args.tableTitle;
            isEdit = $event.detail.args.isEditing || false;
        }
    ">
    
    <x-slot:title>
        <div class="flex items-center gap-3">
            <div class="w-1.5 h-6 rounded-full" 
                :class="isEdit ? 'bg-amber-500 shadow-[0_0_10px_rgba(245,158,11,0.5)]' : 'bg-cyan-500 shadow-[0_0_10px_rgba(6,182,212,0.5)]'">
            </div>
            <h2 class="text-xl font-black text-slate-800 dark:text-white uppercase tracking-tight">
                <span x-text="isEdit ? 'Ubah' : 'Tambah'"></span> 
                <span :class="isEdit ? 'text-amber-500' : 'text-cyan-500'" x-text="tableTitle"></span>
            </h2>
        </div>
    </x-slot:title>

    <div class="space-y-6 p-4">
        {{-- 1. INPUT NAMA (Global untuk semua) --}}
        @if($tableId !== 'locations')
            <div class="group">
                <x-ui.label for="name"> @lang('general.label.name') </x-ui.label>
                <x-ui.input 
                    type="text"
                    wire:model="name"
                    placeholder="input nama..."    
                />
                @error('name') 
                    <span class="text-[10px] text-rose-500 font-bold mt-2 block uppercase tracking-wider">{{ $message }}</span> 
                @enderror
            </div>
        @endif

        {{-- 2. KONDISI: POSISI --}}
        @if($tableId === 'positions')
            <div class="space-y-6 animate-in fade-in slide-in-from-top-4 duration-500">
                <div>
                    <x-ui.label for="job_title"> Jabatan </x-ui.label>
                    <x-ui.select2 
                        name="job_title_id"
                        id="job_title_id"
                        wire:model.live="job_title_id"
                        :options="collect($jobTitles)->pluck('name', 'id')"
                        placeholder="Pilih Jabatan"
                    />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <x-ui.label for="job_title"> Department </x-ui.label>
                        <x-ui.select2 
                            name="department_id"
                            id="department_id"
                            wire:model.live="department_id"
                            :options="collect($departments)->pluck('name', 'id')"
                            placeholder="Pilih Department"
                        />
                    </div>
                    <div>
                        <x-ui.label for="job_title"> Divisi </x-ui.label>
                        <x-ui.select2 
                            name="division_id"
                            id="division_id"
                            wire:model.live="division_id"
                            :options="collect($divisions)->pluck('name', 'id')"
                            placeholder="Pilih Divisi"
                        />
                    </div>
                </div>
            </div>

        {{-- 3. KONDISI: JABATAN / PANGKAT --}}
        @elseif($tableId === 'job_titles')
        <div class="group  animate-in fade-in slide-in-from-top-4 duration-500">
            <x-ui.label for="section"> Level Jabatan </x-ui.label>
            <x-ui.select2 
                name="section"
                id="section"
                class="block w-full"
                wire:model.live="section"
                :options="collect(range(1, 10))->mapWithKeys(fn($i) => [$i => 'Level ' . $i])"
                placeholder="Pilih Level Jabatan"
            />

            <p class="mt-2 text-[9px] text-slate-500 italic tracking-wide pl-1">
                * Pilih level 1 (tertinggi) sampai 10 untuk menentukan struktur NIP.
            </p>            
        </div>

        {{-- 4. KONDISI: HOLIDAY --}}
        @elseif($tableId === 'holidays')
        <div class="animate-in fade-in slide-in-from-top-4 duration-500" wire:ignore> {{-- TAMBAHKAN wire:ignore --}}
            <label class="form-label-puff">
                Tanggal Libur
            </label>
            <div class="relative" 
                x-data="{ 
                    instance: null,
                    value: @entangle('date') 
                }" 
                x-init="
                    instance = flatpickr($refs.dateInput, {
                        disableMobile: true,
                        dateFormat: 'Y-m-d',
                        altInput: true,
                        altInputClass: 'form-input-puffy dark:bg-slate-950 dark:text-white',
                        altFormat: 'l, j F Y',
                        static: false,
                        {{-- Set nilai awal jika sudah ada saat render --}}
                        defaultDate: value,
                        onChange: (selectedDates, dateStr) => {
                            value = dateStr;
                        }
                    });

                    {{-- WATCHER: Ini yang menangani pengisian data saat tombol EDIT diklik --}}
                    $watch('value', (newVal) => {
                        if (instance && newVal) {
                            instance.setDate(newVal, false);
                        } else if (instance && !newVal) {
                            instance.clear();
                        }
                    });
                ">
                
                <input x-ref="dateInput"
                    type="text" 
                    placeholder="Pilih tanggal..." 
                    class="form-input-puffy">
                
                <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500 group-focus-within:text-cyan-400">
                    <iconify-icon icon="lucide:calendar" width="18"></iconify-icon>
                </div>
            </div>
        </div>

            {{-- 4. KONDISI: LOCATIONS --}}
        @elseif($tableId === 'locations')
            <div class="animate-in fade-in zoom-in duration-500 space-y-4" 
                x-data="locationPickerData" 
                x-init="initMap()">
                
                {{-- BARIS PERTAMA: NAME, LAT, LON --}}
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
                    <div class="lg:col-span-4 group">
                        <label class="form-label-puffy">Nama Lokasi Kantor</label>
                        <input type="text" wire:model="name" placeholder="Contoh: Kantor Pusat" class="form-input-puffy">
                    </div>
                    <div class="lg:col-span-4">
                        <label class="form-label-puffy">Latitude</label>
                        <div class="form-input-puffy">
                            <span class="text-xs font-mono text-cyan-400" x-text="$wire.latitude || '-'"></span>
                        </div>
                    </div>
                    <div class="lg:col-span-4">
                        <label class="form-label-puffy">Longitude</label>
                        <div class="form-input-puffy">
                            <span class="text-xs font-mono text-cyan-400" x-text="$wire.longitude || '-'"></span>
                        </div>
                    </div>
                </div>

                {{-- BARIS KEDUA: SEARCH & MAP --}}
                <div class="relative group w-full" wire:ignore>
                    {{-- SEARCH BAR FLOATING --}}
                    <div class="absolute top-6 left-6 right-6 z-[1001] flex gap-2">
                        <div class="flex-1 relative group/search" x-data="{ open: false }" @click.away="open = false">
                            {{-- Input Search --}}
                            <div class="relative flex items-center">
                                <input type="text" 
                                    x-model="searchQuery" 
                                    @input.debounce.200ms="searchLocation(); open = true"
                                    @focus="open = true"
                                    placeholder="Cari lokasi atau alamat..." 
                                    class="w-full bg-slate-950/80 backdrop-blur-xl border border-white/10 rounded-2xl px-6 py-4 text-xs text-white shadow-2xl focus:ring-2 focus:ring-cyan-500/50 outline-none transition-all">
                                
                                <div class="absolute right-5 flex items-center gap-3">
                                    <iconify-icon x-show="isSearching" icon="line-md:loading-twotone-loop" class="text-cyan-400 text-lg"></iconify-icon>
                                    <iconify-icon x-show="!isSearching" icon="lucide:search" class="text-slate-400 text-lg"></iconify-icon>
                                </div>
                            </div>

                            {{-- DROPDOWN RESULTS --}}
                            <div x-show="open && searchResults.length > 0" 
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 -translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="absolute mt-2 w-full bg-white rounded-2xl shadow-2xl overflow-hidden border border-slate-200 z-[1003]">
                                
                                <div class="max-h-[300px] overflow-y-auto custom-scrollbar">
                                    <template x-for="(res, index) in searchResults" :key="index">
                                        <button @click="selectLocation(res); open = false" 
                                                class="w-full flex items-start gap-4 px-5 py-3.5 hover:bg-slate-50 transition-colors border-b border-slate-100 last:border-0 text-left group">
                                            
                                            {{-- Icon (Clock for history or Pin for new) --}}
                                            <div class="mt-0.5 text-slate-400 group-hover:text-cyan-500">
                                                <iconify-icon icon="lucide:map-pin" width="18"></iconify-icon>
                                            </div>

                                            <div class="flex flex-col gap-0.5">
                                                {{-- Nama Tempat (Bold) --}}
                                                <span class="text-[11px] font-bold text-slate-700 group-hover:text-cyan-600 line-clamp-1" 
                                                    x-text="res.display_name.split(',')[0]"></span>
                                                {{-- Alamat Lengkap (Sub-text) --}}
                                                <span class="text-[9px] text-slate-400 line-clamp-1" 
                                                    x-text="res.display_name.split(',').slice(1).join(',')"></span>
                                            </div>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>
                        
                        {{-- CUSTOM ZOOM CONTROLS --}}
                        <div class="flex flex-col gap-1 bg-slate-900/90 backdrop-blur-md p-1 rounded-xl border border-slate-700 shadow-2xl">
                            <button @click="map.zoomIn()" class="p-2 text-white hover:bg-slate-800 rounded-lg transition-colors">
                                <iconify-icon icon="lucide:plus" width="20"></iconify-icon>
                            </button>
                            <div class="h-px bg-slate-700 mx-2"></div>
                            <button @click="map.zoomOut()" class="p-2 text-white hover:bg-slate-800 rounded-lg transition-colors">
                                <iconify-icon icon="lucide:minus" width="20"></iconify-icon>
                            </button>
                        </div>
                    </div>

                    <div id="map-picker" class="w-full h-[500px] rounded-[2.5rem] border-4 border-slate-800 shadow-2xl z-0 overflow-hidden"></div>

                    <div class="absolute inset-x-8 bottom-8 z-[1000] flex justify-between items-center pointer-events-none">
                        
                        <div class="pointer-events-auto">
                            <div class="bg-slate-950/40 backdrop-blur-xl border border-white/10 px-4 py-2.5 rounded-full flex items-center gap-4 shadow-2xl transition-all hover:bg-slate-950/60">
                                <div class="flex items-center gap-2 border-r border-white/10 pr-4">
                                    <iconify-icon icon="lucide:radar" class="text-cyan-400 text-sm"></iconify-icon>
                                    <span class="text-[10px] font-black text-white uppercase tracking-widest leading-none">Radius</span>
                                </div>
                                
                                <div class="w-32 flex items-center">
                                    <input type="range" min="10" max="500" step="10" 
                                        wire:model.live="radius" 
                                        class="w-full h-1 bg-slate-700/50 rounded-full appearance-none cursor-pointer accent-cyan-500">
                                </div>

                                <div class="bg-cyan-500/20 px-2.5 py-1 rounded-lg border border-cyan-500/30">
                                    <span class="text-[11px] font-mono font-black text-cyan-400" x-text="$wire.radius + 'm'"></span>
                                </div>
                            </div>
                        </div>

                        <div class="pointer-events-auto">
                            <button @click="getCurrentLocation()" 
                                class="group relative w-12 h-12 bg-cyan-500 hover:bg-cyan-400 rounded-full shadow-xl shadow-cyan-500/20 flex items-center justify-center transition-all active:scale-90">
                                {{-- Pulse Effect --}}
                                <span class="absolute inset-0 rounded-full bg-white animate-ping opacity-10 group-hover:opacity-20"></span>
                                
                                <iconify-icon icon="lucide:locate-fixed" class="text-white text-lg relative z-10"></iconify-icon>
                            </button>
                        </div>
                    </div>
                    
                </div>
            </div>
        @endif
    </div>
@if($isEditing)
        <x-slot:footer_left>
            <x-swal-confirm 
                title="Hapus Data?" 
                text="Data ini akan dihapus permanen..."
                callback="delete"
                {{-- Encode array menjadi JSON string --}}
                :id="json_encode(['id' => $selectedId, 'tableId' => $tableId])" 
            />
        </x-slot:footer_left>
    @endif
</x-ui.modal>
