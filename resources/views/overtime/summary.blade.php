@extends('_layout.main')
@section('title', 'Presence Summary')
@section('content')

<div class="row">

    <div class="col-md">
        <div class="card">
            <div class="card-body">
                <div class="card-header d-flex align-items-center py-0">
                    <h5 class="card-title mb-0 py-3">Presence Summary</h5>
                </div>
        
                <!-- Table with hoverable rows -->
                    <table class="table datatable table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">EID</th>
                                <th scope="col">Employee Name</th>
                                <th scope="col">Total Absence</th>
                                <th scope="col">Late Arrival</th>
                                <th scope="col">Late Check In</th>
                                <th scope="col">Total Late Check In</th>
                                <th scope="col">Total Overtime</th>
                                <th scope="col">Average Overtime</th>
                                <th scope="col">Average Working Hour</th>
                                <th scope="col">Total Check Out Early</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($employees as $no=>$employee)
                            <tr>
                                <th scope="row">{{ $no+1 }}</th>
                                <td>{{ $employee->eid }}</td>
                                <td>{{ $employee->name }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{ $totalOvertime }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                <!-- End Table with hoverable rows -->
            </div>
        </div>
    </div>
</div>

@endsection
@include('sales.add')