@extends('_employee_app._layout_employee.main')
@section('header.title', 'Apply Leave')
@include('_employee_app._layout_employee.header')
@section('header')
<div class="appHeader blue text-light">
        <div class="left">
            <a href="{{ route('employee.app') }}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle"> {{ Auth::user()->name }} Apply Leave </div>
        <div class="right"></div>
    </div>
@endsection

@section('content')
<div class="presence">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('leave.create') }}" method="POST">        
                @csrf

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Select Date</label>
                    <div class="col-sm-9">
                        <input type="date" name="leave_dates[]" class="form-control" id="leave-dates">
                    </div>
                </div>

                {{-- <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Start Dates</label>
                    <div class="col-sm-9">
                        <input type="date" name="start_date" class="form-control">
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">End Date</label>
                    <div class="col-sm-9">
                        <input type="date" name="end_date" class="form-control">
                    </div>
                </div>   --}}

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Category</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="category" aria-label="Default select example">
                            <option selected disabled>Select Category</option>
                            @foreach ($category as $category)
                                <option value="{{ $category }}">{{ ucfirst($category) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>  

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Note</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="note">
                    </div>
                </div>  
                
                <button type="button" class="btn btn-tosca" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-untosca">Submit</button>
            </form>
        </div>
    </div>
</div>

<a href="{{ route('leave.create') }}" class="btn btn-primary floating-btn">+
</a>


@endsection