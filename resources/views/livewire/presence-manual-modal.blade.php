<div>
    <x-ui.modal>

        <div class="p-3 bg-white rounded-4 shadow-sm border">

            {{-- EMPLOYEE --}}
            <div class="mb-4">
                <label class="text-muted small fw-semibold mb-1">
                    {{ __('general.label.name') }}
                </label>

                <div class="input-group">
                    <span class="input-group-text bg-light">
                        <i class="ri-user-line"></i>
                    </span>

                    <select 
                        class="form-select rounded-end"
                        wire:model="employeeId"
                        wire:change="$set('employeeId', $event.target.value)"
                        required
                    >
                        <option value="">{{ __('attendance.label.select_employee') }}</option>
                        @foreach ($employees as $emp)
                            <option value="{{ $emp['id'] }}">
                                {{ $emp['name'] }} ({{ $emp['eid'] }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>


            {{-- GRID --}}
            <div class="row g-4">

                {{-- WORKDAY --}}
                <div class="col-md-6">
                    <label class="text-muted small fw-semibold mb-1">Workday</label>

                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="ri-calendar-schedule-line"></i>
                        </span>

                        <select 
                            class="form-select rounded-end"
                            wire:model="workDayId"
                            wire:change="$set('workDayId', $event.target.value)"
                            required
                        >
                            <option value="">Pilih Jadwal Kerja</option>
                            @foreach ($workDays as $wd)
                                <option value="{{ $wd['id'] }}">{{ $wd['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- DATE --}}
                <div class="col-md-6">
                    <label class="text-muted small fw-semibold mb-1">
                        {{ __('general.label.date') }}
                    </label>

                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="ri-calendar-line"></i>
                        </span>

                        <input 
                            type="date"
                            class="form-control rounded-end"
                            wire:model="date"
                            wire:change="$set('date', $event.target.value)"
                            max="{{ now()->format('Y-m-d') }}"
                            required
                        >
                    </div>
                </div>

                {{-- CHECK IN --}}
                <div class="col-md-6">
                    <label class="text-muted small fw-semibold mb-1">
                        {{ __('attendance.label.check_in') }}
                    </label>

                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="ri-login-circle-line"></i>
                        </span>

                        <input 
                            type="time"
                            step="1"
                            class="form-control rounded-end"
                            wire:model="checkIn"
                            wire:change="$set('checkIn', $event.target.value)"
                            required
                        >
                    </div>
                </div>

                {{-- CHECK OUT --}}
                <div class="col-md-6">
                    <label class="text-muted small fw-semibold mb-1">
                        {{ __('attendance.label.check_out') }}
                    </label>

                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="ri-logout-circle-line"></i>
                        </span>

                        <input 
                            type="time"
                            step="1"
                            class="form-control rounded-end"
                            wire:model="checkOut"
                            wire:change="$set('checkOut', $event.target.value)"
                            required
                        >
                    </div>
                </div>

                {{-- INFO BOX --}}
                <div class="col-12">
                    <div class="d-flex gap-2 flex-nowrap overflow-auto">

                        @php
                            $items = [
                                ['label' => 'Arrival', 'value' => $arrival, 'icon' => 'ri-timer-line', 'color' => 'info'],
                                ['label' => 'Check In', 'value' => $start, 'icon' => 'ri-login-box-line', 'color' => 'primary'],
                                ['label' => 'Check Out', 'value' => $end, 'icon' => 'ri-logout-box-line', 'color' => 'primary'],
                                ['label' => 'Istirahat Mulai', 'value' => $break_start, 'icon' => 'ri-cup-line', 'color' => 'success'],
                                ['label' => 'Istirahat Selesai', 'value' => $break_end, 'icon' => 'ri-cup-fill', 'color' => 'success'],
                            ];
                        @endphp

        @foreach ($items as $item)
            <div style="min-width: 140px">
                <div class="p-2 rounded-3 border bg-white shadow-sm text-center h-100">
                    <div class="text-{{ $item['color'] }} mb-1">
                        <i class="{{ $item['icon'] }} fs-4"></i>
                    </div>
                    <div class="text-muted small">{{ $item['label'] }}</div>
                    <div class="fw-semibold fs-6 text-nowrap">
                        {{ $item['value'] ?? '-' }}
                    </div>
                </div>
            </div>
        @endforeach

                    </div>
                </div>


                {{-- INFO BOX --}}
                <div class="col-12">
                    <div class="row g-2">

                        {{-- Late Check-in --}}
                        <div class="col-4">
                            <div class="p-2 rounded-3 border shadow-sm text-center h-100
                                {{ $lateCheckIn > 0 ? 'bg-warning-subtle border-warning' : 'bg-white' }}">
                                <div class="text-warning mb-1">
                                    <i class="ri-timer-line fs-4"></i>
                                </div>
                                <div class="text-muted small">Late Check-in</div>
                                <div class="fw-bold">
                                    {{ $lateCheckIn > 0 ? $lateCheckIn.' menit' : 'Tepat Waktu' }}
                                </div>
                            </div>
                        </div>

                        {{-- Late Arrival --}}
                        <div class="col-4">
                            <div class="p-2 rounded-3 border shadow-sm text-center h-100
                                {{ $lateArrival ? 'bg-danger-subtle border-danger' : 'bg-success-subtle border-success' }}">
                                <div class="{{ $lateArrival ? 'text-danger' : 'text-success' }} mb-1">
                                    <i class="ri-alarm-warning-line fs-4"></i>
                                </div>
                                <div class="text-muted small">Late Arrival</div>
                                <div class="fw-bold">
                                    {{ $lateArrival ? 'Ya' : 'Tidak' }}
                                </div>
                            </div>
                        </div>

                        {{-- Early Check-out --}}
                        <div class="col-4">
                            <div class="p-2 rounded-3 border shadow-sm text-center h-100
                                {{ $checkOutEarly > 0 ? 'bg-danger-subtle border-danger' : 'bg-white' }}">
                                <div class="text-danger mb-1">
                                    <i class="ri-timer-flash-line fs-4"></i>
                                </div>
                                <div class="text-muted small">Early Check-out</div>
                                <div class="fw-bold">
                                    {{ $checkOutEarly > 0 ? $checkOutEarly.' menit' : 'Normal' }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        {{-- BUTTONS --}}
        <div class="d-flex align-items-center mt-3">

            {{-- DELETE (kiri, hanya saat edit) --}}
            @if($isEditing)
                <div class="me-auto">
                    <x-swal-confirm 
                        title="Hapus Presensi?" 
                        text="Apakah Anda yakin ingin menghapus Presensi?"
                        callback="delete"
                        :id="$presenceId"
                        class="btn btn-red btn-sm">
                        <i class="ri-delete-bin-fill"></i>
                    </x-swal-confirm>
                </div>
            @endif

            {{-- ACTION BUTTON (kanan) --}}
            <div class="d-flex gap-2 ms-auto">
                <button class="btn btn-untosca btn-sm" wire:click="$dispatch('closeModal')">
                    @lang('general.label.cancel')
                </button>
                <button class="btn btn-tosca btn-sm" wire:click="save">
                    @lang('general.label.save')
                </button>
            </div>

        </div>

    </x-ui.modal>
</div>
