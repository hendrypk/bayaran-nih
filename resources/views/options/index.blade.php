@extends('_layout.main')
@section('title', 'Options')
@section('content')

<div class="row">

<!-- Position -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="card-header d-flex align-items-center py-0">
                    <h5 class="card-title mb-0 py-3">Position</h5>
                    @can('create options')
                        <div class="ms-auto my-auto">
                            <button id="openAddPositionModal" class="btn btn-untosca">Add Position</button>
                            {{-- <button type="button" class="btn btn-untosca" data-bs-toggle="modal" data-bs-target="#addPosition">Add Position</button> --}}
                        </div>
                    @endcan
                </div>
                    <table class="table datatable table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Position</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($positions as $no=>$position)
                            <tr>
                                <th scope="row">{{ $no+1 }}</th>
                                <td>{{ $position->name }}</td>
                                @csrf
                                 <td>
                                    @can('update options')
                                        <button type="button"
                                            class="btn btn-outline-success" 
                                            data-bs-toggle="modal"
                                            data-bs-target="#positionEditModal"
                                            data-id="{{ $position->id }}"
                                            data-name="{{ $position->name }}" >
                                            <i class="ri-edit-box-fill"></i>
                                        </button>
                                    @endcan
                                </td>
                                <td>
                                    @can('delete options')
                                        <button type="button" class="btn btn-outline-danger" 
                                            onclick="confirmDelete({{ $position->id }}, '{{ $position->name }}', 'position')">
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

<!-- Job Title -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="card-header d-flex align-items-center py-0">
                    <h5 class="card-title mb-0 py-3">Job Title</h5>
                    @can('create options')
                        <div class="ms-auto my-auto">
                            <button id="openAddJobTitleModal" class="btn btn-untosca">Add Job Title</button>
                        </div>
                    @endcan
                </div>
                    <table class="table datatable table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Job Title</th>
                                <th scope="col">Section</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($job_titles as $no=>$data)
                            <tr>
                                <th scope="row">{{ $no+1 }}</th>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->section }}</td>
                                @csrf
                                <td>
                                    @can('update options')
                                        <button type="button"
                                            class="btn btn-outline-success" 
                                            data-bs-toggle="modal"
                                            data-bs-target="#jobTitleEditModal"
                                            data-id="{{ $data->id }}"
                                            data-section="{{ $data->section }}"
                                            data-name="{{ $data->name }}" >
                                            <i class="ri-edit-box-fill"></i>
                                        </button>
                                    @endcan
                                </td>
                                <td>
                                    @can('delete options')
                                        <button type="button" class="btn btn-outline-danger" 
                                            onclick="confirmDelete({{ $data->id }}, '{{ $data->name }}', 'jobtitle')">
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


<!-- division -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="card-header d-flex align-items-center py-0">
                    <h5 class="card-title mb-0 py-3">Division</h5>
                    @can('create options')
                        <div class="ms-auto my-auto">
                            <button id="openAddDivisionModal" class="btn btn-untosca">Add Division</button>
                        </div>
                    @endcan
                </div>
                    <table class="table datatable table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Division</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($divisions as $no=>$data)
                            <tr>
                                <th scope="row">{{ $no+1 }}</th>
                                <td>{{$data->name}}</td>
                                @csrf
                                <td>
                                    @can('update options')
                                        <button type="button" 
                                            class="btn btn-outline-success" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#divisionEditModal" 
                                            data-id="{{ $data->id }}" 
                                            data-name="{{ $data->name }}">
                                            <i class="ri-edit-box-fill"></i>
                                        </button>
                                    @endcan
                                </td>
                                <td>
                                    @can('delete options')
                                        <button type="button" class="btn btn-outline-danger" 
                                            onclick="confirmDelete({{ $data->id }}, '{{ $data->name }}', 'division')">
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

