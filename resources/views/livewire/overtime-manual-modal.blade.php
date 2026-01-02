<x-ui.modal>
    <div class="card-body-puffy">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                
                <div class="space-y-2" wire:ignore>
                    <x-ui.label for="employeeId" class="text-sm font-bold text-slate-700 dark:text-slate-200">
                        {{ __('general.label.name') }} <span class="text-rose-500">*</span>
                    </x-ui.label>
                    <x-ui.select2 
                        name="employeeId"
                        id="employeeId"
                        wire:model.live="employeeId"
                        :options="collect($employees)->pluck('name', 'id')"
                        placeholder="{{ __('attendance.label.select_employee') }}"
                    />
                </div>
                @error('employeeId') <p class="text-[11px] text-rose-500 font-medium mt-1">{{ $message }}</p> @enderror

                <div class="space-y-2" wire:ignore>
                    <x-ui.label class="text-sm font-bold text-slate-700 dark:text-slate-200">Tanggal Lembur</x-ui.label>
                    <x-ui.datepicker 
                        name="date" 
                        wire:model="date" 
                        class="w-full h-10" />
                </div>
                @error('date') <p class="text-[11px] text-rose-500 font-medium mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Bagian Waktu & Notes --}}
            <div class="bg-slate-50 dark:bg-slate-800/50 p-4 rounded-2xl border border-slate-100 dark:border-slate-700">
                <div class="flex flex-col md:flex-row md:items-center gap-4">
                    <div class="flex-1 space-y-2">
                        <x-ui.label class="text-xs uppercase tracking-wider text-slate-500 font-bold">Jam Mulai</x-ui.label>

                        <x-ui.input 
                            type="time"
                            step="1"
                            wire:model.live='start'
                            />
                    </div>

                    <div class="hidden md:flex items-center justify-center pt-6 text-slate-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" /></svg>
                    </div>

                    <div class="flex-1 space-y-2">
                        <x-ui.label class="text-xs uppercase tracking-wider text-slate-500 font-bold">Jam Selesai</x-ui.label>
                        <x-ui.input 
                            type="time"
                            step="1"
                            wire:model.live='end'
                            />
                    </div>
                </div>

                @if($start && $end)
                <div class="mt-4 flex items-center gap-3 px-4 py-2 bg-tosca-500/10 border border-tosca-500/20 rounded-xl">
                    <p class="text-xs font-bold text-tosca-700 dark:text-tosca-400">
                        Total Durasi: <span class="text-sm ml-1">{{ $this->duration() }}</span>
                    </p>
                </div>
                @endif
            </div>

            <div class="space-y-2">
                <x-ui.label class="text-sm font-bold text-slate-700 dark:text-slate-200">Keterangan / Alasan Lembur</x-ui.label>
                <x-ui.textarea 
                    wire:model.live.debounce.500ms="note" 
                    rows="3" 
                    placeholder="Apa yang dikerjakan selama lembur?"/>
                @error('note') <p class="text-[11px] text-rose-500 font-medium">{{ $message }}</p> @enderror
            </div>
        </div>
        @if($isEditing)
            <div class="pt-6 flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full {{ is_null($status) ? 'bg-amber-500 animate-pulse' : ($status == 1 ? 'bg-emerald-500' : 'bg-rose-500') }}"></div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                            Status Saat Ini: 
                            <span class="{{ is_null($status) ? 'text-amber-500' : ($status == 1 ? 'text-emerald-500' : 'text-rose-500') }}">
                                {{ is_null($status) ? 'Pending' : ($status == 1 ? 'Approved' : 'Rejected') }}
                            </span>
                        </p>
                    </div>
                    <p class="text-[9px] text-slate-400 mt-1 italic leading-none">*Klik Save Changes untuk menerapkan perubahan status</p>
                </div>
            </div>
        @endif
                @if($isEditing)
            <x-slot:footer_left>
                <div class="flex items-center gap-2">
                    <button type="button" wire:click="setStatus(0)" 
                        class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all
                        {{ $status === 0 ? 'bg-rose-600 text-white shadow-lg shadow-rose-200' : 'bg-rose-50 text-rose-600 hover:bg-rose-100' }}">
                        Reject
                    </button>

                    <button type="button" wire:click="setStatus(1)" 
                        class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all
                        {{ $status === 1 ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-200' : 'bg-emerald-50 text-emerald-600 hover:bg-emerald-100' }}">
                        Approve
                    </button>
                </div>
            </x-slot:footer_left>
        @endif
</x-ui.modal>