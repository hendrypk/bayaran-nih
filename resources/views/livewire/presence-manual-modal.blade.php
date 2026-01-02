<div>
    <x-ui.modal title="{{ $isEditing ? 'Edit Presensi' : 'Presensi Manual' }}" size="max-w-2xl">
        <div class="space-y-8 p-1">
            
            <div class="bg-slate-50/50 dark:bg-slate-800/30 rounded-3xl border border-slate-100 dark:border-slate-800/50 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="group" wire:ignore>
                        <x-ui.label class="">Karyawan</x-ui.label>
                        <x-ui.select2 
                            name="employeeId"
                            wire:model.live="employeeId"
                            :options="collect($employees)->pluck('name', 'id')"
                            placeholder="Pilih Karyawan"
                        />
                    </div>
                    <div>
                        <x-ui.label class="">Jabatan</x-ui.label>
                        <input type="text" wire:model="position" class="form-input-puffy bg-slate-100/50 dark:bg-slate-900/50 border-none cursor-not-allowed opacity-60 italic" disabled>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div wire:key="workday-{{ $employeeId }}">
                        <x-ui.label class="">Jadwal Kerja</x-ui.label>
                        <x-ui.select2 
                            name="workDayId"
                            wire:model.live="workDayId"
                            :options="collect($workDays)->pluck('name', 'id')"
                            placeholder="Pilih Jadwal"
                        />
                    </div>
                    <div wire:ignore>
                        <x-ui.label class="">Tanggal</x-ui.label>
                        <x-ui.datepicker name="date" wire:model.live="date" />
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <div class="space-y-4">
                    <div class="flex-col gap-4">
                        <div class="flex-1">
                            <x-ui.label class="">Jam Masuk</x-ui.label>
                            <input type="time" step="1" wire:model.live="checkIn" class="form-input-puffy text-lg font-black tracking-widest">
                        </div>
                        <div class="flex-1">
                            <x-ui.label class="">Jam Pulang</x-ui.label>
                            <input type="time" step="1" wire:model.live="checkOut" class="form-input-puffy text-lg font-black tracking-widest">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-3 md:grid-cols-1 gap-2">
                    <div class="flex items-center justify-between p-3 rounded-2xl {{ $lateCheckIn > 0 ? 'bg-rose-50 dark:bg-rose-900/10 border-rose-100' : 'bg-slate-50 dark:bg-slate-800/50 border-transparent' }} border transition-all">
                        <div class="flex items-center gap-2">
                            <iconify-icon icon="lucide:clock" class="{{ $lateCheckIn > 0 ? 'text-rose-500' : 'text-slate-400' }}"></iconify-icon>
                            <span class="text-[10px] font-black uppercase text-slate-500">Telat</span>
                        </div>
                        <span class="text-xs font-black {{ $lateCheckIn > 0 ? 'text-rose-600' : 'text-slate-400' }}">{{ $lateCheckIn > 0 ? $lateCheckIn.'m' : '0m' }}</span>
                    </div>

                    <div class="flex items-center justify-between p-3 rounded-2xl {{ $checkOutEarly > 0 ? 'bg-amber-50 dark:bg-amber-900/10 border-amber-100' : 'bg-slate-50 dark:bg-slate-800/50 border-transparent' }} border transition-all">
                        <div class="flex items-center gap-2">
                            <iconify-icon icon="lucide:arrow-left-circle" class="{{ $checkOutEarly > 0 ? 'text-amber-500' : 'text-slate-400' }}"></iconify-icon>
                            <span class="text-[10px] font-black uppercase text-slate-500">Early</span>
                        </div>
                        <span class="text-xs font-black {{ $checkOutEarly > 0 ? 'text-amber-600' : 'text-slate-400' }}">{{ $checkOutEarly > 0 ? $checkOutEarly.'m' : '0m' }}</span>
                    </div>

                    <div class="flex items-center justify-between p-3 rounded-2xl {{ $lateArrival ? 'bg-rose-50 border-rose-100' : 'bg-emerald-50 border-emerald-100' }} border dark:bg-opacity-10 transition-all">
                        <div class="flex items-center gap-2">
                            <iconify-icon icon="{{ $lateArrival ? 'lucide:alert-octagon' : 'lucide:check-circle' }}" class="{{ $lateArrival ? 'text-rose-500' : 'text-emerald-500' }}"></iconify-icon>
                            <span class="text-[10px] font-black uppercase text-slate-500 text-center">Status</span>
                        </div>
                        <span class="text-[10px] font-black {{ $lateArrival ? 'text-rose-600' : 'text-emerald-600' }}">{{ $lateArrival ? 'LATE' : 'OK' }}</span>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
                @foreach ([
                    ['label' => 'Batas Masuk', 'value' => $start, 'icon' => 'lucide:log-in', 'color' => 'cyan'],
                    ['label' => 'Mulai Break', 'value' => $break_start, 'icon' => 'lucide:coffee', 'color' => 'emerald'],
                    ['label' => 'Batas Pulang', 'value' => $end, 'icon' => 'lucide:log-out', 'color' => 'rose'],
                    ['label' => 'Arrival', 'value' => $arrival, 'icon' => 'lucide:timer', 'color' => 'blue'],
                ] as $item)
                    <div class="flex-1 min-w-[110px] p-3 rounded-2xl bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 shadow-sm text-center">
                        <div class="text-{{ $item['color'] }}-500 mb-1 flex justify-center">
                            <iconify-icon icon="{{ $item['icon'] }}" width="18"></iconify-icon>
                        </div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-tighter">{{ $item['label'] }}</p>
                        <p class="text-xs font-bold text-slate-800 dark:text-slate-200">{{ $item['value'] ?? '--:--' }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        @if($isEditing)
            <x-slot:footer_left>
                <x-swal-confirm 
                    title="Hapus Data?" 
                    text="Tindakan ini permanen."
                    callback="delete"
                    class="bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase transition-all"
                    :id="$presenceId" 
                />
            </x-slot:footer_left>
        @endif
    </x-ui.modal>
</div>