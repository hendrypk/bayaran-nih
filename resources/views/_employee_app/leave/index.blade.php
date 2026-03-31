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
                        <td>{{ formatDate($leave->start_date) }}</td>
                        <td>{{ ucfirst($leave->category) }}</td>
                        <td>{{ $leave->note }}</td>
                        <td>
                            @if ($leave->status === 'accepted')
                                <span class="px-2 py-1 rounded fw-semibold" style="background-color: rgba(25, 135, 84, 0.1); color: #198754;">
                                    <i class="ri-check-double-line"></i>
                                </span>
                            @elseif ($leave->status === 'rejected')
                                <span class="px-2 py-1 rounded fw-semibold" style="background-color: rgba(220, 53, 69, 0.1); color: #dc3545;">
                                    <i class="ri-close-line"></i>
                                </span>
                            @else
                                <span class="px-2 py-1 rounded fw-semibold" style="background-color: rgba(13, 110, 253, 0.1); color: #0d6efd;">
                                    <i class="ri-time-line"></i>
                                </span>
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