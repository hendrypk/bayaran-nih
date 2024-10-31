@extends('_layout.main')
@section('title', 'Login')
@section('content')

<div class="conatiner">
    <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
            
                            
            <div class="d-flex justify-content-center py-4">
                <img src="{{asset('e-presensi/assets/img/bayaran-favicon.png')}}" alt="" class="login-icon">
            </div>

        <div class="card mb-3">

            <div class="card-body">

                <div class="pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Bayaran</h5>
                    <p class="text-center small">Enter your username & password to login</p>
                </div>

                <form class="row g-3 needs-validation" action="{{ route('login.process') }}" method="POST" novalidate>
                    @csrf
                    <div class="col-12">
                        <label for="yourUsername" class="form-label">Username</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                            <input type="text" name="name" class="form-control" id="yourUsername" value="{{ Session::get('name') }}" required>
                            <div class="invalid-feedback">Please enter your username.</div>
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="yourPassword" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="yourPassword" required>
                        <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                            <label class="form-check-label" for="rememberMe">Remember me</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-tosca w-100" type="submit">Login</button>
                    {{-- </div>
                        <div class="col-12">
                        <p class="small mb-0">Forgot your password? <a href="{{ route('password.request') }}">Reset now!    </a></p>
                    </div> --}}
                </form>

            </div>
        </div>
    </div>
</div>
@endsection