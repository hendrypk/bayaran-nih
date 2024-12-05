@extends('_employee_app._layout_employee.main')
@section('header.title', 'History')
@include('_employee_app._layout_employee.header')

@section('content')
<div class="presence">
    <x-date-filter action="{{ route('overtime.list') }}" 
                    :startDate="request()->get('start_date')" 
                    :endDate="request()->get('end_date')" />
                    
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
                    @foreach($presence as $no=>$presence)
                    <tr>
                        {{-- <td>{{ $no+1 }}</td> --}}
                        <td>{{ \Carbon\Carbon::parse($presence->date)->format('d-m-Y') }}</td>
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