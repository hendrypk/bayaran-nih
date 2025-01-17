@extends('_layout.main')
@section('title', 'Presence Summary')
@section('content')


{{ Breadcrumbs::render('presence_summary') }}
<div class="row">
    <x-date-filter action="{{ route('presenceSummary.list') }}" 
                    :startDate="request()->get('start_date')" 
                    :endDate="request()->get('end_date')" />

    <div class="col-md">
        <div class="card">
            <div class="card-body">
                <div class="card-header d-flex align-items-center py-0">
                    <h5 class="card-title mb-0 py-3">{{ __('attendance.label.presence_summary') }}</h5>
                </div>
                <table class="table datatable table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ __('employee.label.eid') }}</th>
                            <th scope="col">{{ __('general.label.name') }}</th>
                            <th scope="col">{{ __('attendance.label.presence') }}</th>
                            <th scope="col">{{ __('attendance.label.holiday') }}</th>
                            <th scope="col">{{ __('attendance.label.annual_leave') }}</th>
                            <th scope="col">{{ __('attendance.label.sick') }}</th>
                            <th scope="col">{{ __('attendance.label.full_day_permit') }}</th>
                            <th scope="col">{{ __('attendance.label.half_day_permit') }}</th>
                            <th scope="col">{{ __('attendance.label.alpha') }}</th>
                            <th scope="col">{{ __('attendance.label.total_overtime') }}</th>
                            <th scope="col">{{ __('attendance.label.total_late_arrival') }}</th>
                            <th scope="col">{{ __('attendance.label.total_late_check_in') }}</th>
                            <th scope="col">{{ __('attendance.label.total_check_out_early') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $no=>$employee)
                            <tr>
                                <td>{{ $no+1 }}</td>
                                <td>{{ $employee->eid }}</td>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->presence }}</td>
                                <td>{{ $employee->holiday }}</td>
                                <td>{{ $employee->annual_leave }}</td>
                                <td>{{ $employee->sick_permit }}</td>
                                <td>{{ $employee->full_day_permit }}</td>
                                <td>{{ $employee->half_day_permit }}</td>
                                <td>{{ $employee->alpha }}</td>
                                <td>{{ $employee->total_overtime }}</td>
                                <td>{{ $employee->late_arrival }}</td>
                                <td>{{ $employee->late_check_in }}</td>
                                <td>{{ $employee->check_out_early }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection