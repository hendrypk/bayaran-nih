<!-- Add Modal Position -->
<div class="modal fade" id="addOvertime" tabindex="-1" aria-labelledby="modalPosition" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addOvertime">Add Overtime</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('overtime.add') }}" method="POST">
                    
                    @csrf
                    <!-- <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">EID</label>
                        <div class="col-sm-10">
                            <input type="text" name="eid" class="form-control">
                        </div>
                    </div> -->


                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <select class="form-select" name="employee_id" aria-label="Default select example" required>
                                <option selected>Select Employee</option>
                                @foreach($employees as $employee)
                                <option selected value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>   

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Date</label>
                        <div class="col-sm-10">
                            <input type="date" name="date" class="form-control" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                        </div>
                    </div>  
                    
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Start at</label>
                        <div class="col-sm-10">
                            <input type="time" step="1" name="start" class="form-control" required>
                        </div>
                    </div>   

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">End at</label>
                        <div class="col-sm-10">
                            <input type="time" step="1" name="end" class="form-control" required>
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

