<div class="modal fade" id="addPresence" tabindex="-1" aria-labelledby="modalPresence" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPresence">{{ __('attendance.label.add_manual_presence') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('presence.create.admin') }}" method="POST">
                    @csrf   

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">{{ __('general.label.name') }}</label>
                        <div class="col-sm-9">
                            <select class="form-select" id="employeeSelect" name="employee_id" aria-label="Default select example" required>
                                <option selected disabled>{{ __('attendance.label.select_employee') }}</option>
                                @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }} - {{ $employee->eid }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>   

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">{{ __('attendance.label.work_day') }}</label>
                        <div class="col-sm-9" id="workDayContainer">
                            <select id="workDaySelect" class="form-select" name="workDay" required></select>
                        </div>
                    </div>  
 
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">{{ __('general.label.date') }}</label>
                        <div class="col-sm-9">
                            <input type="date" name="date" class="form-control" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                        </div>
                    </div>  
                    
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">{{ __('attendance.label.check_in') }}</label>
                        <div class="col-sm-9">
                            <input type="time" step="1" name="checkin" class="form-control" required>
                        </div>
                    </div>   

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">{{ __('attendance.label.check_out') }}</label>
                        <div class="col-sm-9">
                            <input type="time" step="1" name="checkout" class="form-control" required>
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