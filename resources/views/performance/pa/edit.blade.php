@extends('_layout.main')
@section('title', 'Employees')
@section('content')


<div class="row">
  <div class="col-md-6">
    <div class="card">
      <div class="card-body">
        <div class="container">

        
        <h5 class="card-title">Edit Appriasal</h5>
        <form action="{{ route('pa.update', ['employee_id' => $employees->id, 'month' => $month, 'year' => $year]) }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-bold">Employee Name</label>
                        <div class="col">
                            <select class="form-select" type="hidden" name="employee_id" aria-label="Default select example" disabled >
                                <option selected value="{{ $employees->id }}">{{ $employees->name }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-bold">Month</label>
                        <div class="col">
                            <select class="form-select" type="hidden" name="month" aria-label="Default select example" disabled >
                                <option selected>{{ $month }}</option>
                            </select>
                            <input type="hidden" name="month" value="{{ $month }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-bold">Year</label>
                        <div class="col">
                            <select class="form-select" type="hidden" name="year" aria-label="Default select example" disabled >
                                @foreach(range(date('Y') -1, date('Y') + 5) as $y)
                                <option value="{{ $y }}" {{ isset($year) && $year == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="year" value="{{ $year }}">
                        </div>
                    </div>

                    <div class="">
                        <h5 class="title mb-0 py-3 fw-bold">Appraisals Aspect</h5>
                    </div>

                    @foreach ($gradePas as $gradePa)
                    <div class="row mb-3">
                        <label for="grade_{{ $gradePa->id }}" class="col-md-4 form-label">{{ $gradePa->appraisal->aspect }}</label>
                        <div class="col">
                            <input type="number" class="form-control" name="grades[{{ $gradePa->id }}]" id="grade_{{ $gradePa->id }}" min="0" max="100" required value="{{ $gradePa->grade }}">
                        </div>
                    </div>
                    @endforeach

                    <div class="row justify-content-center">
                        <div class="col-2">
                            <button type="submit" class="btn btn-untosca mt-3">Update</button>
                        </div>
                        <div class="col-2">
                            <a href="{{ url()->previous() }}" class="btn btn-tosca mt-3">Cancel</a>
                        </div>

                    </div>
                </form>
                </div>
    </div>
    </div>
  </div>
</div>

@endsection