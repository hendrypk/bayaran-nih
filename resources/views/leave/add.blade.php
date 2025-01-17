<!-- Add Modal Position -->
<div class="modal fade" id="addLeave" tabindex="-1" aria-labelledby="modalLeave" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLeave">{{ __('attendance.label.add_leave') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('leaves.create') }}" method="POST">
                    
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">{{ __('general.label.name') }}</label>
                        <div class="col-sm-9">
                            <select class="select-form" name="employee_id" aria-label="Default select example">
                                <option selected disabled>{{ __('attendance.label.select_employee') }}</option>
                                @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }} - {{  $employee->eid }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>   

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">{{ __('general.label.date') }}</label>
                        <div class="col-sm-9">
                            <input type="date" name="leave_dates[]" class="input-form" id="leave-dates">
                        </div>
                    </div>

                    {{-- <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Start Date</label>
                        <div class="col-sm-9">
                            <input type="date" name="start_date" class="input-form">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">End Date</label>
                        <div class="col-sm-9">
                            <input type="date" name="end_date" class="input-form">
                        </div>
                    </div>   --}}

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">{{ __('general.label.category') }}</label>
                        <div class="col-sm-9">
                            <select class="select-form" name="category" aria-label="Default select example">
                                <option selected disabled>{{ __('general.label.select_category') }}</option>
                                @foreach ($category as $category)
                                    <option value="{{ $category }}">{{ ucfirst($category) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>  

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">{{ __('general.label.note') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="input-form" name="note">
                        </div>
                    </div>  
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-tosca me-3" data-bs-dismiss="modal">{{ __('general.label.cancel') }}</button>
                        <button type="submit" class="btn btn-untosca">{{ __('general.label.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

