<div class="modal fade" id="addPresence" tabindex="-1" aria-labelledby="modalPresence" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPresence">Add Manual Presence</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('presence.create.admin') }}" method="POST">
                    @csrf   

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                            <select class="form-select" id="employeeSelect" name="employee_id" aria-label="Default select example" required>
                                <option selected>Select Employee</option>
                                @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }} - {{ $employee->eid }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>   

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">workDay</label>
                        <div class="col-sm-9" id="workDayContainer">
                            <select id="workDaySelect" class="form-select" name="workDay" required></select>
                        </div>
                    </div>  
 
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Date</label>
                        <div class="col-sm-9">
                            <input type="date" name="date" class="form-control" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                        </div>
                    </div>  
                    
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Check In</label>
                        <div class="col-sm-9">
                            <input type="time" step="1" name="checkin" class="form-control" required>
                        </div>
                    </div>   

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Check Out</label>
                        <div class="col-sm-9">
                            <input type="time" step="1" name="checkout" class="form-control" required>
                        </div>
                    </div> 
                   
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-tosca me-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="action" class="btn btn-untosca me-3">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>