@extends('_layout.main')
@section('content')
<div class="row">
    <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-header d-flex align-items-center py-0">
                        <h5 class="card-title mb-0 py-3">Indicator for KPI</h5>
                        @can('create pm')
                            <div class="ms-auto my-auto">
                                <button type="button" class="btn btn-tosca" data-bs-toggle="modal" data-bs-target="#addIndicatorModal">Add Indicator</button>
                            </div>
                        @endcan
                    </div>
                        <table class="table datatable table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">View</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($kpi_id as $no=>$indicator)
                                <tr>
                                    <th scope="row">{{ $no+1 }}</th>
                                    <td>{{ $indicator->name }}</td>
                                    <td>
                                        <a href="{{ route('indicator.detail', [
                                            'kpi_id' => $indicator->id,
                                            ]) }}" class="btn btn-outline-primary">
                                            <i class="ri-eye-fill"></i>
                                        </a>
                                    </td>
                                    <td>
                                        @foreach ($indicator->kpis as $kpi)
                                            
                                        @endforeach
                                        @can('update pm')
                                        <button type="button" 
                                            class="btn btn-outline-success" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#indicatorEditModal" 
                                            data-id="{{ $indicator->id }}"
                                            data-name ="{{ $indicator->name }}"
                                            data-target="{{ $kpi->target }}">
                                            <i class="ri-edit-box-fill"></i>
                                        </button>
                                        @endcan
                                    </td>
                                    <td>
                                        @can('delete pm')
                                            <button type="button" class="btn btn-outline-danger" 
                                                onclick="confirmDelete({{ $indicator->id }}, '{{ $indicator->name }}', 'indicator')">
                                                <i class="ri-delete-bin-fill"></i>
                                            </button>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>


    <!-- KPI -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-header d-flex align-items-center py-0">
                        <h5 class="card-title mb-0 py-3">Indicator for PA</h5>
                        @can('create pm')
                            <div class="ms-auto my-auto">
                                <button type="button" class="btn btn-tosca" data-bs-toggle="modal" data-bs-target="#addPa">Add PA</button>
                            </div>
                        @endcan
                    </div>
                    
                        <table class="table datatable table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">PA</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($appraisals as $no=>$appraisal)
                                <tr>
                                    <th scope="row">{{ $no+1 }}</th>
                                    <td>{{ $appraisal->name }}</td>
                                    <td>
                                        @can('update pm')
                                            <button type="button" 
                                                class="btn btn-outline-success" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#paEditModal" 
                                                data-id="{{ $appraisal->id }}" 
                                                data-name="{{ $appraisal->name }}">
                                                <i class="ri-edit-box-fill"></i>
                                            </button>
                                        @endcan
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-outline-danger" 
                                            onclick="confirmDelete({{ $appraisal->id }}, '{{ $appraisal->name }}', 'appraisal')">
                                            <i class="ri-delete-bin-fill"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('performance.options.modal')

