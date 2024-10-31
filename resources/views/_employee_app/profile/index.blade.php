@extends('_employee_app._layout_employee.main')
@section('header.title', 'My Profile')
@include('_employee_app._layout_employee.header')
@section('content')
<div class="presence">
    <div class="container">
        <div class="row mb-1">
            <div class="col">
                <a href="{{ route('change.username') }}" class="clickable-link">Change Username</a>
            </div>
        </div>
        <div class="row mb-1">
            <div class="col">
                <a href="{{ route('change.password') }}" class="clickable-link">Change Password</a>
            </div>
        </div>
        <div class="row mb-1">
            <div class="col">
                <a href="{{ route('auth.logout') }}" class="clickable-link">Sign Out</a>
            </div>
        </div>
    </div>
</div>
@endsection