@extends('_layout.main')
@section('content')
<div class="col-lg-6">
    <div class="card">
        <div class="card-body">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="addAppraisal">Add Appraisal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('appraisal.add') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-7">
                            <label for="name" class="form-label fw-bold">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-10">
                            <label for="inputAspect" class="form-label fw-bold">Aspect</label>
                        </div>
                        <div class="col-2">
                            <label for="removeAppraisalBtn" class="form-label fw-bold">Delete</label>
                        </div>
                    </div>
                    <div id="appraisalContainer">
                        <div class="appraisal-group mb-3">
                            <div class="row">
                                <div class="col-10">
                                    {{-- <label for="inputAspect" class="form-label fw-bold">Aspect</label> --}}
                                    <input type="text" class="form-control" name="appraisals[0][aspect]" required>
                                </div>
                                <div class="col-2">
                                    {{-- <label for="removeAppraisalBtn" class="form-label fw-bold">Delete</label> --}}
                                    <button type="button" class="btn btn-danger removeAppraisalBtn">
                                        <i class="ri-delete-bin-fill"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-9">
                            <button type="button" id="addAppraisalBtn" class="btn btn-secondary">Add Appraisal</button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-tosca">Submit</button>
                </form>
            </div>
    </div>
</div>
@section('script')
<script>

//Add Field on Add Inicators for KPI
document.addEventListener('DOMContentLoaded', function() {
    let index = 1;
    const appraisalContainer = document.getElementById('appraisalContainer');
    const submitBtn = document.getElementById('submitBtn');

    document.getElementById('addAppraisalBtn').addEventListener('click', function() {
        const container = document.getElementById('appraisalContainer');
        const newAppraisalGroup = document.createElement('div');
        newAppraisalGroup.classList.add('appraisal-group', 'mb-3');
        newAppraisalGroup.innerHTML = `

            <div class="row">
                <div class="col-10">
                    <input type="text" class="form-control" name="appraisals[${index}][aspect]" required>
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-danger removeAppraisalBtn">
                        <i class="ri-delete-bin-fill"></i>
                    </button>
                </div>
            </div>
            `;
        container.appendChild(newAppraisalGroup);
        index++;
    });
// Remove Appraisal group
    document.addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('removeAppraisalBtn')) {
        const appraisalGroup = event.target.closest('.appraisal-group');
        appraisalGroup.remove();
        }
    });
});
</script>
@endsection
@endsection