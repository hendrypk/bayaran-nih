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
                    <div class="ms-auto my-auto">
                        <!-- <a class="btn btn-untosca" href="{{route('employee.add')}}"><i class="ph-plus-circle me-1">Add Position</i></a> -->
                        <button type="button" class="btn btn-untosca" data-bs-toggle="modal" data-bs-target="#addPosition">Add Position</button>
                    </div>
                </div>
        
                <!-- Table with hoverable rows -->
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
                                <!-- edit button -->
                                 <td>
                                    <button type="button"
                                        class="btn btn-outline-success" 
                                        data-bs-toggle="modal"
                                        data-bs-target="#positionEditModal"
                                        data-id="{{ $position->id }}"
                                        data-name="{{ $position->name }}" >
                                        <i class="ri-edit-box-fill"></i>
                                    </button>
                                </td>
                                <!-- delete button -->
                                <td>
                                    <button type="button" class="btn btn-outline-danger" 
                                        onclick="confirmDelete({{ $position->id }}, '{{ $position->name }}', 'position')">
                                        <i class="ri-delete-bin-fill"></i>
                                    </button>
                                </td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                <!-- End Table with hoverable rows -->
            </div>
        </div>
    </div>

<!-- Job Title -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="card-header d-flex align-items-center py-0">
                    <h5 class="card-title mb-0 py-3">Job Title</h5>
                    <div class="ms-auto my-auto">
                        <button type="button" class="btn btn-untosca" data-bs-toggle="modal" data-bs-target="#addJobTitle">Add Job Title</button>
                    </div>
                </div>
        
                <!-- Table with hoverable rows -->
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
                                <!-- edit button -->
                                <td>
                                    <button type="button"
                                        class="btn btn-outline-success" 
                                        data-bs-toggle="modal"
                                        data-bs-target="#jobTitleEditModal"
                                        data-id="{{ $data->id }}"
                                        data-section="{{ $data->section }}"
                                        data-name="{{ $data->name }}" >
                                        <i class="ri-edit-box-fill"></i>
                                    </button>
                                </td>
                                <!-- delete button -->
                                <td>
                                    <button type="button" class="btn btn-outline-danger" 
                                        onclick="confirmDelete({{ $data->id }}, '{{ $data->name }}', 'jobtitle')">
                                        <i class="ri-delete-bin-fill"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                <!-- End Table with hoverable rows -->
            </div>
        </div>
    </div>


<!-- division -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="card-header d-flex align-items-center py-0">
                    <h5 class="card-title mb-0 py-3">Division</h5>
                    <div class="ms-auto my-auto">
                        <!-- <a class="btn btn-untosca" href="{{route('employee.add')}}"><i class="ph-plus-circle me-1">Add Division</i></a> -->
                        <button type="button" class="btn btn-untosca" data-bs-toggle="modal" data-bs-target="#addDivision">Add Division</button>
                    </div>
                </div>
        
                <!-- Table with hoverable rows -->
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
                                <!-- edit button -->
                                <td>
                                    <button type="button" 
                                        class="btn btn-outline-success" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#divisionEditModal" 
                                        data-id="{{ $data->id }}" 
                                        data-name="{{ $data->name }}">
                                        <i class="ri-edit-box-fill"></i>
                                    </button>
                                </td>
                                <!-- delete button -->
                                <td>
                                    <button type="button" class="btn btn-outline-danger" 
                                        onclick="confirmDelete({{ $data->id }}, '{{ $data->name }}', 'division')">
                                        <i class="ri-delete-bin-fill"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                <!-- End Table with hoverable rows -->
            </div>
        </div>
    </div>

<!-- department -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="card-header d-flex align-items-center py-0">
                    <h5 class="card-title mb-0 py-3">Department</h5>
                    <div class="ms-auto my-auto">
                        <button type="button" class="btn btn-untosca" data-bs-toggle="modal" data-bs-target="#addDepartment">Add Department</button>
                    </div>
                </div>
        
                <!-- Table with hoverable rows -->
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
                                <!-- edit button -->
                                <td>
                                    <button type="button" 
                                        class="btn btn-outline-success" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#departmentEditModal" 
                                        data-id="{{ $data->id }}" 
                                        data-name="{{ $data->name }}">
                                        <i class="ri-edit-box-fill"></i>
                                    </button>
                                </td>
                                <!-- delete button -->
                                <td>
                                    <button type="button" class="btn btn-outline-danger" 
                                        onclick="confirmDelete({{ $data->id }}, '{{ $data->name }}', 'department')">
                                        <i class="ri-delete-bin-fill"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                <!-- End Table with hoverable rows -->
            </div>
        </div>
    </div>


