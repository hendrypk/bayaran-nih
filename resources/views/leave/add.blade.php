<!-- Add Modal Position -->
<div class="modal fade" id="addLeave" tabindex="-1" aria-labelledby="modalLeave" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLeave">Add Leave</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('leaves.create') }}" method="POST">
                    
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                            <select class="form-select" name="employee_id" aria-label="Default select example">
                                <option selected disabled>Select Employee</option>
                                @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }} - {{  $employee->eid }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>   

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Select Date</label>
                        <div class="col-sm-9">
                            <input type="date" name="leave_dates[]" class="form-control" id="leave-dates">
                        </div>
                    </div>

                    {{-- <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Start Date</label>
                        <div class="col-sm-9">
                            <input type="date" name="start_date" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">End Date</label>
                        <div class="col-sm-9">
                            <input type="date" name="end_date" class="form-control">
                        </div>
                    </div>   --}}

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Category</label>
                        <div class="col-sm-9">
                            <select class="form-select" name="category" aria-label="Default select example">
                                <option selected disabled>Select Category</option>
                                @foreach ($category as $category)
                                    <option value="{{ $category }}">{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>  

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Note</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="note">
                        </div>
                    </div>  
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-tosca me-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-untosca">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

