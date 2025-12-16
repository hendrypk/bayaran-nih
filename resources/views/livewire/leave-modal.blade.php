<div>
    <x-ui.modal id="leave-modal">

        <div class="p-4 bg-white rounded-4 shadow-sm border">

            <div class="row g-3">

                {{-- EMPLOYEE --}}
                <div class="col-col-12">
                    <label class="form-label text-name small fw-semibold">
                        {{ __('general.label.name') }}
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="ri-user-line"></i>
                        </span>
                        <select class="form-select" wire:model="employeeId">
                            <option value="">
                                {{ __('attendance.label.select_employee') }}
                            </option>
                        @foreach ($employees as $emp)
                            <option value="{{ $emp['id'] }}">
                                {{ $emp['name'] }} ({{ $emp['eid'] }})
                            </option>
                        @endforeach
                        </select>
                    </div>
                </div>

                {{-- CATEGORY --}}
                <div class="col-col-12">
                    <label class="form-label text-muted small fw-semibold">
                        {{ __('general.label.category') }}
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="ri-price-tag-3-line"></i>
                        </span>
                        <select class="form-select" wire:model="category">
                            <option value="">
                                {{ __('general.label.select_category') }}
                            </option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat }}">
                                    {{ ucfirst($cat) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- DATE --}}
                <div class="col-col-12">
                    <label class="form-label text-muted small fw-semibold">
                        {{ __('general.label.date') }}
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="ri-calendar-line"></i>
                        </span>
                        <input type="date"
                               class="form-control"
                               wire:model="date">
                    </div>
                </div>

                {{-- NOTE --}}
                <div class="col-col-12">
                    <label class="form-label text-muted small fw-semibold">
                        {{ __('general.label.note') }}
                    </label>
                    <textarea class="form-control rounded-3"
                              rows="3"
                              wire:model.defer="note"
                              placeholder="{{ __('general.label.note') }}"></textarea>
                </div>

                @if($isEditing)
                {{-- STATUS CARDS --}}
                <div class="col-col-12">
                    <label class="form-label text-muted small fw-semibold">
                        {{ __('general.label.status') }}
                    </label>
                    <div class="d-flex gap-2">

                        {{-- Pending --}}
                        <div wire:click="$set('status', 'pending')"
                            class="cursor-pointer px-4 py-2 rounded-3 shadow-sm border
                                {{ $status === 'pending' ? 'bg-success text-white border-success' : 'bg-light text-success border-transparent' }}">
                            <i class="ri-time-line me-1"></i> Pending
                        </div>

                        {{-- Accepted --}}
                        <div wire:click="$set('status', 'accepted')"
                            class="cursor-pointer px-4 py-2 rounded-3 shadow-sm border
                                {{ $status === 'accepted' ? 'bg-primary text-white border-primary' : 'bg-light text-primary border-transparent' }}">
                            <i class="ri-check-line me-1"></i> Accepted
                        </div>

                        {{-- Rejected --}}
                        <div wire:click="$set('status', 'rejected')"
                            class="cursor-pointer px-4 py-2 rounded-3 shadow-sm border
                                {{ $status === 'rejected' ? 'bg-danger text-white border-danger' : 'bg-light text-danger border-transparent' }}">
                            <i class="ri-close-line me-1"></i> Rejected
                        </div>

                    </div>
                </div>


                @endif

            </div>
        </div>

        {{-- ACTION --}}
        <div class="d-flex justify-content-between align-items-center mt-3">
                @if($isEditing)
                    <x-swal-confirm 
                        title="Hapus Ijin Karyawan?" 
                        text="Apakah Anda yakin ingin menghapus Ijin Karyawan?"
                        callback="delete"
                        :id="$leaveId"
                        class="btn btn-red btn-sm">
                        <i class="ri-delete-bin-fill"></i>
                    </x-swal-confirm>
                @else
                <div></div>
                @endif

                <div class="d-flex gap-2">
                    <button class="btn btn-untosca" wire:click="$dispatch('closeModal')">
                        @lang('general.label.cancel')
                    </button>
                    <button class="btn btn-tosca btn-sm" wire:click="save">
                        @lang('general.label.save')
                    </button>
                </div>
            </div>
            
    </x-ui.modal>
</div>
