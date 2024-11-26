@extends('_layout.main')
@section('title', 'Performance - PA')
@section('content')

<div class="col-lg-8">
    <div class="card">
        <div class="card-body">
            <div class="card-header d-flex align-items-center py-0">
                <div class="col-md-8">
                    <h5 class="card-title">KPI Detail for {{ $name }}</h5>
                </div>
            </div>
            @foreach ($indicators as $index => $indicator)
            <form action="{{ route('indicator.update', ['kpi_id' => $indicator->kpi_id]) }}" method="POST">
            @endforeach
                @csrf
                <div class="row mb-3">
                    <div class="col-md-7">
                        <label for="inputPosition" class="form-label fw-bold">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $name }}" required>
                    </div>
                </div>
                <div id="indicatorsContainer">
                    <div class="indicator-group mb-3">
                        <div class="row mb-3">
                            <div class="col-7">
                                <label for="inputAspect" class="form-label fw-bold">Indicator</label>
                            </div>
                            <div class="col-2">
                                <label for="inputAspect" class="form-label fw-bold">Target</label>
                            </div>
                            <div class="col-2">
                                <label for="inputAspect" class="form-label fw-bold">Bobot (%)</label>
                            </div>

                        </div>

                        <div id="editIndicatorsContainer">
                            <!-- Dynamic indicators will be inserted here via JavaScript -->
                        </div>

                        @foreach ($indicators as $indicator)
                        <div class="row mb-3">
                            <input type="text" class="form-control" name="indicators[0][id]" value="{{ $indicator->id }}" hidden required>
                            <div class="col-7">
                                <input type="text" class="form-control" name="indicators[0][aspect]" value="{{ $indicator->aspect }}" required>
                            </div>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  
                            <div class="col-2">
                                <input type="text" class="form-control" name="indicators[0][target]" value="{{ $indicator->target }}" step="0.01" required>
                            </div>
                            <div class="col-2">
                                <input type="text" class="form-control bobot-input" name="indicators[0][bobot]" value="{{ $indicator->bobot }}" step="0.01" required>
                            </div>
                            <div class="col-1">
                                <button type="button" class="btn btn-outline-danger" 
                                onclick="confirmDelete({{ $indicator->id }}, '{{ $indicator->aspect }}', 'aspect')">
                                <i class="ri-delete-bin-fill"></i>
                            </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-9">
                        <button type="button" id="addEditIndicatorBtn" class="btn btn-secondary">Add Indicator</button>
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control fw-bold" id="totalBobot" value="{{ $totalBobot }}" readonly>
                    </div>
                </div>
                <button type="submit" class="btn btn-tosca">Save Changes</button>
            </form>
            <div class="row d-f"></div>

        </div>
    </div>
</div>

@include('modal.delete')
@include('options.edit')

@section('script')

<script>
//Add Field on Edit Inicators for KPI
document.addEventListener('DOMContentLoaded', function() {
    let index = 1;
    const editIndicatorsContainer = document.getElementById('editIndicatorsContainer');
    const totalBobotInput = document.getElementById('totalBobot');
    const submitBtn = document.getElementById('submitBtn');

    document.getElementById('addEditIndicatorBtn').addEventListener('click', function() {
        console.log('Add Indicator button clicked');
        const container = document.getElementById('editIndicatorsContainer');
        const newIndicatorGroup = document.createElement('div');
        newIndicatorGroup.classList.add('edit-indicator-group', 'mb-3');
        newIndicatorGroup.innerHTML = `
            <div class="row">
                <div class="col-7">
                    <input type="text" class="form-control" name="indicators[1][aspect]" required>
                </div>
                <div class="col-2">
                    <input type="number" class="form-control" name="indicators[1][target]" step="0.01" required>
                </div>
                <div class="col-2">
                    <input type="number" class="form-control bobot-input" name="indicators[1][bobot]" step="0.01" required>
                </div>
                <div class="col-1">
                    <button type="button" class="btn btn-danger removeIndicatorBtn">
                        <i class="ri-delete-bin-fill"></i>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(newIndicatorGroup);
        index++; // Increment the index for new inputs
    });

// Remove indicator group
    document.addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('removeIndicatorBtn')) {
        const indicatorGroup = event.target.closest('.edit-indicator-group');
        indicatorGroup.remove();
        }
    });

 // Update total bobot whenever bobot fields change
 document.addEventListener('input', function(event) {
        if (event.target && event.target.classList.contains('bobot-input')) {
            updateTotalBobot();
        }
    });

    function updateTotalBobot() {
        let totalBobot = 0;
        const bobotInputs = document.querySelectorAll('.bobot-input');

        bobotInputs.forEach(input => {
            totalBobot += parseFloat(input.value) || 0;
        });

        totalBobotInput.value = totalBobot;

        // Enable or disable the submit button based on total bobot
        if (totalBobot === 100) {
            submitBtn.disabled = false;
        } else {
            submitBtn.disabled = true;
        }
    }
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