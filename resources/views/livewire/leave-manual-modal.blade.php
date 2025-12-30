<x-ui.modal id="leave-manual-modal" size="md">
    <x-slot name="title">
        {{ __('attendance.label.add_leave') }}
    </x-slot>

    <div class="p-6 space-y-5">
        {{-- Input Nama Karyawan --}}
        <div class="space-y-2">
            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">
                {{ __('general.label.name') }}
            </label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <iconify-icon icon="lucide:users" width="18"></iconify-icon>
                </span>
                <select wire:model="employee_id" class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl focus:ring-2 focus:ring-tosca-500 outline-none transition-all appearance-none font-bold text-slate-700 dark:text-slate-200">
                    <option value="">{{ __('attendance.label.select_employee') }}</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->name }} - {{ $employee->eid }}</option>
                    @endforeach
                </select>
            </div>
            @error('employee_id') <span class="text-[10px] text-rose-500 font-bold ml-1">{{ $message }}</span> @enderror
        </div>

        {{-- Input Tanggal (Multiple Dates) --}}
        <div class="space-y-2" wire:ignore>
            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">
                {{ __('general.label.date') }}
            </label>
            <div class="relative" 
                 x-data="{ 
                    init() { 
                        flatpickr($refs.date, { 
                            mode: 'multiple', 
                            dateFormat: 'Y-m-d',
                            onChange: (selectedDates, dateStr) => {
                                @this.set('leave_dates', dateStr);
                            }
                        }) 
                    } 
                 }">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <iconify-icon icon="lucide:calendar" width="18"></iconify-icon>
                </span>
                <input type="text" x-ref="date" placeholder="Pilih satu atau beberapa tanggal..." readonly
                    class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl focus:ring-2 focus:ring-tosca-500 outline-none transition-all font-bold text-slate-700 dark:text-slate-200 cursor-pointer">
            </div>
        </div>

        {{-- Input Kategori --}}
        <div class="space-y-2">
            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">
                {{ __('general.label.category') }}
            </label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <iconify-icon icon="lucide:tag" width="18"></iconify-icon>
                </span>
                <select wire:model="category" class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl focus:ring-2 focus:ring-tosca-500 outline-none transition-all appearance-none font-bold text-slate-700 dark:text-slate-200">
                    <option value="">{{ __('general.label.select_category') }}</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
            </div>
            @error('category') <span class="text-[10px] text-rose-500 font-bold ml-1">{{ $message }}</span> @enderror
        </div>

        {{-- Input Catatan --}}
        <div class="space-y-2">
            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">
                {{ __('general.label.note') }}
            </label>
            <textarea wire:model="note" rows="3" placeholder="Alasan cuti/izin..."
                class="w-full px-4 py-3 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl focus:ring-2 focus:ring-tosca-500 outline-none transition-all font-medium text-slate-700 dark:text-slate-200 resize-none"></textarea>
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
    </div>
</x-ui.modal>