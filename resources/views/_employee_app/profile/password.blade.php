@extends('_employee_app._layout_employee.main')
@section('header.title', 'Change Password')
@include('_employee_app._layout_employee.header')
@section('content')
<div class="presence">
    <div class="card">
        <div class="card-body">
            <div class="box">Coming Soon</div>

            @if (session('error'))
                <div class="row mb-2">
                    <div class="col alert alert-danger">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div class="row mb-2">
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if($errors->has('newPassword'))
                <div class="row mb-3">
                    <div class="col alert alert-danger">
                        {{ $errors->first('newPassword') }}
                    </div>
                </div>
            @endif

            @if($errors->has('confirmPassword'))
                <div class="row mb-3">
                    <div class="col alert alert-danger">
                        {{ $errors->first('confirmPassword') }}
                    </div>
                </div>
            @endif

            {{-- <form action="{{ route('reset.password') }}" method="POST">
                @csrf
                <div class="row mb-1">
                    <div class="col-md-3">
                        <label for="password">Current Password</label>
                        <input class="form-control" type="text" name="currentPassword">
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-md-3">
                        <label for="resetPassword">New Password</label>
                        <input class="form-control" type="text" name="newPassword">
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-md-3">
                        <label for="confirmPassword">Confirm New Password</label>
                        <input class="form-control" type="text" name="confirmPassword">
                    </div>
                </div>
                <div class="row mb-1 mt-2">
                    <div class="col-md-1">
                        <button class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </form> --}}

        </div>
    </div>
</div>

@endsection