<div class="p-6">
    <form wire:submit.prevent="save" class="space-y-6">
        
        <div>
            <x-ui.label for="employeeId" class="mb-2 inline-block font-bold">
                {{ __('general.label.name') }} <span class="text-rose-500">*</span>
            </x-ui.label>
                    <x-ui.select2 
                        name="employeeId"
                        id="employeeId"
                        wire:model.live="employeeId"
                        :options="collect($employees)->pluck('name', 'id')"
                        placeholder="{{ __('attendance.label.select_employee') }}"
                    />
            @error('employeeId') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div wire:key="{{ $employeeId }}">
                <x-ui.label class="mb-2 inline-block font-bold">Tanggal Lembur</x-ui.label>
                    <x-ui.datepicker 
                        name="date" 
                        wire:model="date" />
                @error('date') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <x-ui.label class="mb-2 inline-block font-bold">Mulai</x-ui.label>

                    <input 
                        type="time" 
                        wire:model.live="start"
                        class="form-input-puffy">
                </div>
                <div>
                    <x-ui.label class="mb-2 inline-block font-bold">Selesai</x-ui.label>
                    
                    <input 
                        type="time" 
                        wire:model.live="end"
                        class="form-input-puffy">
                </div>
            </div>
        </div>

        <div>
            <x-ui.label class="mb-2 inline-block font-bold">Keterangan / Alasan</x-ui.label>
            <textarea wire:model.live="note" rows="3" 
                      placeholder="Tuliskan detail pekerjaan lembur..."
                      class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-tosca-500 outline-none transition-all resize-none"></textarea>
            @error('note') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
        </div>

        @if($start && $end)
        <div class="p-4 bg-tosca-50 dark:bg-tosca-900/20 border border-tosca-100 dark:border-tosca-800 rounded-xl flex justify-between items-center">
            <span class="text-sm text-tosca-700 dark:text-tosca-400 font-medium italic">Estimasi Durasi:</span>
            <span class="text-lg font-bold text-tosca-600 dark:text-tosca-400">
                {{ $this->calculateDuration() }} 
            </span>
        </div>
        @endif

        <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100 dark:border-slate-800">
            <button type="button" 
                    x-on:click="$dispatch('close-modal')" 
                    class="px-6 py-2.5 text-sm font-bold text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-all">
                Batal
            </button>
            <button type="submit" 
                    wire:loading.attr="disabled"
                    class="px-10 py-2.5 bg-tosca-500 hover:bg-tosca-600 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-tosca-500/30 flex items-center gap-2">
                <span wire:loading.remove>Simpan Lembur</span>
                <span wire:loading class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Memproses...
                </span>
            </button>
        </div>
    </form>
</div>