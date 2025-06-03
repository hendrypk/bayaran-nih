<div class="modal fade" id="addPa" tabindex="-1" aria-labelledby="modalPa" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="card-title mb-0 py-3">{{ __('performance.label.add_new_employee_appraisal') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pa.add') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-bold">{{ __('general.label.name') }}</label>
                        <div class="col">
                            <select class="select-form" name="employee_id" id="employee" aria-label="Default select example">
                                <option selected>{{ __('attendance.label.select_employee') }}</option>
                                @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}" data-pa-id="{{ $employee->pa_id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-bold">{{ __('general.label.month') }}</label>
                        <div class="col">
                            <select class="select-form" name="month" aria-label="Default select example">
                                @foreach(range(1, 12) as $month)
                                <option value="{{ DateTime::createFromFormat('!m', $month)->format('F') }}">{{ DateTime::createFromFormat('!m', $month)->format('F') }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-bold">{{ __('general.label.year') }}</label>
                        <div class="col">
                            <select class="select-form" name="year" aria-label="Default select example">
                                @foreach(range(date('Y') - 1, date('Y') + 5) as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="">
                        <h5 class="title mb-0 py-3 fw-bold">{{ __('performance.label.appraisal_aspect') }}</h5>
                    </div>


                    <div id="appraisalContainer"></div>

                    {{-- @foreach ($appraisals as $appraisal)
                    <div class="row mb-3">
                        <label for="grade_{{ $appraisal->id }}" class="col-md-4 form-label">{{ $appraisal->name }}</label>
                        <div class="col">
                            <input type="number" class="form-control" name="grades[{{ $appraisal->id }}]" id="grade_{{ $appraisal->id }}" min="0" max="100" required>
                        </div>
                    </div>
                    @endforeach --}}

                    <div class="row mb-2 mt-3 justify-content-end">
                        <div class="d-grid gap-2 col-2">
                            <button type="button" class="btn btn-red" data-bs-dismiss="modal">{{ __('general.label.cancel') }}</button>
                        </div>
                        <div class="d-grid gap-2 col-2">
                            <button type="submit" class="btn btn-tosca">{{ __('general.label.save') }}</button>
                        </div>
                    </div>
                    {{-- <div class="row g-3 d-grid gap-2 col-6 mx-auto">
                        <button type="submit" class="btn btn-tosca">Submit</button>
                    </div> --}}
                </form>
            </div>
        </div>
    </div>
</div>

