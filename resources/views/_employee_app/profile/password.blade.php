@extends('_employee_app._layout_employee.main')
@section('header.title', __('app.label.change_password'))
@include('_employee_app._layout_employee.header')
@section('content')
<div class="presence">
    <div class="card">
        <div class="card-body">
            {{-- <div class="box">Coming Soon</div> --}}

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

            <form action="{{ route('reset.password') }}" method="POST">
                @csrf
                <div class="row mb-1">
                    <div class="col-md-3">
                        <label for="currentPassword">{{ __('app.label.current_password') }}</label>
                        <div class="position-relative password-field">
                            <input id="currentPassword" class="form-control" type="password" name="currentPassword" placeholder="{{ __('app.placeholder.enter_current_password') }}">
                            <i class="bi bi-eye-fill toggle-password" data-target="currentPassword"></i>
                        </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-md-3">
                        <label for="newPassword">{{ __('app.label.new_password') }}</label>
                        <div class="position-relative password-field">
                            <input id="newPassword" class="form-control" type="password" name="newPassword" placeholder="{{ __('app.placeholder.enter_new_password') }}">
                            <i class="bi bi-eye-fill toggle-password" data-target="newPassword"></i>
                        </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-md-3">
                        <label for="confirmPassword">{{ __('app.label.confirm_new_password') }}</label>
                        <div class="position-relative password-field">
                            <input id="confirmPassword" class="form-control" type="password" name="confirmPassword" placeholder="{{ __('app.placeholder.confirm_new_password') }}">
                            <i class="bi bi-eye-fill toggle-password" data-target="confirmPassword"></i>
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
@section('script')
{{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleIcons = document.querySelectorAll('.toggle-password');

        toggleIcons.forEach(icon => {
            icon.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);

                if (input.type === 'password') {
                    input.type = 'text';
                    this.classList.remove('bi-eye-fill');
                    this.classList.add('bi-eye-slash-fill');
                } else {
                    input.type = 'password';
                    this.classList.remove('bi-eye-slash-fill');
                    this.classList.add('bi-eye-fill');
                }
            });
        });
    });
</script> --}}
@endsection
@endsection