@section('script')
<script>
//Add Field on Add Inicators for KPI
document.addEventListener('DOMContentLoaded', function() {
    let index = 1;
    const indicatorsContainer = document.getElementById('indicatorsContainer');
    const totalBobotInput = document.getElementById('totalBobot');
    const submitBtn = document.getElementById('submitBtn');

    document.getElementById('addIndicatorBtn').addEventListener('click', function() {
        console.log('Add Indicator button clicked');
        const container = document.getElementById('indicatorsContainer');
        const newIndicatorGroup = document.createElement('div');
        newIndicatorGroup.classList.add('indicator-group', 'mb-3');
        newIndicatorGroup.innerHTML = `

            <div class="row">
                <div class="col-7">
                    <input type="text" class="form-control" name="indicators[${index}][aspect]" required>
                </div>
                <div class="col-2">
                    <input type="number" class="form-control" name="indicators[${index}][target]" required>
                </div>
                <div class="col-2">
                    <input type="number" class="form-control bobot-input" name="indicators[${index}][bobot]" required>
                </div>
                <div class="col-1">
                    <button type="button" class="btn btn-danger removeIndicatorBtn">
                        <i class="ri-delete-bin-fill"></i>
                    </button>
                </div>
            </div>
            `;
        container.appendChild(newIndicatorGroup);
        index++;
    });
// Remove indicator group
    document.addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('removeIndicatorBtn')) {
        const indicatorGroup = event.target.closest('.indicator-group');
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

document.querySelectorAll('.editIndicatorBtn').forEach(button => {
    button.addEventListener('click', function() {
        const aspect = button.getAttribute('data-aspect');
        const target = button.getAttribute('data-target');
        const bobot = button.getAttribute('data-bobot');

        const form = document.querySelector('.edit-form');

        // If you're using a loop or a container to manage multiple indicators,
        // you might want to set the value of the inputs by their index.
        const indicatorsContainer = document.getElementById('editIndicatorsContainer');

        // Clear existing input values (if needed)
        indicatorsContainer.innerHTML = '';

        // Assuming you want to populate one indicator for now
        const indicatorHTML = `
            <div class="edit-indicator-group mb-3">
                <input type="hidden" name="indicators[0][id]" value="${button.getAttribute('data-id')}">
                <div class="row">
                    <div class="col-7">
                        <input type="text" class="form-control" name="indicators[0][aspect]" value="${aspect}" required>
                    </div>
                    <div class="col-2">
                        <input type="number" class="form-control" name="indicators[0][target]" value="${target}" required>
                    </div>
                    <div class="col-2">
                        <input type="number" class="form-control bobot-input" name="indicators[0][bobot]" value="${bobot}" required>
                    </div>
                    <div class="col-1">
                        <button type="button" class="btn btn-danger removeIndicatorBtn">
                            <i class="ri-delete-bin-fill"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;

        // Add the new indicator HTML to the container
        indicatorsContainer.innerHTML += indicatorHTML;

        // Optionally, calculate and display total bobot
        calculateTotalBobot();
    });
});

//script route
window.routeUrls = {
        indicatorUpdate: "{{ route('indicator.update', ['kpi_id' => 'kpi_id']) }}",
        appraisalUpdate: "{{ route('appraisal.update', ['id' => '__id__']) }}",
    };

//script for edit modal
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.modal').forEach(function (modal) {
        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Button that triggered the modal
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            //Indicator
            const jobTitle = button.getAttribute('data-jobTitle');
            const aspect = button.getAttribute('data-aspect');
            const target = button.getAttribute('data-target');
            const bobot = button.getAttribute('data-bobot');

            console.log('ID:', id);
            console.log('Name:', name);
            console.log('Job Title:', jobTitle);
            console.log('Aspect:', aspect);
            console.log('Target:', target);
            console.log('Bobot:', bobot);

            //edit form
            const updateType = modal.querySelector('.edit-form').getAttribute('data-update-type');
        
            // Determine the correct route URL based on updateType
            let actionUrl = '';
            switch (updateType) {
                // Add other cases as needed
                case 'indicator':
                    actionUrl = window.routeUrls.indicatorUpdate;
                    break;
                case 'appraisal':
                    actionUrl = window.routeUrls.appraisalUpdate;
                    break;
            }
        
            // Replace __id__ with the actual ID
            actionUrl = actionUrl.replace('__id__', id);

            // Find the form and input within the current modal
            const form = modal.querySelector('.edit-form');
            const inputName = form.querySelector('input[name="name"]');
            //indicator field
            const inputJobTitle = form.querySelector('select[name="jobTitle"]');
            const inputAspect = form.querySelector('input[name="aspect"]');
            const inputTarget = form.querySelector('input[name="target"]');
            const inputBobot = form.querySelector('input[name="bobot"]');



            if (form && inputName) {
                // Update form action and input values
                form.action = actionUrl;
                inputName.value = name || '';
                //for indicator
                if (inputJobTitle) inputJobTitle.value = jobTitle || '';
                if (inputAspect) inputAspect.value = aspect || '';
                if (inputTarget) inputTarget.value = target || '';
                if (inputBobot) inputBobot.value = bobot || '';
            }
        });
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
                            // Reload the page or redirect to another route
                            window.location.href = data.redirect; // Redirect to the desired route
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
</script>
@endsection
@endsection