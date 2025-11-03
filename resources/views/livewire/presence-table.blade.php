<div class="card-table-wrapper">
    <table class="table datatable table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('employee.label.eid') }}</th>
                <th>{{ __('general.label.name') }}</th>
                <th>{{ __('attendance.label.work_day') }}</th>
                <th>{{ __('general.label.date') }}</th>
                <th>{{ __('attendance.label.check_in') }}</th>
                <th>{{ __('attendance.label.check_out') }}</th>
                <th>{{ __('attendance.label.late_arrival') }}</th>
                <th>{{ __('attendance.label.late_check_in') }}</th>
                <th>{{ __('attendance.label.check_out_early') }}</th>
                <th>{{ __('general.label.edit') }}</th>
                <th>{{ __('general.label.delete') }}</th>
            </tr>
        </thead>
        <tbody>
        @if($status === 'absence')
            @foreach($absences as $no => $item)
                {{-- @foreach ($allDates as $date) --}}
                        <tr>
                            <th scope="row">{{ $no + 1 }}</th>
                            <td>{{ $item['employee']->eid ?? '-' }}</td>
                            <td>{{ $item['employee']->name ?? '-' }}</td>
                            <td>
                                @if($item['employee']->workDay && $item['employee']->workDay->count())
                                    {{ $item['employee']->workDay->pluck('name')->join(', ') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($item['date'])->format('j M Y') }}</td>
                            <td colspan="" class="text-center text-muted">Belum check in</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    
                {{-- @endforeach --}}
            @endforeach
        @else
            @foreach($presences as $no => $data)
                <tr class="{{ $data['created_at'] != $data['updated_at'] ? 'row-edited' : '' }}">
                    <th scope="row">{{ $no + 1 }}</th>
                    <td>{{ $data->employee->eid ?? '-' }}</td>
                    <td>{{ $data->employee->name ?? '-' }}</td>
                    <td>{{ $data->workDay->name ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($data['date'])->format('d F Y') }}</td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-link p-0"
                           onclick="showLocationAndPhoto('Check-in','{{ $data['location_in'] }}','{{ $data->getFirstMediaUrl('presence-in') }}')">
                           {{ $data->check_in }}
                        </a>
                    </td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-link p-0"
                           onclick="showLocationAndPhoto('Check-out','{{ $data['location_out'] }}','{{ $data['photo_in_url'] }}')">
                           {{ $data->check_out }}
                        </a>
                    </td>
                    <td>
                        @if($data->late_arrival == 1)
                            {{ __('attendance.label.late') }}
                        @else
                            {{ __('attendance.label.ontime') }}
                        @endif
                    </td>
                    <td>{{ $data->late_check_in }}</td>
                    <td>{{ $data->check_out_early }}</td>
                    <td>
                        @can('update presence')
                            <button type="button" class="btn btn-green" data-bs-toggle="modal" data-bs-target="#editPresence"
                                data-id="{{ $data->id }}"
                                data-employee-id="{{ $data->employee->id ?? '' }}"
                                data-name="{{ $data->employee->name ?? '' }}"
                                data-date="{{ formatDate($data->date, 'd-m-Y') }}"
                                data-workDay="{{ $data->work_day_id }}"
                                data-workday-name="{{ $data->workDay->name ?? '' }}"
                                data-checkin="{{ $data->check_in }}"
                                data-checkout="{{ $data->check_out }}">
                                <i class="ri-edit-line"></i>
                            </button>
                        @endcan
                    </td>
                    <td>
                        @can('delete presence')
                            <button type="button" class="btn btn-red" onclick="confirmDelete({{ $data->id }}, '{{ addslashes($data->employee->name ?? '') }}', 'presences')">
                                <i class="ri-delete-bin-fill"></i>
                            </button>
                        @endcan
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>