<!-- Employee Status -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="card-header d-flex align-items-center py-0">
                    <h5 class="card-title mb-0 py-3">Employee Status</h5>
                    <div class="ms-auto my-auto">
                        <button type="button" class="btn btn-untosca" data-bs-toggle="modal" data-bs-target="#addStatus">Add Status</button>
                    </div>
                </div>
        
                <!-- Table with hoverable rows -->
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
                                <!-- edit button -->
                                <td>
                                    <button type="button" 
                                        class="btn btn-outline-success" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#statusEditModal" 
                                        data-id="{{ $data->id }}" 
                                        data-name="{{ $data->name }}">
                                        <i class="ri-edit-box-fill"></i>
                                    </button>
                                </td>
                                <!-- delete button -->
                                <td>
                                    <button type="button" class="btn btn-outline-danger" 
                                        onclick="confirmDelete({{ $data->id }}, '{{ $data->name }}', 'status')">
                                        <i class="ri-delete-bin-fill"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                <!-- End Table with hoverable rows -->
            </div>
        </div>
    </div>


<!-- Office Locations -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="card-header d-flex align-items-center py-0">
                    <h5 class="card-title mb-0 py-3">Office Location</h5>
                    <div class="ms-auto my-auto">
                        <button type="button" class="btn btn-untosca" data-bs-toggle="modal" data-bs-target="#addLocation">Add Location</button>
                    </div>
                </div>
        
                    <table class="table datatable table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Radius</th>
                                <th scope="col">Show</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($officeLocation as $no=>$officeLocation)
                            <tr>
                                <th scope="row">{{ $no+1 }}</th>
                                <td>{{ $officeLocation->name }}</td>
                                <td>{{ $officeLocation->radius }}</td>
                                @csrf
                                <td>
                                    <button type="button" 
                                        class="btn btn-outline-primary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#locationShow" 
                                        data-id="{{ $officeLocation->id }}" 
                                        data-name="{{ $officeLocation->name }}">
                                        <i class="ri-eye-fill"></i>
                                    </button>
                                </td>
                                <td>
                                    <button type="button" 
                                        class="btn btn-outline-success" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#locationEditModal" 
                                        data-id="{{ $officeLocation->id }}" 
                                        data-name="{{ $officeLocation->name }}"
                                        data-latitude="{{ $officeLocation->latitude }}" 
                                        data-longitude="{{ $officeLocation->longitude }}" 
                                        data-radius="{{ $officeLocation->radius }}" >
                                        <i class="ri-edit-box-fill"></i>
                                    </button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-outline-danger" 
                                        onclick="confirmDelete({{ $officeLocation->id }}, '{{ $officeLocation->name }}', 'location')">
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

<!-- work schedule -->
    <!-- <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="card-header d-flex align-items-center py-0">
                    <h5 class="card-title mb-0 py-3">Work Schedlue</h5>
                    <div class="ms-auto my-auto">
                        <button type="button" class="btn btn-untosca" data-bs-toggle="modal" data-bs-target="#addSchedule">Add Work Schedlue</button>
                    </div>
                </div>
        
                    <table class="table datatable table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Schedlue Name</th>
                                <th scope="col">Arrival</th>
                                <th scope="col">Start at</th>
                                <th scope="col">End at</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schedules as $no=>$schedule)
                            <tr>
                                <th scope="row">{{ $no+1 }}</th>
                                <td>{{ $schedule->name }}</td>
                                <td>{{ $schedule->arrival }}</td>
                                <td>{{ $schedule->start_at}}</td>
                                <td>{{ $schedule->end_at}}</td>
                                <td>
                                    <button type="button" 
                                        class="btn btn-outline-success" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#scheduleEditModal" 
                                        data-id="{{ $schedule->id }}" 
                                        data-name="{{ $schedule->name }}"
                                        data-arrival="{{ $schedule->arrival }}"
                                        data-start="{{ $schedule->start_at }}"
                                        data-end="{{ $schedule->end_at }}">
                                        <i class="ri-edit-box-fill"></i>
                                    </button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-outline-danger"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal" 
                                        data-entity="schedule" 
                                        data-id="{{ $schedule->id }}" 
                                        data-name="{{ $schedule->name }}">
                                        <i class="ri-delete-bin-fill"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>
        </div>
    </div> -->

</div>


