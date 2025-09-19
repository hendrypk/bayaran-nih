@php
    use Carbon\Carbon;

    // Default: tanggal 1 bulan ini sampai hari ini
    $defaultStartDate = Carbon::now()->startOfMonth()->format('Y-m-d');
    $defaultEndDate   = Carbon::now()->format('Y-m-d');

    // Kalau ada filter tanggal dari user, pakai itu. 
    // Kalau kosong/null, fallback ke default.
    $startDate = !empty($startDate) ? $startDate : $defaultStartDate;
    $endDate   = !empty($endDate) ? $endDate   : $defaultEndDate;

    // Helper untuk generate array tanggal dari startDate ke endDate
    function dateRange($start, $end) {
        $dates = [];
        $current = Carbon::parse($start);
        $last    = Carbon::parse($end);
        while ($current->lte($last)) {
            $dates[] = $current->format('Y-m-d');
            $current->addDay();
        }
        return $dates;
    }

    $absenceDates = ($filter === 'absence' && $startDate && $endDate) 
        ? dateRange($startDate, $endDate) 
        : [];

    $row = 1;
@endphp



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
        @if($filter === 'absence')
            @foreach($absenceDates as $tgl)
                @foreach($employees as $employee)
                    @php
                        // Cek apakah employee punya presence pada tanggal ini
                        $hasPresence = $employee->presences->where('date', $tgl)->isNotEmpty();
                    @endphp
                    @if(!$hasPresence)
                        <tr>
                            <th scope="row">{{ $row++ }}</th>
                            <td>{{ $employee->eid ?? '-' }}</td>
                            <td>{{ $employee->name ?? '-' }}</td>
                            <td>
                                @if($employee->workDay && $employee->workDay->count())
                                    {{ $employee->workDay->pluck('name')->join(', ') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($tgl)->format('j M Y') }}</td>
                            <td colspan="" class="text-center text-muted">Belum check in</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endif
                @endforeach
            @endforeach
        @else
            @foreach($presences as $no => $data)
                <tr class="{{ $data->created_at != $data->updated_at ? 'row-edited' : '' }}">
                    <th scope="row">{{ $no + 1 }}</th>
                    <td>{{ $data->employee->eid ?? '-' }}</td>
                    <td>{{ $data->employee->name ?? '-' }}</td>
                    <td>{{ $data->workDay->name ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($data->date)->format('d F Y') }}</td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-link p-0"
                           onclick="showLocationAndPhoto('Check-in','{{ $data->location_in }}','{{ $data->getFirstMediaUrl('presence-in') }}')">
                           {{ $data->check_in }}
                        </a>
                    </td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-link p-0"
                           onclick="showLocationAndPhoto('Check-out','{{ $data->location_out }}','{{ $data->getFirstMediaUrl('presence-out') }}')">
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

    <script>
document.getElementById('employeeSelect').addEventListener('change', function () {
    var employeeId = this.value; 
    var workDays = @json($workDays);
    var workDaySelect = document.getElementById('workDaySelect');
    var workDayContainer = document.getElementById('workDayContainer');

    // Clear previous options
    workDaySelect.innerHTML = '<option selected disabled>Select Work Day</option>';

    // Cek jika employee_id ada di workDays
    if (employeeId && workDays[employeeId]) {
        var selectedWorkDays = workDays[employeeId];

        // Check if there is more than one work day
        if (selectedWorkDays.length > 1) {
            selectedWorkDays.forEach(function(workDay) {
                var option = document.createElement('option');
                option.value = workDay.id; // Set the value to the ID
                option.text = workDay.name; // Display the name
                workDaySelect.appendChild(option);
            });
            workDaySelect.disabled = false; // Enable selection
            workDayContainer.style.display = 'block';
        } else if (selectedWorkDays.length === 1) {
            // If there's only one work day, set its value and keep it enabled
            workDaySelect.value = selectedWorkDays[0].id; // Set to the ID
            workDaySelect.innerHTML = ''; // Clear previous options
            var option = document.createElement('option');
            option.value = selectedWorkDays[0].id; // Set the value
            option.text = selectedWorkDays[0].name; // Display the name
            workDaySelect.appendChild(option);
            workDaySelect.disabled = false; // Keep it enabled
            workDayContainer.style.display = 'block';
        } else {
            workDayContainer.style.display = 'block'; // No work days
        }
    } else {
        workDayContainer.style.display = 'block'; // No employee selected
    }
});
    </script>
</div>
