@extends('_employee_app._layout_employee.main')
@section('header.title', __('app.label.change_username'))
@include('_employee_app._layout_employee.header')
@section('content')
<div class="presence">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('reset.username') }}" method="POST">
                @csrf
                <div class="row mb-1">
                    <div class="col-md-3">
                        <label for="">{{ __('auth.label.username') }}</label>
                        <input class="form-control" type="text" value="{{ Auth::user()->username }}" name="username">
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-md-3">
                        <label for="currentPassword">{{ __('app.label.current_password') }}</label>
                        <div class="position-relative password-field">
                            <input id="currentPassword" class="form-control" type="password" name="currentPassword" placeholder="Enter current password">
                            <i class="bi bi-eye-fill toggle-password" data-target="currentPassword"></i>
                        </div>
                    </div>
                </div>
                <div class="row mb-1 mt-2">
                    <div class="col-md-1">
                        <button class="btn btn-tosca">{{ __('general.label.update') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection