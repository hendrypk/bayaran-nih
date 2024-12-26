@extends('_employee_app._layout_employee.main')
@section('header.title', 'Gajiku')
@include('_employee_app._layout_employee.header')
@section('content')
<div class="presence">
    <div class="container">
        <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
            <h2 class="tosca">Coming Soon</h2>
            <a class="btn btn-untosca" href="{{route('employee.app')}}">Back to home</a>
            <img src="assets/img/not-found.svg" class="img-fluid py-5" alt="Page Not Found">
        </section>
    </div>
</div>
@endsection