@extends('_layout.main')
@section('title', 'Edit KPI')
@section('content')

{{ Breadcrumbs::render('edit_kpi', $gradeKpi->first()) }}
<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-body">
        <div class="container">

        
        <h5 class="card-title">{{ __('performance.label.edit_employee_kpi') }}</h5>
        <form action="{{ route('kpi.update', ['employee_id' => $employees->id, 'month' => $month, 'year' => $year]) }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label fw-bold">{{ __('general.label.name') }}</label>
                        <div class="col-md-4">
                            <select class="form-select" type="hidden" name="employee_id" aria-label="Default select example" disabled readonly>
                                <option selected value="{{ $employees->id }}">{{ $employees->name }}</option>
                            </select>
                        </div>

                        <label class="col-md-2 col-form-label fw-bold">{{ __('general.label.month') }}</label>
                        <div class="col-md-3">
                            <select class="form-select" type="hidden" name="month" aria-label="Default select example" disabled readonly>
                                <option selected>{{ $month }}</option>
                            </select>
                            <input type="hidden" name="month" value="{{ $month }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label fw-bold">{{ __('employee.label.eid') }}</label>
                        <div class="col-md-4">
                            <select class="form-select" type="hidden" name="employee_eid" aria-label="Default select example" disabled readonly>
                                <option selected value="">{{ $employees->eid }}</option>
                            </select>
                        </div>

                        <label class="col-md-2 col-form-label fw-bold">{{ __('general.label.year') }}</label>
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
                        <label class="col-md-3 col-form-label fw-bold">{{ __('employee.label.position') }}</label>
                        <div class="col-md-4">
                            <select class="form-select" type="hidden" name="employee_position" aria-label="Default select example" disabled readonly>
                                <option selected value="">{{ $employees->position->name }}</option>
                            </select>
                        </div>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%;">No.</th>
                                <th class="text-center" style="width: 40%;">{{ __('performance.label.aspect') }}</th>
                                <th class="text-center" style="width: 20%;">{{ __('performance.label.target') }}</th>
                                <th class="text-center" style="width: 15%;">{{ __('performance.label.weight') }}</th>
                                <th class="text-center" style="width: 20%;">{{ __('performance.label.achievement') }}</th>
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
                    <div class="row mb-2 mt-3 justify-content-end">
                        <div class="d-grid gap-2 col-2">
                            <a href="{{ url()->previous() }}" class="btn btn-tosca">{{ __('general.label.back') }}</a>
                        </div>
                        <div class="d-grid gap-2 col-2">
                            <button type="submit" class="btn btn-untosca">{{ __('general.label.save') }}</button>
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