<div class="row">
    <h5 class="card-title">
        @if($isEditing)
            {{ __('performance.label.edit_employee_kpi') }}
        @else
            {{ __('performance.label.add_new_employee_kpi') }}
        @endif
    </h5>
    <form wire:submit.prevent="save" method="POST">
        @csrf @method('POST')
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
                <select class="select-form" wire:model="month">
                    @foreach(range(1, 12) as $m)
                        @php 
                            $monthName = DateTime::createFromFormat('!m', $m)->format('F');
                        @endphp
                        <option value="{{ $monthName }}">{{ $monthName }}</option>
                   @endforeach
                </select>
            </div>
            
            <div class="col-2">
                <label class="form-label">{{ __('general.label.year') }}</label>
                <select class="select-form" wire:model="year">
                    @foreach(range(date('Y') - 1, date('Y') + 5) as $y)
                    <option value="{{ $y }}">{{ $y }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col mb-3">
            <label for="" class="form-label">@lang('performance.label.kpi_name') : <span>{{$kpiName}}</span></label>
        </div>
        <div class="col">
            @if($kpis && $kpis->count())
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">@lang('performance.label.aspect')</th>
                        <th class="text-center">@lang('performance.label.description')</th>
                        <th class="text-center">@lang('performance.label.target')</th>
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
                        <td class="text-center">{{ formatNumber($kpi->target ?? '—') }}</td>
                        <td class="text-center">{{ formatPercent($kpi->weight ?? '—') }}</td>
                        <td class="text-center">
                            <input type="number" 
                            class="form-control"
                            wire:model.lazy="achievement.{{ $index }}"
                            min="0"
                            step="0.01">
                        </td>
                        <td class="text-center">{{ $result[$index] ?? '0.00' }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-secondary">
                    <tr>
                        <th colspan="5" class="text-end">@lang('performance.label.grade')</th>
                        <th class="text-center">{{ $this->grade }}</th>
                    </tr>
                </tfoot>
            </table>
            @else
            <p class="text-muted">Tidak ada KPI untuk employee ini.</p>
            @endif
        </div>                  
        <div class="row mb-2 mt-3 justify-content-end">
            <div class="d-grid gap-2 col-2">
                <a href="{{ url()->previous() }}" class="btn btn-red">{{ __('general.label.back') }}</a>
            </div>
            <div class="d-grid gap-2 col-2">
                <button type="submit" class="btn btn-tosca">{{ __('general.label.save') }}</button>
            </div>
        </div>
    </form>
</div>