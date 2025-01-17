@extends('_employee_app._layout_employee.main')
@section('header.title', 'Your Leave')
@include('_employee_app._layout_employee.header')
@section('header')
<div class="appHeader blue text-light">
        <div class="left">
            <a href="{{ route('employee.app') }}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle"> {{ Auth::user()->name }} Presences History </div>
        <div class="right"></div>
    </div>
@endsection

@section('content')
<div class="presence">
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Date</th>
                        <th>Category</th>
                        <th>Note</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    
                    
                    @foreach($leaves as $no=>$leave)
                    <tr>
                        <td>{{ $no+1 }}</td>
                        <td>{{ $leave->date }}</td>
                        <td>{{ ucfirst($leave->leave) }}</td>
                        <td>{{ $leave->leave_note }}</td>
                        <td>
                            @if ($leave->leave_status === 0)
                            <i class="status-leave reject ri-close-fill"></i>
                            @elseif ($leave->leave_status === 1)
                                <i class="status-leave accept ri-check-double-fill"></i>
                            @else
                            <i class="">{{ __('general.label.pending') }}</i>
                            @endif
                        </td>
                    </tr>    
                    @endforeach
                    
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<a href="{{ route('leave.apply') }}" class="btn btn-primary floating-btn">+
</a>


@endsection