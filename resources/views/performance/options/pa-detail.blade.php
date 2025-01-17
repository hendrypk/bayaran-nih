@extends('_layout.main')
@section('content')
{{ Breadcrumbs::render('option_pa_detail', $appraisal_id) }}
<div class="col-lg-6">
    <div class="card">
        <div class="card-body">
            <div class="card-header d-flex align-items-center py-0">
                <div class="col-md-8">
                    <h5 class="card-title">{{ __('performance.label.appraisal_detail') }}</h5>
                </div>
            </div>
            {{-- <div class="modal-header">
                <h5 class="modal-title fw-bold" id="detailAppraisal">{{ __('performance.label.appraisal_detail') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> --}}
            <div class="container">
                <form action="{{ route('appraisal.update', ['appraisal_id' => $appraisal_id ]) }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-7">
                            <label for="name" class="form-label fw-bold">{{ __('general.label.name') }}</label>
                            <input type="text" name="name" class="form-control" value="{{ $name }}" required>
                        </div>
                    </div>
                    <div id="appraisalContainer">
                        <div class="appraisal-group mb-3">
                            <div class="row">
                                <div class="col-10">
                                    <label for="inputAspect" class="form-label fw-bold">{{ __('performance.label.aspect') }}</label>
                                </div>
                                <div class="col-2">
                                    <label for="removeAppraisalBtn" class="form-label fw-bold">{{ __('general.label.delete') }}</label>
                                </div>
                            </div>
                            @foreach ($appraisals as $index => $appraisal)  
                            <div class="row mb-3">
                                <input type="text" class="form-control" name="appraisals[{{ $index }}][id]" value="{{ $appraisal->id }}" hidden required>                                                             
                                <div class="col-10">
                                    <input type="text" class="form-control" name="appraisals[{{ $index }}][aspect]" value="{{ $appraisal->aspect }}" required>
                                </div>
                                <div class="col-2">
                                    <button type="button" class="btn btn-red" 
                                        onclick="confirmDelete({{ $appraisal->id }}, '{{ $appraisal->aspect }}', 'appraisal')">
                                    <i class="ri-delete-bin-fill"></i>
                                </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row mb-3">
                        
                        <div class="col-md-9">
                            <button type="button" id="addAppraisalBtn" class="btn btn-tosca">{{ __('performance.label.add_appraisal') }}</button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('kpi.pa.options.index') }}" class="btn btn-red me-3">{{ __('general.label.back') }}</a>
                        <button type="submit" class="btn btn-tosca btn-sm">{{ __('general.label.save') }}</button>
                    </div>
                </form>
            </div>
    </div>
</div>
@section('script')
<script>

//Add Field on Add Inicators for KPI
document.addEventListener('DOMContentLoaded', function() {
    let index = {{ count($appraisals) }};
    const appraisalContainer = document.getElementById('appraisalContainer');
    const submitBtn = document.getElementById('submitBtn');

    document.getElementById('addAppraisalBtn').addEventListener('click', function() {
        const container = document.getElementById('appraisalContainer');
        const newAppraisalGroup = document.createElement('div');
        newAppraisalGroup.classList.add('appraisal-group', 'mb-3');
        newAppraisalGroup.innerHTML = `

            <div class="row">
                    <input type="text" class="form-control" name="appraisals[${index}][id]" value="" hidden>
                <div class="col-10">
                    <input type="text" class="form-control" name="appraisals[${index}][aspect]" required>
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-red removeAppraisalBtn">
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

//Delete Modal
function confirmDelete(id, name, entity) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to delete the " + entity + ": " + name,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '',
            cancelButtonColor: '',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/${entity}/${id}/delete`, { 
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: data.message, // Use message from the server
                            icon: 'success'
                        }).then(() => {
                            let row = document.querySelector(`#row-${id}`); // Assuming the row has an ID like row-123
                            if (row) {
                                row.remove();
                            }
                            window.location.reload();
                        });
                    } else {
                        Swal.fire('Error!', data.message || 'Something went wrong. Try again later.', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error!', 'Failed to delete. Please try again.', 'error');
                    console.error('There was a problem with the fetch operation:', error);
                });
            }
        });
    }
    
    document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('.target-input, .bobot-input');

    inputs.forEach(input => {
        // Format the input on blur
        input.addEventListener('blur', function() {
            let value = input.value.replace(/,/g, '').replace('.', ',');  // Remove commas and replace period with a comma for decimal
            let formattedValue = parseFloat(value).toLocaleString('en-US', { 
                minimumFractionDigits: 2, 
                maximumFractionDigits: 2 
            });
            input.value = formattedValue;
        });

        // Format the input on keyup (while typing)
        input.addEventListener('input', function() {
            let value = input.value.replace(/,/g, '').replace('.', ',');  // Remove commas and replace period with a comma for decimal
            let formattedValue = parseFloat(value).toLocaleString('en-US', { 
                minimumFractionDigits: 2, 
                maximumFractionDigits: 2 
            });
            input.value = formattedValue;
        });
    });
});
</script>
@endsection
@endsection