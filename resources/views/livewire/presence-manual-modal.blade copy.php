<div>
    <x-ui.modal>
        <div class="p-6 bg-white dark:bg-slate-900 rounded-2xl">
            
            <div class="grid grid-cols-1 md:grid-cols-2 my-4 gap-6">
                <div class="group" wire:ignore> {{-- Gunakan wire:ignore jika select2 sudah dihandle JS kustom --}}
                    <x-ui.label for="employeeId" required>
                        {{ __('general.label.name') }}
                    </x-ui.label>
                    <x-ui.select2 
                        name="employeeId"
                        id="employeeId"
                        wire:model.live="employeeId"
                        :options="collect($employees)->pluck('name', 'id')"
                        placeholder="{{ __('attendance.label.select_employee') }}"
                    />
                </div>
                <div class="group">
                    <x-ui.label for="position">
                        {{ __('employee.label.position') }}
                    </x-ui.label>
                    <input 
                        type="text" 
                        wire:model="position"
                        class="form-input-puffy bg-slate-50 cursor-not-allowed" 
                        disabled>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 my-4 gap-6">
                <div class="group" wire:key="workday-wrapper-{{ $employeeId }}">
                    <x-ui.label for="workDayId" required>
                        Jadwal Kerja (Workday)
                    </x-ui.label>
                    <x-ui.select2 
                        name="workDayId"
                        wire:model="workDayId"
                        :options="collect($workDays)->pluck('name', 'id')"
                        placeholder="Pilih Jadwal Kerja"
                    />
                </div>
                <div class="group" wire:key="workday-wrapper-{{ $employeeId }}">
                    <x-ui.label for="date" required>
                        {{ __('general.label.date') }}
                    </x-ui.label>
                    <x-ui.datepicker 
                        name="date" 
                        wire:model="date" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 my-4 gap-6">
                <div class="group">
                    <x-ui.label for="checkIn" required>
                        {{ __('attendance.label.check_in') }}
                    </x-ui.label>
                    <input 
                        type="time" 
                        step="1"
                        wire:model="checkIn"
                        class="form-input-puffy">
                </div>
                <div class="group">
                    <x-ui.label for="checkOut" required>
                        {{ __('attendance.label.check_out') }}
                    </x-ui.label>
                    <input 
                        type="time" 
                        step="1"
                        wire:model="checkOut"
                        class="form-input-puffy">
                </div>
            </div>

            <hr class="my-6 border-slate-100 dark:border-slate-800">

            <div class="mb-6">
                <div class="flex gap-4 overflow-x-auto pb-2 scrollbar-hide">
                    @php
                        $items = [
                            ['label' => 'Arrival', 'value' => $arrival, 'icon' => 'ri-timer-line', 'color' => 'text-blue-500'],
                            ['label' => 'Check In', 'value' => $start, 'icon' => 'ri-login-box-line', 'color' => 'text-tosca-500'],
                            ['label' => 'Check Out', 'value' => $end, 'icon' => 'ri-logout-box-line', 'color' => 'text-tosca-500'],
                            ['label' => 'Istirahat', 'value' => $break_start, 'icon' => 'ri-cup-line', 'color' => 'text-emerald-500'],
                        ];
                    @endphp

                    @foreach ($items as $item)
                        <div class="min-w-[150px] p-4 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-800 transition-all hover:shadow-md text-center">
                            <div class="{{ $item['color'] }} mb-2">
                                <i class="{{ $item['icon'] }} text-2xl"></i>
                            </div>
                            <div class="text-slate-500 text-[10px] font-bold uppercase tracking-widest">{{ $item['label'] }}</div>
                            <div class="text-slate-800 dark:text-slate-200 font-bold text-sm">{{ $item['value'] ?? '--:--' }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div class="p-3 rounded-2xl border text-center transition-all {{ $lateCheckIn > 0 ? 'bg-amber-50 border-amber-200' : 'bg-slate-50 border-slate-100' }}">
                    <div class="text-amber-500 text-xs font-bold uppercase mb-1">Late CI</div>
                    <div class="text-slate-800 font-bold text-xs">{{ $lateCheckIn > 0 ? $lateCheckIn.' min' : 'On Time' }}</div>
                </div>
                <div class="p-3 rounded-2xl border text-center transition-all {{ $lateArrival ? 'bg-rose-50 border-rose-200' : 'bg-emerald-50 border-emerald-200' }}">
                    <div class="text-slate-500 text-xs font-bold uppercase mb-1 text-[10px]">Late Arrival</div>
                    <div class="{{ $lateArrival ? 'text-rose-600' : 'text-emerald-600' }} font-bold text-xs">{{ $lateArrival ? 'Ya' : 'Tidak' }}</div>
                </div>
                <div class="p-3 rounded-2xl border text-center transition-all {{ $checkOutEarly > 0 ? 'bg-rose-50 border-rose-200' : 'bg-slate-50 border-slate-100' }}">
                    <div class="text-rose-500 text-xs font-bold uppercase mb-1 text-[10px]">Early CO</div>
                    <div class="text-slate-800 font-bold text-xs">{{ $checkOutEarly > 0 ? $checkOutEarly.' min' : 'Normal' }}</div>
                </div>
            </div>

            <div class="flex items-center justify-between mt-8">
                <div>
                    @if($isEditing)
                        <x-swal-confirm 
                            title="Hapus Presensi?" 
                            text="Data akan dihapus permanen"
                            callback="delete"
                            :id="$presenceId"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white rounded-xl font-bold text-sm transition-all border border-rose-100">
                            <i class="ri-delete-bin-fill"></i>
                            <span>Hapus</span>
                        </x-swal-confirm>
                    @endif
                </div>

                <div class="flex gap-3">
                    <button class="px-6 py-2 text-sm font-bold text-slate-500 hover:bg-slate-100 rounded-xl transition-all" wire:click="$dispatch('closeModal')">
                        Batal
                    </button>
                    <button class="px-8 py-2 bg-tosca-500 hover:bg-tosca-600 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-tosca-500/30" wire:click="save">
                        Simpan Data
                    </button>
                </div>
            </div>

        </div>
    </x-ui.modal>
</div>