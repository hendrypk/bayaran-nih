<!-- Edit Modal Overtime -->
<div class="modal fade" id="overtimeEdit" tabindex="-1" aria-labelledby="modalEditOvertime" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">{{ __('attendance.label.edit_leave') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editOvertimeForm" action="{{ route('leaves.create') }}" method="POST">
                    @csrf

                    <input type="text" name="id" id="id" hidden>
                    
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">{{ __('general.label.name') }}</label>
                        <div class="col-sm-9">
                            <select class="form-select" name="employee_id" id="selectEmployee" aria-label="Default select example">
                                <option selected>{{ __('attendance.label.select_employee') }}</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }} - {{ $employee->eid }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>   
                    
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">{{ __('general.label.date') }}</label>
                        <div class="col-sm-9">
                            <input type="date" name="leave_dates[]" class="form-control" id="leave-date">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">{{ __('general.label.category') }}</label>
                        <div class="col-sm-9">
                            <select class="form-select" name="category" id="selectCategory" aria-label="Default select example">
                                <option selected>{{ __('general.label.select_category') }}</option>
                                @foreach($category as $category)
                                    <option value="{{ $category }}">{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>  

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">{{ __('general.label.note') }}</label>
                        <div class="col-sm-9">
                            <input type="text" name="note" class="form-control" id="inputNote">
                        </div>
                    </div> 

                    <div class="d-flex justify-content-end">
                        {{-- <button type="submit" name="action" value="cancel" class="btn btn-tosca me-3">Cancel Action</button> --}}
                        <button type="submit" name="action" value="reject" class="btn btn-tosca me-3">{{ __('general.label.reject') }}</button>
                        <button type="submit" name="action" value="accept" class="btn btn-untosca">{{ __('general.label.accept') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>