<!-- On Day Calendar -->
<!-- <div class="row">
    <div class="col-lg">
        <div class="card">
            <div class="card-body">
                <div class="card-header d-flex align-items-center py-0">
                    <h5 class="card-title mb-0 py-3">On-Day Calendar</h5>
                    <div class="ms-auto my-auto">
                        <button type="button" class="btn btn-untosca" data-bs-toggle="modal" data-bs-target="#addOnDayCalendar">Add On-Day</button>
                    </div>
                </div>
        
                    <table class="table datatable table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">January</th>
                                <th scope="col">February</th>
                                <th scope="col">March</th>
                                <th scope="col">April</th>
                                <th scope="col">May</th>
                                <th scope="col">June</th>
                                <th scope="col">July</th>
                                <th scope="col">August</th>
                                <th scope="col">September</th>
                                <th scope="col">October</th>
                                <th scope="col">November</th>
                                <th scope="col">December</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($calendars as $no=>$calendar)
                            <tr>
                                <th scope="row">{{ $no+1 }}</th>
                                <td>{{ $calendar->name }}</td>
                                <td>{{ $calendar->jan }}</td>
                                <td>{{ $calendar->feb }}</td>
                                <td>{{ $calendar->mar }}</td>
                                <td>{{ $calendar->apr }}</td>
                                <td>{{ $calendar->may }}</td>
                                <td>{{ $calendar->jun }}</td>
                                <td>{{ $calendar->jul }}</td>
                                <td>{{ $calendar->aug }}</td>
                                <td>{{ $calendar->sep }}</td>
                                <td>{{ $calendar->oct }}</td>
                                <td>{{ $calendar->nov }}</td>
                                <td>{{ $calendar->dec }}</td>
                                <td>
                                    <button type="button" 
                                        class="btn btn-outline-success" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#calendarEditModal" 
                                        data-id="{{ $calendar->id }}" 
                                        data-name="{{ $calendar->name }}"
                                        data-jan="{{ $calendar->jan }}"
                                        data-feb="{{ $calendar->feb }}"
                                        data-mar="{{ $calendar->mar }}"
                                        data-apr="{{ $calendar->apr }}"
                                        data-may="{{ $calendar->may }}"
                                        data-jun="{{ $calendar->jun }}"
                                        data-jul="{{ $calendar->jul }}"
                                        data-aug="{{ $calendar->aug }}"
                                        data-sep="{{ $calendar->sep }}"
                                        data-oct="{{ $calendar->oct }}"
                                        data-nov="{{ $calendar->nov }}"
                                        data-dec="{{ $calendar->dec }}">
                                        <i class="ri-edit-box-fill"></i>
                                    </button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-outline-danger"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal" 
                                        data-entity="onday" 
                                        data-id="{{ $calendar->id }}" 
                                        data-name="{{ $calendar->name }}">
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
</div> -->


@section('script')

<script>
//Script for Delete Modal
  document.addEventListener('DOMContentLoaded', function () {
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      const entity = button.getAttribute('data-entity'); // e.g., 'position', 'department', etc.
      const id = button.getAttribute('data-id'); // Entity ID
      const name = button.getAttribute('data-name'); // Entity name (optional)
      
      // Update modal title and body text
      const entityNameElement = document.getElementById('entityName');
      entityNameElement.textContent = entity;
      
      // Update form action URL
      const form = document.getElementById('deleteForm');
      form.action = `/options/${entity}/${id}/delete`;

      // Optionally update the modal title to include the entity's name
      const modalTitle = document.getElementById('deleteModalLabel');
      modalTitle.textContent = `Delete ${entity.charAt(0).toUpperCase() + entity.slice(1)}: ${name}`;
    });
  });

//script route
    window.routeUrls = {
        positionUpdate: "{{ route('position.update', ['id' => '__id__']) }}",
        divisionUpdate: "{{ route('division.update', ['id' => '__id__']) }}",
        jobTitleUpdate: "{{ route('jobTitle.update', ['id' => '__id__']) }}",
        departmentUpdate: "{{ route('department.update', ['id' => '__id__']) }}",
        salesPersonUpdate: "{{ route('salesPerson.update', ['id' => '__id__']) }}",
        scheduleUpdate: "{{ route('schedule.update', ['id' => '__id__']) }}",
        statusUpdate: "{{ route('status.update', ['id' => '__id__']) }}",
        calendarUpdate: "{{ route('onDayCalendar.update', ['id' => '__id__']) }}",
    };

