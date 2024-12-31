<div class="modal fade" id="positionChange" tabindex="-1" aria-labelledby="positionChange" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="positionChangeTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="positionChangeForm" action="" method="POST">
                    @csrf
                    <input type="" id="id" name="id">
                    {{-- <input type="" id="hiddenPositionId" name="oldPosition">
                    <input type="" id="hiddenEmployeeId" name="employeeId"> --}}

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                            <select class="form-select" name="employee_id" id="name" aria-label="Default select example">
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}" data-old-position-id="{{ $employee->position_id ?? '-' }}" data-old-position="{{ $employee->position->name ?? '-' }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Old Position</label>
                        <div class="col-sm-9">
                            <input type="" id="oldPosition" name="oldPosition" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">New Position</label>
                        <div class="col-sm-9">
                            <select class="form-select" name="newPosition" id="newPosition" aria-label="Default select example" required>
                                @foreach ($positions as $data)
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Category</label>
                        <div class="col-sm-9">
                            <select class="form-select" name="category" id="category" aria-label="Default select example">
                                @foreach($category as $data)
                                    <option value="{{ $data }}">{{ ucwords($data) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Effective Date</label>
                        <div class="col-sm-9">
                            <input type="date" id="date" name="date" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Note</label>
                        <div class="col-sm-9">
                            <textarea id="note" name="note" class="form-control" required></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-tosca">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
