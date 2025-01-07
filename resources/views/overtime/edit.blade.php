<!-- Edit Modal Overtime -->
<div class="modal fade" id="overtimeEdit" tabindex="-1" aria-labelledby="modalEditOvertime" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditOvertimeTitle">Edit Overtime</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editOvertimeForm" action="{{ route('overtime.update', ['id' => '__id__']) }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">{{ __('general.label.name') }}</label>
                        <div class="col-sm-8">
                            <select class="form-select" name="employee_id" id="selectEmployee" aria-label="Default select example" required>
                                <option selected>{{ __('attendance.label.select_employee') }}</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>   

                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">{{ __('general.label.date') }}</label>
                        <div class="col-sm-8">
                            <input type="date" name="date" class="form-control" id="inputDate" required>
                        </div>
                    </div>  
                    
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">{{ __('general.label.start_at') }}</label>
                        <div class="col-sm-8">
                            <input type="time" step="1" name="start" class="form-control" id="inputStart" required>
                        </div>
                    </div>   

                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">{{ __('general.label.end_at') }}</label>
                        <div class="col-sm-8">
                            <input type="time" step="1" name="end" class="form-control" id="inputEnd" required>
                        </div>
                    </div> 

                    <div class="d-flex justify-content-end">
                        <button type="submit" name="action" value="accept" class="btn btn-tosca me-3">{{ __('general.label.accept') }}</button>
                        <button type="submit" name="action" value="reject" class="btn btn-untosca">{{ __('general.label.reject') }}</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>