//script for edit modal
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.modal').forEach(function (modal) {
        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Button that triggered the modal
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            //job title
            const section = button.getAttribute('data-section');
            //schedule
            const arrival = button.getAttribute('data-arrival');
            const start = button.getAttribute('data-start');
            const end = button.getAttribute('data-end');
            //Indicator
            const jobTitle = button.getAttribute('data-jobTitle');
            const target = button.getAttribute('data-target');
            const bobot = button.getAttribute('data-bobot');
            //On-Day
            const jan = button.getAttribute('data-jan');
            const feb = button.getAttribute('data-feb');
            const mar = button.getAttribute('data-mar');
            const apr = button.getAttribute('data-apr');
            const may = button.getAttribute('data-may');
            const jun = button.getAttribute('data-jun');
            const jul = button.getAttribute('data-jul');
            const aug = button.getAttribute('data-aug');
            const sep = button.getAttribute('data-sep');
            const oct = button.getAttribute('data-oct');
            const nov = button.getAttribute('data-nov');
            const dec = button.getAttribute('data-dec');

            //edit form
            const updateType = modal.querySelector('.edit-form').getAttribute('data-update-type');
        
            // Determine the correct route URL based on updateType
            let actionUrl = '';
            switch (updateType) {
                // Add other cases as needed
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
                case 'salesPerson':
                    actionUrl = window.routeUrls.salesPersonUpdate;
                    break;
                case 'schedule':
                    actionUrl = window.routeUrls.scheduleUpdate;
                    break;
                case 'status':
                    actionUrl = window.routeUrls.statusUpdate;
                    break;
                case 'indicator':
                    actionUrl = window.routeUrls.indicatorUpdate;
                    break;
                case 'appraisal':
                    actionUrl = window.routeUrls.appraisalUpdate;
                    break;
                case 'calendar':
                    actionUrl = window.routeUrls.calendarUpdate;
                    break;
            }
        
            // Replace __id__ with the actual ID
            actionUrl = actionUrl.replace('__id__', id);

            // Find the form and input within the current modal
            const form = modal.querySelector('.edit-form');
            const inputName = form.querySelector('input[name="name"]');
            //job title field
            const inputSection = form.querySelector('input[name="section"]');
            //schedule field
            const inputArrival = form.querySelector('input[name="arrival"]');
            const inputStart = form.querySelector('input[name="start"]');
            const inputEnd = form.querySelector('input[name="end"]');
            //indicator field
            const inputJobTitle = form.querySelector('select[name="jobTitle"]');
            const inputTarget = form.querySelector('input[name="target"]');
            const inputBobot = form.querySelector('input[name="bobot"]');
            //calendar field
            const inputJan = form.querySelector('input[name="jan"]');
            const inputFeb = form.querySelector('input[name="feb"]');
            const inputMar = form.querySelector('input[name="mar"]');
            const inputApr = form.querySelector('input[name="apr"]');
            const inputMay = form.querySelector('input[name="may"]');
            const inputJun = form.querySelector('input[name="jun"]');
            const inputJul = form.querySelector('input[name="jul"]');
            const inputAug = form.querySelector('input[name="aug"]');
            const inputSep = form.querySelector('input[name="sep"]');
            const inputOct = form.querySelector('input[name="oct"]');
            const inputNov = form.querySelector('input[name="nov"]');
            const inputDec = form.querySelector('input[name="dec"]');



            if (form && inputName) {
                // Update form action and input values
                form.action = actionUrl;
                inputName.value = name || '';
                //for job title
                if (inputSection) inputSection.value = section || '';
                //for schedule
                if (inputArrival) inputArrival.value = arrival || '';
                if (inputStart) inputStart.value = start || '';
                if (inputEnd) inputEnd.value = end || '';
                //for indicator
                if (inputJobTitle) inputJobTitle.value = jobTitle || '';
                if (inputTarget) inputTarget.value = target || '';
                if (inputBobot) inputBobot.value = bobot || '';
                //for calendar
                if (inputJan) inputJan.value = jan || '';
                if (inputFeb) inputFeb.value = feb || '';
                if (inputMar) inputMar.value = mar || '';
                if (inputApr) inputApr.value = apr || '';
                if (inputMay) inputMay.value = may || '';
                if (inputJun) inputJun.value = jun || '';
                if (inputJul) inputJul.value = jul || '';
                if (inputAug) inputAug.value = aug || '';
                if (inputSep) inputSep.value = sep || '';
                if (inputOct) inputOct.value = oct || '';
                if (inputNov) inputNov.value = nov || '';
                if (inputDec) inputDec.value = dec || '';
            }
        });
    });
});


//Office Location
let map;
let marker;

// Function to initialize the map
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
    const button = $(event.relatedTarget); // Button that triggered the modal
    const lat = button.data('latitude'); // Extract latitude from data attribute
    const lng = button.data('longitude'); // Extract longitude from data attribute
    setupMapModal(lat, lng); // Initialize map with the specified lat/lng
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



@endsection

@include('options.add')
@include('modal.delete')
@include('options.edit')
@endsection