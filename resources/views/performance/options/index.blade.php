@extends('_layout.main')
@section('content')

{{ Breadcrumbs::render('setting_kpi_pa') }}
<div class="row">
    <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-header d-flex align-items-center py-0">
                        <h5 class="card-title mb-0 py-3">{{ __('performance.label.indicator_for_kpi') }}</h5>
                        @can('create pm')
                            <div class="ms-auto my-auto">
                                <button type="button" class="btn btn-tosca" data-bs-toggle="modal" data-bs-target="#addIndicatorModal">{{ __('performance.label.add_indicator') }}</button>
                            </div>
                        @endcan
                    </div>
                        <table class="table datatable table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ __('general.label.name') }}</th>
                                    <th scope="col">{{ __('general.label.view') }}</th>
                                    {{-- <th scope="col">Edit</th> --}}
                                    <th scope="col">{{ __('general.label.delete') }}</th>
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
                                            ]) }}" class="btn btn-blue">
                                            <i class="ri-eye-fill"></i>
                                        </a>
                                    </td>
                                    <td>
                                        @can('delete pm')
                                            <button type="button" class="btn btn-red" 
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


    <!-- PA -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-header d-flex align-items-center py-0">
                        <h5 class="card-title mb-0 py-3">{{ __('performance.label.indicator_for_pa') }}</h5>
                        @can('create pm')
                            <div class="ms-auto my-auto">
                                {{-- <button type="button" class="btn btn-tosca" data-bs-toggle="modal" data-bs-target="#addPa">Add PA</button> --}}
                                <a href="{{ route('add.appraisal.form') }}" class=""><button type="button" class="btn btn-tosca">{{ __('performance.label.add_appraisal') }}</button></a>
                            </div>
                        @endcan
                    </div>
                    
                        <table class="table datatable table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ __('general.label.name') }}</th>
                                    <th scope="col">{{ __('general.label.view') }}</th>
                                    {{-- <th scope="col">Edit</th> --}}
                                    <th scope="col">{{ __('general.label.delete') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($appraisal_id as $no=>$appraisal)
                                <tr>
                                    <th scope="row">{{ $no+1 }}</th>
                                    <td>{{ $appraisal->name }}</td>
                                    <td>
                                        @can('update pm')
                                        
                                        <a href="{{ route('appraisal.detail', [
                                            'appraisal_id' => $appraisal->id,
                                            ]) }}" class="btn btn-blue">
                                            <i class="ri-eye-fill"></i>
                                        </a>
                                            {{-- <button type="button" 
                                                class="btn btn-outline-success" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#paEditModal" 
                                                data-id="{{ $appraisal->id }}" 
                                                data-name="{{ $appraisal->name }}">
                                                <i class="ri-edit-box-fill"></i>
                                            </button> --}}
                                        @endcan
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-red" 
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

//script route
window.routeUrls = {
    positionUpdate: "{{ route('position.update', ['id' => '__id__']) }}",
    divisionUpdate: "{{ route('division.update', ['id' => '__id__']) }}",
    jobTitleUpdate: "{{ route('jobTitle.update', ['id' => '__id__']) }}",
    departmentUpdate: "{{ route('department.update', ['id' => '__id__']) }}",
    statusUpdate: "{{ route('status.update', ['id' => '__id__']) }}",
    holidayUpdate: "{{ route('holiday.update', ['id' => '__id__']) }}",
    locationUpdate: "{{ route('location.update', ['id' => '__id__']) }}",
};

//script for edit modal
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.modal').forEach(function (modal) {
        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Button that triggered the modal
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const section = button.getAttribute('data-section');
            const radius = button.getAttribute('data-radius');
            const latitude = button.getAttribute('data-latitude');
            const longitude = button.getAttribute('data-longitude');
            const date = button.getAttribute('data-date');

            //edit form
            const updateType = modal.querySelector('.edit-form').getAttribute('data-update-type');
        
            // Determine the correct route URL based on updateType
            let actionUrl = '';
            switch (updateType) {
                case 'position':
                    actionUrl = window.routeUrls.positionUpdate;
                    break;
                case 'division':
                    actionUrl = window.routeUrls.divisionUpdate;
                    break;
                case 'jobTitle':
                    actionUrl = window.routeUrls.jobTitleUpdate;
                    break;
                case 'department':
                    actionUrl = window.routeUrls.departmentUpdate;
                    break;
                case 'status':
                    actionUrl = window.routeUrls.statusUpdate;
                    break;
                case 'holiday':
                    actionUrl = window.routeUrls.holidayUpdate;
                    break;
                case 'location':
                    actionUrl = window.routeUrls.locationUpdate;
                    break;
            }
        
            // Replace __id__ with the actual ID
            actionUrl = actionUrl.replace('__id__', id);

            // Find the form and input within the current modal
            const form = modal.querySelector('.edit-form');
            const inputName = form.querySelector('input[name="name"]');
            const inputSection = form.querySelector('input[name="section"]');
            const inputRadius = form.querySelector('input[name="radius"]');
            const inputlatitude = form.querySelector('input[name="latitude"]');
            const inputLongitude = form.querySelector('input[name="longitude"]');
            const selectDate = form.querySelector('input[name="date"]');

            if (form && inputName) {
                form.action = actionUrl;
                inputName.value = name || '';
                if (inputSection) inputSection.value = section || '';
                if (inputRadius) inputRadius.value = radius || '';
                if (inputlatitude) inputlatitude.value = latitude || '';
                if (inputLongitude) inputLongitude.value = longitude || '';
                if (selectDate) selectDate.value = date || '';
            }
        });
    });
});

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
                    <input type="number" class="form-control" name="indicators[${index}][target]" step="0.01" required>
                </div>
                <div class="col-2">
                    <input type="number" class="form-control bobot-input" name="indicators[${index}][bobot]" step="0.01" required>
                </div>
                <div class="col-1">
                    <button type="button" class="btn btn-red removeIndicatorBtn">
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



//script route
window.routeUrls = {
        appraisalUpdate: "{{ route('appraisal.update', ['appraisal_id' => '__id__']) }}",
    };

//script for edit modal
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.modal').forEach(function (modal) {
        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Button that triggered the modal
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');

            //edit form
            const updateType = modal.querySelector('.edit-form').getAttribute('data-update-type');
        
            // Determine the correct route URL based on updateType
            let actionUrl = '';
            switch (updateType) {
                case 'appraisal':
                    actionUrl = window.routeUrls.appraisalUpdate;
                    break;
            }
        
            // Replace __id__ with the actual ID
            actionUrl = actionUrl.replace('__id__', id);

            // Find the form and input within the current modal
            const form = modal.querySelector('.edit-form');
            const inputName = form.querySelector('input[name="name"]');

            if (form && inputName) {
                form.action = actionUrl;
                inputName.value = name || '';
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