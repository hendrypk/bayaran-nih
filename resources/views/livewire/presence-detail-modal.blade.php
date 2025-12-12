<div>
    <x-ui.modal id="presenceDetailModal">
        <div class="row g-4">
            {{-- ========================== --}}
            {{-- LEFT: INFO PRESENSI --}}
            {{-- ========================== --}}
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-header bg-primary text-white fw-bold rounded-top-4">
                        Info Presensi
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="{{ route('employee.detail', $employeeId) }}" 
                                class="text-decoration-none text-dark d-flex align-items-center">
                                    <i class="ri-user-line me-2"></i>Nama
                                </a>
                                <a href="{{ route('employee.detail', $employeeId) }}" 
                                class="fw-bold text-decoration-none text-primary">
                                    {{ $name ?? '-' }}
                                </a>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="ri-id-card-line me-2"></i>EID</span>
                                <span class="fw-bold">{{ $eid ?? '-' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="ri-briefcase-line me-2"></i>Jabatan</span>
                                <span class="fw-bold">{{ $position ?? '-' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="ri-calendar-line me-2"></i>Tanggal</span>
                                <span class="fw-bold">{{ $date ?? '-' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="ri-login-box-line me-2"></i>Check In</span>
                                <span class="badge bg-success">{{ $checkInTime ?? '-' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="ri-logout-box-line me-2"></i>Check Out</span>
                                <span class="badge bg-danger">{{ $checkOutTime ?? '-' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="ri-timer-line me-2"></i>Telat</span>
                                <span class="fw-bold">{{ $lateCheckIn ?? 0 }} menit</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="ri-time-line me-2"></i>Check Out Early</span>
                                <span class="fw-bold">{{ $checkOutEarly ?? 0 }} menit</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="ri-alert-line me-2"></i>Telat datang</span>
                                <span class="badge {{ $lateArrival ? 'bg-warning text-dark' : 'bg-success' }}">
                                    {{ $lateArrival ? 'Ya' : 'Tidak' }}
                                </span>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

            {{-- ========================== --}}
            {{-- RIGHT: FOTO & MAP DENGAN TABS --}}
            {{-- ========================== --}}
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-header bg-success text-white fw-bold rounded-top-4">
                        Aktivitas
                    </div>
                    <div class="card-body">
                        {{-- Tabs --}}
                        <ul class="nav nav-tabs" id="presenceTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="checkin-tab" data-bs-toggle="tab" 
                                    data-bs-target="#checkin" type="button" role="tab">Check In</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="checkout-tab" data-bs-toggle="tab" 
                                    data-bs-target="#checkout" type="button" role="tab">Check Out</button>
                            </li>
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="presenceTabContent">
                            {{-- Check In --}}
                            <div class="tab-pane fade show active" id="checkin" role="tabpanel">
                                <div class="row">
                                    
                                    {{-- FOTO --}}
                                    <div class="col-md-6">
                                        <div class="fw-bold">Foto Check In</div>
                                        <img src="{{ $checkInPhoto }}" 
                                            class="img-fluid rounded-3 shadow-sm w-100"
                                            style="height: 300px; object-fit: cover;">
                                    </div>

                                    {{-- MAP --}}
                                    <div class="col-md-6">
                                        <div class="fw-bold">Lokasi Check In (Map)</div>
                                        <div id="mapCheckIn" 
                                            style="height: 300px; width: 100%; border-radius: 10px;" 
                                            class="shadow-sm"></div>
                                    </div>

                                </div>
                            </div>


                            {{-- Check Out --}}
                            <div class="tab-pane fade show" id="checkout" role="tabpanel">
                                <div class="row">
                                    
                                    {{-- FOTO --}}
                                    <div class="col-md-6">
                                        <div class="fw-bold">Foto Check In</div>
                                        <img src="{{ $checkOutPhoto }}" 
                                            class="img-fluid rounded-3 shadow-sm w-100"
                                            style="height: 300px; object-fit: cover;">
                                    </div>

                                    {{-- MAP --}}
                                    <div class="col-md-6">
                                        <div class="fw-bold">Lokasi Check In (Map)</div>
                                        <div id="mapCheckOut" 
                                            style="height: 300px; width: 100%; border-radius: 10px;" 
                                            class="shadow-sm"></div>
                                    </div>

                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>

            {{-- ========================== --}}
            {{-- FOOTER BUTTONS --}}
            {{-- ========================== --}}
            <div class="d-flex justify-content-between align-items-center mt-3">
                <x-swal-confirm 
                    title="Hapus Presensi?" 
                    text="Apakah Anda yakin ingin menghapus Presensi?"
                    callback="delete"
                    :id="$presenceId"
                    class="btn btn-red btn-sm">
                    <i class="ri-delete-bin-fill"></i>
                </x-swal-confirm>

                <div class="d-flex gap-2">
                    <button class="btn btn-untosca" wire:click="$dispatch('closeModal')">
                        @lang('general.label.cancel')
                    </button>
                    <button class="btn btn-tosca btn-sm" wire:click="save">
                        @lang('general.label.save')
                    </button>
                </div>
            </div>

        </div>
    </x-ui.modal>
</div>
