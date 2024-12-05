@extends('_employee_app._layout_employee.main')
@section('header.title', 'History')
@include('_employee_app._layout_employee.header')
@section('content')
<div class="presence">
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        {{-- <th>No</th> --}}
                        <th>Date</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Late Arrival</th>
                        <th>Late Check In</th>
                        <th>Check Out Early</th>
                    </tr>
                </thead>
                <tbody>
                    
                    
                    @foreach($presences as $no=>$presence)
                    <tr>
                        {{-- <td>{{ $no+1 }}</td> --}}
                        <td>{{ $presence->date }}</td>
                        <td>{{ $presence->check_in }}</td>
                        <td>{{ $presence->check_out ?? '-' }}</td>
                        <td>{{ $presence->late_arrival == 1 ? 'Late' : "On Time" }}</td>
                        <td>{{ $presence->late_check_in}}</td>
                        <td>{{ $presence->check_out_early ?? '0' }}</td>
                    </tr>    
                    @endforeach
                    
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection