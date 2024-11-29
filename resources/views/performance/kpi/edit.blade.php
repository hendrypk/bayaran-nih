@extends('_layout.main')
@section('title', 'Employees')
@section('content')


<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-body">
        <div class="container">

        
        <h5 class="card-title">Edit KPI</h5>
        <form action="{{ route('kpi.update', ['employee_id' => $employees->id, 'month' => $month, 'year' => $year]) }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label fw-bold">Name</label>
                        <div class="col-md-4">
                            <select class="form-select" type="hidden" name="employee_id" aria-label="Default select example" disabled readonly>
                                <option selected value="{{ $employees->id }}">{{ $employees->name }}</option>
                            </select>
                        </div>

                        <label class="col-md-2 col-form-label fw-bold">Month</label>
                        <div class="col-md-3">
                            <select class="form-select" type="hidden" name="month" aria-label="Default select example" disabled readonly>
                                <option selected>{{ $month }}</option>
                            </select>
                            <input type="hidden" name="month" value="{{ $month }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label fw-bold">EID</label>
                        <div class="col-md-4">
                            <select class="form-select" type="hidden" name="employee_eid" aria-label="Default select example" disabled readonly>
                                <option selected value="">{{ $employees->eid }}</option>
                            </select>
                        </div>

                        <label class="col-md-2 col-form-label fw-bold">Year</label>
                        <div class="col-md-3">
                            <select class="form-select" type="hidden" name="year" aria-label="Default select example" disabled readonly>
                                @foreach(range(date('Y'), date('Y') + 5) as $y)
                                <option value="{{ $y }}" {{ isset($year) && $year == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="year" value="{{ $year }}">
                        </div>
                    </div>

                    <div class="row mb-5">
                        <label class="col-md-3 col-form-label fw-bold">Position</label>
                        <div class="col-md-4">
                            <select class="form-select" type="hidden" name="employee_position" aria-label="Default select example" disabled readonly>
                                <option selected value="">{{ $employees->position->name }}</option>
                            </select>
                        </div>
                    </div>
<!-- 
                    <div class="">
                        <h5 class="title mb-0 py-3 fw-bold">Indicators</h5>
                    </div> -->

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold"> Indicators</div>
                        <div class="col-sm-2 fw-bold">Target</div>
                        <div class="col-sm-2 fw-bold">Bobot</div>
                        <div class="col fw-bold">Achievement</div>
                    </div>

                    @foreach ($gradeKpi as $gradeKpi)
                    <div class="row mb-3">
                        <label for="grade_{{ $gradeKpi->id }}" class="col-md-4 form-label">{{ $gradeKpi->indicator->aspect }}</label>
                        <label for="" class="col-md-2 form-label">{{ $gradeKpi->indicator->target }}</label>
                        <label for="" class="col-md-2 form-label">{{ $gradeKpi->indicator->bobot }}</label>
                        <div class="col-md-2">
                            <input type="number" step="0.01" min="0" class="form-control" name="grades[{{ $gradeKpi->indicator_id }}]" id="grade_{{ $gradeKpi->indicator_id }}" min="0" max="100" required value="{{ $gradeKpi->achievement }}" step="0.01">
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

@section('script')
<script>
    
</script>
@endsection

@endsection