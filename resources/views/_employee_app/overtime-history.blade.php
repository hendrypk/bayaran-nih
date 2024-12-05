@extends('_employee_app._layout_employee.main')
@section('header.title', 'Overtime History')
@include('_employee_app._layout_employee.header')
 {{-- @section('header')
<div class="appHeader blue text-light">
        <div class="left">
            <a href="{{ route('employee.app') }}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle"> {{ Auth::user()->name }} Presences History </div>
        <div class="right"></div>
    </div>
@endsection  --}}

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
                        <th>No.</th>
                        <th>Date</th>
                        <th>Start at</th>
                        <th>End at</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach($overtime as $no=>$overtime)
                    <tr>
                        <td>{{ $no+1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($overtime->date)->format('d-m-Y') }}</td>
                        <td>{{ $overtime->start_at }}</td>
                        <td>{{ $overtime->end_at ?? '-' }}</td>
                        <td>{{ $overtime->total ?? '-' }}</td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection