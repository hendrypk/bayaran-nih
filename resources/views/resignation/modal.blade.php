<div class="modal fade" id="resignationModal" tabindex="-1" aria-labelledby="resignationModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resignationModalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="resignationForm" action="" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">Name</label>
                        <div class="col-sm-8">
                            <select name="employee" id="employee" class="form-select" aria-label="Default select example" required>
                                <option value="" selected>Select Employee</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">Category</label>
                        <div class="col-sm-8">
                            <select name="category" id="category" class="form-select" aria-label="Default select example" required>
                                <option value="" selected>Select Category</option>
                                @foreach ($category as $category)
                                    <option value="{{ $category }}">{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">Effective Date</label>
                        <div class="col-sm-8">
                            <input type="date" id="date" name="date" class="form-control" required>
                        </div>
                    </div>   

                    <button type="submit" class="btn btn-tosca">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
