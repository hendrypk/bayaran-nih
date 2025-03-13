<!-- Add Modal Position -->
<div class="modal fade" id="addOvertime" tabindex="-1" aria-labelledby="modalPosition" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addOvertime">{{ __('attendance.label.add_overtime') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('overtime.add') }}" method="POST">
                    
                    @csrf
                    <!-- <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">EID</label>
                        <div class="col-sm-8">
                            <input type="text" name="eid" class="input-form">
                        </div>
                    </div> -->


                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">{{ __('general.label.name') }}</label>
                        <div class="col-sm-8">
                            <select class="select-form" name="employee_id" aria-label="Default select example" required>
                                <option selected>{{ __('attendance.label.select_employee') }}</option>
                                @foreach($employees as $employee)
                                <option selected value="{{ $employee->id }}">{{ $employee->name }} - {{ $employee->eid }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>   

                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">{{ __('general.label.date') }}</label>
                        <div class="col-sm-8">
                            <input type="date" name="date" class="input-form" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                        </div>
                    </div>  
                    
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">{{ __('general.label.start_at') }}</label>
                        <div class="col-sm-8">
                            <input type="time" step="1" name="start" class="input-form" required>
                        </div>
                    </div>   

                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">{{ __('general.label.end_at') }}</label>
                        <div class="col-sm-8">
                            <input type="time" step="1" name="end" class="input-form" required>
                        </div>
                    </div> 
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-red me-3" data-bs-dismiss="modal">{{ __('general.label.cancel') }}</button>
                        <button type="submit" name="action" class="btn btn-tosca me-3">{{ __('general.label.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

