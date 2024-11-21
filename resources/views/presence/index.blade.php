@extends('_layout.main')
@section('title', 'Presence')
@section('content')

<div class="row">
    <x-date-filter action="{{ route('presence.list.admin') }}" 
                    :startDate="request()->get('start_date')" 
                    :endDate="request()->get('end_date')" />
    

    <div class="col-md">
        <div class="card">
            <div class="card-body">
                <div class="card-header d-flex align-items-center py-0">
                    <div class="col-md-9">
                        <h5 class="card-title mb-0 py-3">Presences List</h5>
                    </div>
                    <div class="button-container">
                        @can('presence export')
                        <div class="form-container">
                            <form action="{{ route('presence.export') }}" method="POST">
                                @csrf
                                <input type="hidden" name="start_date" value="{{ request()->get('start_date') }}">
                                <input type="hidden" name="end_date" value="{{ request()->get('end_date') }}">
                                <button type="submit" class="btn btn-tosca">Export</button>
                            </form>
                        </div>
                        @endcan

                        @can('create presence')
                            <button type="button" class="btn btn-untosca"
                            data-bs-toggle="modal" 
                            data-bs-target="#addPresence">
                            Add Presence
                            </button>
                        @endcan
                    </div>
                </div>
        
                <!-- Table with hoverable rows -->
                <div class="card-table-wrapper"> 
                    <table class="table datatable table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">EID</th>
                                <th scope="col">Employee Name</th>
                                <th scope="col">Work Day</th>
                                <th scope="col">Date</th>
                                <th scope="col">Check In</th>
                                <th scope="col">Check Out</th>
                                <th scope="col">Late Arrival</th>
                                <th scope="col">Late Check in</th>
                                <th scope="col">Check Out Early</th>
                                <th scope="col">Note In</th>
                                <th scope="col">Note Out</th>
                                <th scope="col">Location In</th>
                                <th scope="col">Location Out</th>
                                <th scope="col">Photo In</th>
                                <th scope="col">Photo Out</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($presence as $no=>$data)
                            <tr>
                                <th scope="row">{{ $no+1 }}</th>
                                <td>{{ $data->employee->eid }}</td>
                                <td>{{ $data->employee->name }}</td>
                                <td>{{ $data['work_day_id'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($data['date'])->format('d F Y')  }}</td>
                                <td>{{ $data['check_in'] }}</td>
                                <td>{{ $data['check_out'] }}</td>
                                <td>
                                    @if($data['late_arrival'] == 1)
                                        Late Arrival
                                        @else
                                            On Time
                                    @endif
                                </td>
                                <td>{{ $data['late_check_in'] }}</td>
                                <td>{{ $data['check_out_early'] }}</td>
                                <td>{{ $data['note_in']}}</td>
                                <td>{{ $data['note_out'] }}</td>
                                <td>{{ $data['location_in'] }}</td>
                                <td>{{ $data['location_out'] }}</td>
                                <td>
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#photoModal"
                                            onclick="showPhoto('{{ Storage::url('presences/' . $data['photo_in']) }}')">
                                            <i class="ri-eye-line"></i>
                                    </button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#photoModal"
                                            onclick="showPhoto('{{ Storage::url('presences/' . $data['photo_out']) }}')">
                                            <i class="ri-eye-line"></i>
                                    </button>
                                </td>
                                <td>
                                    @can('update presence')
                                        <button type="button" class="btn btn-outline-success"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editPresence" 
                                                data-id="{{ $data['id'] }}" 
                                                data-name="{{ $data->employee->name }}"
                                                data-date="{{ $data['date'] }}"
                                                data-workDay="{{ $data['work_day_id'] }}"
                                                data-checkin="{{ $data['check_in'] }}"
                                                data-checkout="{{ $data['check_out'] }}">
                                            <i class="ri-edit-line"></i>
                                        </button>
                                    @endcan
                                </td>
                                <td>
                                    @can('delete presence')
                                    <button type="button" class="btn btn-outline-danger" 
                                        onclick="confirmDelete({{ $data->id }}, '{{ $data->employee->name }}', 'presences')">
                                        <i class="ri-delete-bin-fill"></i>
                                    </button>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- End Table with hoverable rows -->
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">Employee Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="modalPhoto" src="" alt="Employee Photo" class="img-fluid">
            </div>
        </div>
    </div>
</div>


@section('script')
<script>

// Set the image src in the modal
function showPhoto(photoUrl) {
    document.getElementById('modalPhoto').src = photoUrl;
}
document.addEventListener('DOMContentLoaded', function () {
    const editModal = document.getElementById('editPresence');
    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // Button that triggered the modal
        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        const date = button.getAttribute('data-date');
        const workDay = button.getAttribute('data-workDay');
        const checkin = button.getAttribute('data-checkin');
        const checkout = button.getAttribute('data-checkout');

        document.getElementById('name').value = name;
        document.getElementById('date').value = date;
        document.getElementById('workDay').value = workDay;
        document.getElementById('checkin').value = checkin;
        document.getElementById('checkout').value = checkout;


        // Set form action dynamically with the correct ID
        const form = document.getElementById('editPresenceForm');
        form.action = `{{ url('presences') }}/${id}/update`; // Set the action with the correct ID
        document.getElementById('presenceId').value = id; // Set the hidden input value
    
    });
});

//Work Day On Add Presence Modal
document.getElementById('employeeSelect').addEventListener('change', function() {
    var employeeId = this.value;
    var workDaySelect = document.getElementById('workDaySelect');
    var workDayContainer = document.getElementById('workDayContainer');

    // Clear previous options
    workDaySelect.innerHTML = '<option selected disabled>Select Work Day</option>';

    // Check if an employee is selected
    if (employeeId) {
        // Fetch the work days for the selected employee
        var workDays = @json($workDay);
        var selectedWorkDays = workDays[employeeId] || [];
console.log(workDays);
        // Check if there is more than one work day
        if (selectedWorkDays.length > 1) {
            selectedWorkDays.forEach(function(workDay) {
                var option = document.createElement('option');
                option.value = workDay.name; // Set the value to the ID
                option.text = workDay.name; // Display the name
                workDaySelect.appendChild(option);
            });
            workDaySelect.disabled = false; // Enable selection
            workDayContainer.style.display = 'block';
        } else if (selectedWorkDays.length === 1) {
            // If there's only one work day, set its value and keep it enabled
            workDaySelect.value = selectedWorkDays[0].id; // Set to the ID
            workDaySelect.innerHTML = ''; // Clear previous options
            var option = document.createElement('option');
            option.value = selectedWorkDays[0].name; // Set the value
            option.text = selectedWorkDays[0].name; // Display the name
            workDaySelect.appendChild(option);
            workDaySelect.disabled = false; // Keep it enabled
            workDayContainer.style.display = 'block';
        } else {
            workDayContainer.style.display = 'none'; // No work days
        }
    } else {
        workDayContainer.style.display = 'none'; // No employee selected
    }
});


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
@include('presence.add')
@include('presence.edit')