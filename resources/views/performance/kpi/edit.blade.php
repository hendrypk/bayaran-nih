@extends('_layout.main')
@section('title', 'Edit KPI')
@section('content')

{{ Breadcrumbs::render('edit_kpi', $gradeKpi->first()) }}
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
                                @foreach(range(date('Y') -1, date('Y') + 5) as $y)
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

                    {{-- <div class="row mb-3">
                        <div class="col-md-4 fw-bold"> Indicators</div>
                        <div class="col-sm-2 fw-bold">Target</div>
                        <div class="col-sm-2 fw-bold">Bobot</div>
                        <div class="col fw-bold">Achievement</div>
                    </div> --}}

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%;">No.</th>
                                <th class="text-center" style="width: 40%;">Aspect</th>
                                <th class="text-center" style="width: 20%;">Target</th>
                                <th class="text-center" style="width: 15%;">Bobot</th>
                                <th class="text-center" style="width: 20%;">Achievement</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gradeKpi as $no=>$gradeKpi)
                            <tr>
                                <td>{{ $no+1 }}</td>
                                <td>{{ $gradeKpi->indicator->aspect }}</td>
                                <td class="text-center">{{ number_format($gradeKpi->indicator->target, 2, '.', ',') }}</td>
                                <td class="text-center">{{ number_format($gradeKpi->indicator->bobot, 2, '.', ',') }}</td>
                                <td>
                                    <input type="text" class="form-control numeric-input text-end" name="grades[{{ $gradeKpi->indicator_id }}]" id="grade_{{ $gradeKpi->indicator_id }}" required value="{{ number_format($gradeKpi->achievement, 2, '.', ',') }}">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>         
                    
                    <div class="row d-flex justify-content-end">
                        <div class="col-md-9">
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-tosca btn-sm mt-3">Update</button>
                            <a href="{{ url()->previous() }}" class="btn btn-untosca btn-sm mt-3">Cancel</a>
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