<!-- Add Modal Position -->
<div class="modal fade" id="modalLaporHr" tabindex="-1" aria-labelledby="modalLaporHr" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLaporHr">{{ __('general.label.edit_lapor_hr') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('lapor_hr.submit') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="report_id">
                    <div class="row">
                        <div class="col">
                            <div class="row mb-1">
                                <label class="col-sm col-form-label">{{ __('general.label.name') }}</label>
                                <label class="col-sm col-form-label">{{ __('employee.label.eid') }}</label>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm">
                                    <select class="select-form" name="employee_id" aria-label="Default select example" disabled>
                                        <option selected disabled>{{ __('attendance.label.select_employee') }}</option>
                                        @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm">
                                    <select class="select-form" name="employee_id" aria-label="Default select example" disabled>
                                        <option selected disabled>{{ __('attendance.label.select_employee') }}</option>
                                        @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->eid }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <label class="col-sm col-form-label">{{ __('general.label.report_date') }}</label>
                                <label class="col-sm col-form-label">{{ __('general.label.report_category') }}</label>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm">
                                    <select class="select-form" name="report_category" aria-label="Default select example" disabled>
                                        <option selected disabled>{{ __('general.label.select_category') }}</option>
                                        @foreach($reportCategory as $data)
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                        @endforeach
                                    </select>
                                </div>                                
                                <div class="col-sm">
                                    <input type="date" name="report_date" class="form-control" id="report_date" disabled>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <label class="col-sm col-form-label">{{ __('general.label.report_date') }}</label>
                                <label class="col-sm col-form-label">{{ __('general.label.report_category') }}</label>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm">
                                    <select class="select-form" name="report_category" aria-label="Default select example" disabled>
                                        <option selected disabled>{{ __('general.label.select_category') }}</option>
                                        @foreach($reportCategory as $data)
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                        @endforeach
                                    </select>
                                </div>                                
                                <div class="col-sm">
                                    <input type="date" name="report_date" class="form-control" id="report_date" disabled>
                                </div>
                            </div>
                            
                            <div class="row mb-1">
                                <label class="col-sm-8 col-form-label">{{ __('general.label.report_attachment') }}</label>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-8">
                                    <div class="col-sm-9 d-flex align-items-center">
                                        <div id="preview-container" class="row mb-3 g-3">
                                        </div>                     
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row mb-1">
                                <label class="col-sm col-form-label">{{ __('general.label.report_description') }}</label>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm">
                                    <textarea class="form-control" name="report_description" id="report_description" cols="30" rows="5" disabled></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="row mb-1">
                                <label class="col-sm-6 col-form-label">{{ __('general.label.solve_date') }}</label>
                                <label class="col-sm-6 col-form-label">{{ __('general.label.status') }}</label>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <input type="date" name="solve_date" class="form-control" id="solve_date">
                                </div>
                                <div class="col-sm">
                                    <select class="select-form" name="status" aria-label="Default select example">
                                        <option selected disabled>{{ __('general.label.select_category') }}</option>
                                        @foreach($status as $data)
                                        <option value="{{ $data }}">{{ $data }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <label class="col-sm col-form-label">{{ __('general.label.solve_attachment') }}</label>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm d-flex align-items-center">
                                    <input type="file" class="form-control" id="solve_attachment" name="solve_attachment[]" multiple onchange="previewFiles(event)">
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row mb-1">
                                <label class="col-sm col-form-label">{{ __('general.label.solve_description') }}</label>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm">
                                    <textarea class="form-control" name="solve_description" id="solve_description" cols="30" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb">
                        <div id="solve-preview-container" class="row mb g-3"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-tosca" data-bs-dismiss="modal">{{ __('general.label.cancel') }}</button>
                        <button type="submit" class="btn btn-untosca">{{ __('general.label.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

