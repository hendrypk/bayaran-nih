<x-ui.modal id="option-modal" 
    x-data="{ tableTitle: '' }" 
    @open-x-ilz-modal.window="
        if($event.detail.modal === 'option-modal') {
            tableTitle = $event.detail.args.tableTitle;
        }
    ">
    
    <x-slot:title>
        <div class="flex items-center gap-3">
            <div class="w-1.5 h-6 bg-cyan-500 rounded-full shadow-[0_0_10px_rgba(6,182,212,0.5)]"></div>
            <h2 class="text-xl font-black text-white uppercase tracking-tight">
                Tambah <span x-text="tableTitle" class="text-cyan-500"></span>
            </h2>
        </div>
    </x-slot:title>

    <div class="space-y-6 py-4">
        {{-- 1. INPUT NAMA (Global untuk semua) --}}
        <div class="group">
            <label class="form-label-puffy">
                Nama <span x-text="tableTitle"></span>
            </label>
            <input type="text" wire:model="name" placeholder="Input nama..." class="form-input-puffy">
                @error('name') <span class="text-[10px] text-rose-500 font-bold mt-2 block uppercase tracking-wider">{{ $message }}</span> @enderror
        </div>

        {{-- 2. KONDISI: POSISI --}}
        @if($tableId === 'positions')
            <div class="space-y-6 animate-in fade-in slide-in-from-top-4 duration-500">
                <div>
                    <label class="form-label-puffy">Pilih Pangkat</label>
                    <select wire:model="job_title_id" class="form-select-puffy">
                        <option value="">-- Pilih Pangkat --</option>
                        @foreach($jobTitles as $jt) <option value="{{ $jt->id }}">{{ $jt->name }}</option> @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="form-label-puffy">Departemen</label>
                        <select wire:model.live="department_id" class="form-select-puffy">
                            <option value="">-- Pilih Dept --</option>
                            @foreach($departments as $dept) <option value="{{ $dept->id }}">{{ $dept->name }}</option> @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label-puffy">Divisi</label>
                        <select wire:model="division_id" class="form-select-puffy">
                            <option value="">-- Pilih Divisi --</option>
                            @foreach($divisions as $div) <option value="{{ $div->id }}">{{ $div->name }}</option> @endforeach
                        </select>
                    </div>
                </div>
            </div>

        {{-- 3. KONDISI: JABATAN / PANGKAT --}}
        @elseif($tableId === 'job_titles')
            <div class="animate-in fade-in slide-in-from-top-4 duration-500">
                <label class="form-label-puffy">Section / Bidang</label>
                <input type="text" wire:model="section" placeholder="Contoh: Operasional, IT..."
                    class="w-full px-5 py-4 rounded-[1.5rem] bg-slate-950 border-slate-800 text-white focus:border-cyan-500 outline-none border">
            </div>

        {{-- 4. KONDISI: DIVISI --}}
        @elseif($tableId === 'divisions')
            <div class="animate-in fade-in slide-in-from-top-4 duration-500">
                <label class="form-label-puffy">Pilih Departemen</label>
                <select wire:model="department_id" class="w-full px-5 py-4 rounded-[1.5rem] bg-slate-950 border-slate-800 text-white focus:border-cyan-500 outline-none border">
                    <option value="">-- Pilih Departemen --</option>
                    @foreach($departments as $dept) <option value="{{ $dept->id }}">{{ $dept->name }}</option> @endforeach
                </select>
            </div>
        @endif
    </div>

    {{-- FOOTER --}}
                <x-slot:footer>
                    @if($isEditing)
                        <x-swal-confirm 
                            title="Hapus User?" 
                            text="Apakah Anda yakin ingin menghapus User {{ $name }}?"
                            callback="delete"
                            :id="$userId"
                            class="inline-flex items-center p-2 bg-rose-100 text-rose-600 hover:bg-rose-600 hover:text-white 
                                   dark:bg-rose-900/30 dark:text-rose-400 dark:hover:bg-rose-600 dark:hover:text-white rounded-lg transition-all">

                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" 
                            viewBox="0 0 24 24"><path fill="none" stroke="currentColor" 
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M4 7h16M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3m-5 5l4 4m0-4l-4 4"/></svg>
                        </x-swal-confirm>
                    @else
                        <div></div>
                    @endif

                    <div class="flex gap-2">
                        <x-action-button type="cancel" @click="onClose()">
                            @lang('general.label.cancel')
                        </x-action-button>

                        <x-action-button type="save" wire:click="save">
                            @lang('general.label.save')
                        </x-action-button>
                    </div>
                </x-slot:footer>
</x-ui.modal>