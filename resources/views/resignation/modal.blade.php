<div class="modal fade" id="resignModal" tabindex="-1" aria-labelledby="resignModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resignModalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="resignForm" action="" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">{{ __('general.label.name') }}</label>
                        <div class="col-sm-9">
                            <select class="form-select" name="name" id="name" aria-label="Default select example" required>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">{{ __('general.label.date') }}</label>
                        <div class="col-sm-9">
                            <input type="date" id="date" name="date" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">{{ __('employee.label.category') }}</label>
                        <div class="col-sm-9">
                            <select class="form-select" name="category" id="category" aria-label="Default select example">
                                @foreach($category as $data)
                                    <option value="{{ $data }}">{{ $data }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">{{ __('general.label.note') }}</label>
                        <div class="col-sm-9">
                            <input type="text" id="note" name="note" class="form-control" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-tosca me-3"><i class="ri-save-2-line"></i> {{ __('general.label.save') }} </button>
                        @can('delete resignation')
                        <button type="button" class="btn btn-untosca"
                            id="deleteButton" onclick="">
                            <i class="ri-delete-bin-fill"></i> {{ __('general.label.delete') }}
                        </button>
                        @endcan
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