<!-- department -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="card-header d-flex align-items-center py-0">
                    <h5 class="card-title mb-0 py-3">Department</h5>
                    @can('create options')
                        <div class="ms-auto my-auto">
                            <button id="openAddDepartmentModal" class="btn btn-untosca">Add Department</button>
                        </div>
                    @endcan
                </div>
                    <table class="table datatable table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Department</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($departments as $no=>$data)
                            <tr>
                                <th scope="row">{{ $no+1 }}</th>
                                <td>{{ $data->name }}</td>
                                @csrf
                                <td>
                                    @can('update options')
                                        <button type="button" 
                                            class="btn btn-outline-success" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#departmentEditModal" 
                                            data-id="{{ $data->id }}" 
                                            data-name="{{ $data->name }}">
                                            <i class="ri-edit-box-fill"></i>
                                        </button>
                                    @endcan
                                </td>
                                <td>
                                    @can('delete options')
                                        <button type="button" class="btn btn-outline-danger" 
                                            onclick="confirmDelete({{ $data->id }}, '{{ $data->name }}', 'department')">
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


<!-- Employee Status -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="card-header d-flex align-items-center py-0">
                    <h5 class="card-title mb-0 py-3">Employee Status</h5>
                    @can('create options')
                        <div class="ms-auto my-auto">
                            <button id="openAddStatusModal" class="btn btn-untosca">Add Status</button>
                        </div>
                    @endcan
                </div>
                    <table class="table datatable table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Status</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($statuses as $no=>$data)
                            <tr>
                                <th scope="row">{{ $no+1 }}</th>
                                <td>{{ $data->name }}</td>
                                @csrf
                                <td>
                                    @can('update options')
                                        <button type="button" 
                                            class="btn btn-outline-success" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#statusEditModal" 
                                            data-id="{{ $data->id }}" 
                                            data-name="{{ $data->name }}">
                                            <i class="ri-edit-box-fill"></i>
                                        </button>
                                    @endcan
                                </td>
                                <td>
                                    @can('delete options')
                                        <button type="button" class="btn btn-outline-danger" 
                                            onclick="confirmDelete({{ $data->id }}, '{{ $data->name }}', 'status')">
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


<!-- Office Locations -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="card-header d-flex align-items-center py-0">
                    <h5 class="card-title mb-0 py-3">Office Location</h5>
                    @can('create options')
                        <div class="ms-auto my-auto">
                            <button type="button" class="btn btn-untosca" data-bs-toggle="modal" data-bs-target="#locationEditModal">Add Location</button>
                        </div>
                    @endcan
                </div>
        
                    <table class="table datatable table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Radius</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($officeLocation as $no=>$data)
                            <tr>
                                <th scope="row">{{ $no+1 }}</th>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->radius }}</td>
                                @csrf
                                <td>
                                    @can('update options')
                                        <button type="button" 
                                            class="btn btn-outline-success" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#locationEditModal" 
                                            data-id="{{ $data->id }}" 
                                            data-name="{{ $data->name }}"
                                            data-latitude="{{ $data->latitude }}" 
                                            data-longitude="{{ $data->longitude }}" 
                                            data-radius="{{ $data->radius }}" >
                                            <i class="ri-edit-box-fill"></i>
                                        </button>
                                    @endcan
                                </td>
                                <td>
                                    @can('delete options')
                                        <button type="button" class="btn btn-outline-danger" 
                                            onclick="confirmDelete({{ $data->id }}, '{{ $data->name }}', 'location')">
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
</div>

@section('script')

<script>
//script route
window.routeUrls = {
    positionUpdate: "{{ route('position.update', ['id' => '__id__']) }}",
    divisionUpdate: "{{ route('division.update', ['id' => '__id__']) }}",
    jobTitleUpdate: "{{ route('jobTitle.update', ['id' => '__id__']) }}",
    departmentUpdate: "{{ route('department.update', ['id' => '__id__']) }}",
    statusUpdate: "{{ route('status.update', ['id' => '__id__']) }}",
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

            if (form && inputName) {
                form.action = actionUrl;
                inputName.value = name || '';
                if (inputSection) inputSection.value = section || '';
                if (inputRadius) inputRadius.value = radius || '';
            }
        });
    });
});


//Office Location
let map;
let marker;

