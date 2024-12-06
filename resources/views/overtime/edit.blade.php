<!-- Edit Modal Overtime -->
<div class="modal fade" id="overtimeEdit" tabindex="-1" aria-labelledby="modalEditOvertime" aria-hidden="true">
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
                        <label class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <select class="form-select" name="employee_id" id="selectEmployee" aria-label="Default select example">
                                <option selected>Select Employee</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>   

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Date</label>
                        <div class="col-sm-10">
                            <input type="date" name="date" class="form-control" id="inputDate">
                        </div>
                    </div>  
                    
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Start at</label>
                        <div class="col-sm-10">
                            <input type="time" step="1" name="start" class="form-control" id="inputStart">
                        </div>
                    </div>   

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">End at</label>
                        <div class="col-sm-10">
                            <input type="time" step="1" name="end" class="form-control" id="inputEnd">
                        </div>
                    </div> 

                    <div class="d-flex justify-content-end">
                        <button type="submit" name="action" value="accept" class="btn btn-tosca me-3">Save & Accept</button>
                        <button type="submit" name="action" value="reject" class="btn btn-untosca">Save & Reject</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>