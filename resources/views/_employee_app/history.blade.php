@extends('_employee_app._layout_employee.main')
@section('header.title', __('app.label.attendance'))
@include('_employee_app._layout_employee.header')
@section('content')
<div class="presence">

<x-date-filter action="{{ route('presence.history') }}" 
    :startDate="request()->get('start_date')" 
    :endDate="request()->get('end_date')" />

    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        {{-- <th>No</th> --}}
                        <th>{{ __('general.label.date') }}</th>
                        <th>{{ __('attendance.label.check_in') }}</th>
                        <th>{{ __('attendance.label.check_out') }}</th>
                        <th>{{ __('attendance.label.late_arrival') }}</th>
                        <th>{{ __('attendance.label.late_check_in') }}</th>
                        <th>{{ __('attendance.label.check_out_early') }}</th>
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