function initializeMap(lat, lng) {
    if (map) {
        map.setView([lat, lng], 12); // Reset the view if the map already exists
        marker.setLatLng([lat, lng]); // Move the existing marker to the new location
    } else {
        map = L.map('map').setView([lat, lng], 12); // Create a new map
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);
        marker = L.marker([lat, lng]).addTo(map)
            .bindPopup('Your Current Location').openPopup();
    }

    // Map click event to update the marker and hidden inputs
    map.on('click', function (e) {
        if (marker) {
            marker.setLatLng(e.latlng);
            marker.bindPopup("Selected Location: " + e.latlng.toString()).openPopup();
        }

        // Update the hidden form inputs with latitude and longitude
        document.getElementById('latitude').value = e.latlng.lat;
        document.getElementById('longitude').value = e.latlng.lng;
    });
}

// Function to set up the map when the modal is shown
function setupMapModal(lat, lng) {
    if (!map) {
        initializeMap(lat, lng); // Initialize map with specified lat/lng
    } else {
        map.setView([lat, lng]); // Adjust view if map already exists
    }

    // Invalidate map size when modal is shown to ensure proper rendering
    setTimeout(function () {
        map.invalidateSize();
    }, 10);
}

// Get the user's current location using the Geolocation API
$('#addLocation').on('shown.bs.modal', function () {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function (position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                setupMapModal(lat, lng); // Initialize map with user's current location
            },
            function () {
                // If geolocation fails, default to Jakarta
                setupMapModal(-6.2088, 106.8456);
            }
        );
    } else {
        // If browser doesn't support Geolocation, default to Jakarta
        setupMapModal(-6.2088, 106.8456);
    }
});

// For the edit modal, set up the map with existing location data
$('#locationEditModal').on('shown.bs.modal', function (event) {
    const button = $(event.relatedTarget); 
    const name = button.data('name');
    const lat = button.data('latitude');
    const lng = button.data('longitude');
    const radius = button.data('radius');

    setupMapModal(lat, lng); 
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
                fetch(`/options/${entity}/${id}/delete`, { 
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


<script>
    document.addEventListener("DOMContentLoaded", function() {
    // Function to open the modal and update content
    function openModal(title, actionUrl, fieldsHtml) {
        document.getElementById("modalEntityLabel").textContent = title;
        document.getElementById("entityForm").action = actionUrl;
        document.getElementById("entityFields").innerHTML = fieldsHtml;
        new bootstrap.Modal(document.getElementById("addEntityModal")).show();
    }

    // Example usage for opening the modal
    document.getElementById("openAddPositionModal").addEventListener("click", function() {
        openModal(
            "Add ",
            "{{ route('position.add') }}",
            `<label for="positionName" class="form-label">Name</label>
             <input type="text" class="form-control" id="positionName" name="position" required>`
        );
    });

    document.getElementById("openAddJobTitleModal").addEventListener("click", function() {
        openModal(
            "Add Job Title",
            "{{ route('jobTitle.add') }}",
            `<label for="jobTitleName" class="form-label">Name</label>
             <input type="text" class="form-control" id="jobTitleName" name="name" required>
             <label for="jobTitleSection" class="form-label">Section</label>
             <input type="text" class="form-control" id="jobTitleSection" name="section" required>`
        );
    });

    // Repeat for other entities
    document.getElementById("openAddDivisionModal").addEventListener("click", function() {
        openModal(
            "Add Division",
            "{{ route('division.add') }}",
            `<label for="divisionName" class="form-label">Name</label>
             <input type="text" class="form-control" id="divisionName" name="name" required>`
        );
    });

    document.getElementById("openAddDepartmentModal").addEventListener("click", function() {
        openModal(
            "Add Department",
            "{{ route('department.add') }}",
            `<label for="departmentName" class="form-label">Name</label>
             <input type="text" class="form-control" id="departmentName" name="name" required>`
        );
    });

    document.getElementById("openAddStatusModal").addEventListener("click", function() {
        openModal(
            "Add Status",
            "{{ route('status.add') }}",
            `<label for="statusName" class="form-label">Name</label>
             <input type="text" class="form-control" id="statusName" name="name" required>`
        );
    });
});

</script>


@endsection

@include('options.add')
@include('modal.delete')
@include('options.edit')
@endsection