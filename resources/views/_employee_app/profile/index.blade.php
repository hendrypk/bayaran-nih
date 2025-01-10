@extends('_employee_app._layout_employee.main')
@section('header.title', __('app.label.setting'))

@include('_employee_app._layout_employee.header')
@section('content')
<div class="presence">
    <div class="container">
        <div class="row mb-1">
            <div class="col">
                <a href="{{ route('change.username') }}" class="clickable-link">{{ __('app.label.change_username') }}</a>
            </div>
        </div>
        <div class="row mb-1">
            <div class="col">
                <a href="{{ route('change.password') }}" class="clickable-link">{{ __('app.label.change_password') }}</a>
            </div>
        </div>
        <div class="row mb-1">
            <div class="col">
                <a href="{{ route('auth.logout') }}" class="clickable-link">{{ __('app.label.logout') }}</a>
            </div>
        </div>
        <x-language-switcher />
    </div>
</div>
@endsection