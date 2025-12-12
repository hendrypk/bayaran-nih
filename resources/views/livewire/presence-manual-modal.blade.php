<div>
    <x-ui.modal id="presence-manual-modal">

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
                    <div class="d-flex gap-2">

                        {{-- Late Check-in --}}
                        <div class="flex-fill p-1 rounded-3 shadow-sm bg-white border text-center">
                            <div class="text-primary mb-1">
                                <i class="ri-time-line fs-4"></i>
                            </div>
                            <div class="text-muted small">Late Check-in</div>
                            <div class="fw-bold">{{ $lateCheckIn }} menit</div>
                        </div>

                        {{-- Late Arrival --}}
                        <div class="flex-fill p-1 rounded-3 shadow-sm bg-white border text-center">
                            <div class="text-warning mb-1">
                                <i class="ri-timer-2-line fs-4"></i>
                            </div>
                            <div class="text-muted small">Late Arrival</div>
                            <div class="fw-bold">{{ $lateArrival ? 'Ya' : 'Tidak' }}</div>
                        </div>

                        {{-- Early Check-out --}}
                        <div class="flex-fill p-1 rounded-3 shadow-sm bg-white border text-center">
                            <div class="text-danger mb-1">
                                <i class="ri-timer-flash-line fs-4"></i>
                            </div>
                            <div class="text-muted small">Early Check-out</div>
                            <div class="fw-bold">{{ $checkOutEarly }} menit</div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        {{-- BUTTONS --}}
        <div class="d-flex justify-content-end mt-4">
            <button 
                type="button" 
                class="btn btn-outline-secondary px-4 me-2" 
                data-bs-dismiss="modal"
            >
                {{ __('general.label.cancel') }}
            </button>

            <button 
                type="button"
                wire:click="save"
                class="btn btn-tosca px-4"
            >
                {{ __('general.label.save') }}
            </button>
        </div>

    </x-ui.modal>
</div>
