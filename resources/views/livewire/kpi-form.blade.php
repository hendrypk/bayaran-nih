<div>
    <x-ui.modal>
            <div class="row mb-3">
                <div class="col-3">
                    <label for="employee" class="form-label">{{ __('general.label.name') }}</label>
                    <select class="select-form" id="employee" wire:model="employeeId" wire:change="$set('employeeId', $event.target.value)">
                        <option value="">@lang('performance.placeholders.select_employee')</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2">
                    <label for="eid" class="form-label">{{ __('employee.label.eid') }}</label>
                    <input type="text" class="input-form" wire:model="eid" disabled readonly>
                </div>

                <div class="col-3">
                    <label for="position" class="form-label">{{ __('employee.label.job_title') }}</label>
                    <input type="text" class="input-form" wire:model="positionName" disabled readonly>  
                </div>
                <div class="col-2">
                    <label class="form-label">{{ __('general.label.month') }}</label>
                    <select class="select-form" wire:model="month" wire:change="$set('month', $event.target.value)">>
                        @foreach(range(1, 12) as $m)
                            @php 
                                $month = DateTime::createFromFormat('!m', $m)->format('n');
                                $monthName = DateTime::createFromFormat('!m', $m)->format('F');
                            @endphp
                            <option value="{{ $month }}">{{ $monthName }}</option>
                    @endforeach
                    </select>
                </div>
                
                <div class="col-2">
                    <label class="form-label">{{ __('general.label.year') }}</label>
                    <select class="select-form" wire:model="year" wire:change="$set('year', $event.target.value)">>
                        @foreach(range(date('Y') - 1, date('Y') + 5) as $y)
                        <option value="{{ $y }}">{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col mb-3">
                <label for="" class="form-label">@lang('performance.label.kpi_name') : <span>{{$kpiName}}</span></label>
            </div>
            <div class="col table-responsive">
                @if($kpis && $kpis->count())
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">@lang('performance.label.aspect')</th>
                            <th class="text-center">@lang('performance.label.description')</th>
                            <th class="text-center">@lang('performance.label.target')</th>
                            <th class="text-center">@lang('performance.label.unit')</th>
                            <th class="text-center">@lang('performance.label.weight')</th>
                            <th class="text-center">@lang('performance.label.achievement')</th>
                            <th class="text-center">@lang('performance.label.result')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kpis as $index => $kpi)
                        <tr>
                            <td class="text-center">{{ $kpi->aspect ?? '—' }}</td>
                            <td class="text-center">{{ $kpi->description ?? '—' }}</td>
                            <td class="text-center">
                                @if(strtolower($kpi->aspect) === 'kehadiran')
                                {{ formatNumber($effectiveDays) }}
                                @else
                                    {{ formatNumber($kpi->target) }}
                                @endif
                                
                            </td>
                            <td class="text-center">{{ $kpi->unit ?? '-' }}</td>
                            <td class="text-center">{{ formatPercent($kpi->weight ?? '—') }}</td>
                            <td class="text-center">
                                @if(strtolower($kpi->aspect) === 'kehadiran')
                                    <input type="number"
                                        class="form-control bg-light"
                                        value="{{ $presenceTotal }}"
                                        disabled>

                                    <input type="hidden"
                                        wire:model="achievement.{{ $index }}">
                                @else
                                    <input type="number" 
                                        class="form-control"
                                        wire:model.lazy="achievement.{{ $index }}"
                                        min="0"
                                        step="0.01">
                                @endif
                            </td>
                            <td class="text-center">{{ $result[$index] ?? '0.00' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-secondary">
                        <tr>
                            <th colspan="6" class="text-end">@lang('performance.label.grade')</th>
                            <th class="text-center">{{ $this->grade }}</th>
                        </tr>
                    </tfoot>
                </table>
                @else
                <p class="text-muted">Tidak ada KPI untuk employee ini.</p>
                @endif
            </div>  
            
            @if($isEditing)
            <div class="small mt-3 mb-2">
                <div class="d-flex">
                    <span class="fw-bold" style="width:130px;">@lang('general.label.created_by')</span>
                    <span>
                        : {{ $creator ?? '-' }} / 
                        {{ $created ? $created->format('d M Y H:i') : '-' }}
                    </span>
                </div>
                <div class="d-flex">
                    <span class="fw-bold" style="width:130px;">@lang('general.label.updated_by')</span>
                    <span>
                        : {{ $updater ?? '-' }} 
                        @if($updater && $updated)
                            / {{ $updated->format('d M Y H:i') }}
                        @endif
                    </span>
                </div>
            </div>
            @endif

            <div class="d-flex justify-content-between align-items-center">
                @if($isEditing)
                    <x-swal-confirm 
                        title="Hapus KPI Karyawan?" 
                        text="Apakah Anda yakin ingin menghapus KPI Karyawan?"
                        callback="delete"
                        :id="$kpiResult"
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