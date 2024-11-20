@extends('_layout.main')
@section('title', 'Presence Summary')
@section('content')

<div class="row">
    <x-date-filter action="{{ route('presenceSummary.list') }}" 
                    :startDate="request()->get('start_date')" 
                    :endDate="request()->get('end_date')" />

    <div class="col-md">
        <div class="card">
            <div class="card-body">
                <div class="card-header d-flex align-items-center py-0">
                    <h5 class="card-title mb-0 py-3">Presence Summary</h5>
                </div>
                <table class="table datatable table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">EID</th>
                            <th scope="col">Employee Name</th>
                            <th scope="col">Presence</th>
                            <th scope="col">Annual Leave</th>
                            <th scope="col">Sick</th>
                            <th scope="col">Permit</th>
                            <th scope="col">Alpha</th>
                            <th scope="col">Total Overtime</th>
                            <th scope="col">Total Late Arrival</th>
                            <th scope="col">Total Late Check In</th>
                            <th scope="col">Total Check Out Early</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $no=>$employee)
                            <tr>
                                <td>{{ $no+1 }}</td>
                                <td>{{ $employee->eid }}</td>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->presence }}</td>
                                <td>{{ $employee->annual_leave }}</td>
                                <td>{{ $employee->sick_leave }}</td>
                                <td>{{ $employee->permit_leave }}</td>
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