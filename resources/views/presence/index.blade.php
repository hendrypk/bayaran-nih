@extends('_layout.main')
@section('title', 'Presence')
@section('content')


{{ Breadcrumbs::render('presence') }}
<div class="row align-items-center">
    <div class="col-md-9">
        <x-date-filter action="{{ route('presence.list.admin') }}" 
                        :startDate="request()->get('start_date')" 
                        :endDate="request()->get('end_date')" />
    </div>
    <div class="col-md-3 d-flex justify-content-end">
        <form action="{{ route('presence.export') }}" method="POST" class="me-2" style="margin: 0;">
            @csrf
            <input type="hidden" name="start_date" value="{{ request()->get('start_date') }}">
            <button type="submit" class="btn btn-tosca btn-sm">
                <i class="ri-download-cloud-2-fill"></i>
            </button>
        </form>
        <div class="form-container">
            <a href="{{ route('presence.import') }}" class="btn btn-tosca me-2"><i class="ri-file-upload-fill"></i></a>
        </div>
        <button type="button" class="btn btn-untosca btn-sm"
                data-bs-toggle="modal" 
                data-bs-target="#addPresence">
            <i class="ri-add-circle-line"></i>
        </button>
    </div>
</div>

<div class="row">
        <div class="col-md">
        <div class="card">
            <div class="card-body">
                <div class="card-header d-flex align-items-center py-0">
                    <div class="col-md-9">
                        <h5 class="card-title mb-0 py-3">Presences List</h5>
                    </div>
                        {{-- <div class="button-container">
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

                            <div class="form-container">
                                <a href="{{ route('presence.import') }}" class="btn btn-tosca">Import</a>
                            </div>

                            @can('create presence')
                                <button type="button" class="btn btn-untosca"
                                data-bs-toggle="modal" 
                                data-bs-target="#addPresence">
                                Add Presence
                                </button>
                            @endcan
                        </div> --}}
                </div>
                <div class="card-table-wrapper"> 
                    <table class="table datatable table-hover">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <input type="checkbox" id="select-all" onclick="toggleSelectAll(this)">
                                </th>
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
                                <td>
                                    <input type="checkbox" class="select-item" value="{{ $data['id'] }}">
                                </td>                                       
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
                                <td>
                                    <button class="btn btn-primary" onclick="showLocationModal('location_in', '{{ $data['location_in'] }}')">
                                        <i class="ri-road-map-line"></i>
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-outline-primary" onclick="showLocationModal('location_out', '{{ $data['location_out'] }}')">
                                        <i class="ri-road-map-line"></i>
                                    </button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#photoModal"
                                            onclick="showPhoto('{{ Storage::url('public/presences/' . $data['photo_in']) }}')">
                                            <i class="ri-eye-line"></i>
                                    </button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#photoModal"
                                            onclick="showPhoto('{{ Storage::url('public/presences/' . $data['photo_out']) }}')">
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
            </div>
        </div>
    </div>
</div>

{{-- <!-- Modal -->
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
</div> --}}


@section('script')
<script>

//Select all
function toggleSelectAll(source) {
    const checkboxes = document.querySelectorAll('.select-item');
    checkboxes.forEach(checkbox => {
        checkbox.checked = source.checked;
    });
}


//Show map
let mapPresence, marker;  // Variabel untuk peta dan marker

// Inisialisasi peta
function initMapPresence() {
    const mapElement = document.getElementById('mapPresence');

    if (!mapElement) {
        console.error('Element with ID "mapPresence" not found!');
        return;
    }

    // Membuat peta dengan lat, lng default
    mapPresence = L.map('mapPresence');  // Set lat, lng dan zoom default
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(mapPresence);
}

// Menampilkan lokasi pada modal
function showLocationModal(locationType, location) {
    if (!mapPresence) {
        console.error('Map is not initialized. Please call initMapPresence first.');
        return;
    }

    if (!location) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Lokasi presensi tidak ditemukan!',
        });
        return;
    }

    // Memecah lat, lng yang diterima
    const [lat, lng] = location.split(',').map(Number);

    if (isNaN(lat) || isNaN(lng)) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Koordinat lokasi tidak valid!',
        });
        return;
    }

    // Menampilkan modal Bootstrap
    const modal = new bootstrap.Modal(document.getElementById('locationModal'));
    modal.show();

    // Menghapus marker lama jika ada
    if (marker) mapPresence.removeLayer(marker);

    // Update peta dan tambahkan marker
    mapPresence.setView([lat, lng], 15);  // Set peta ke lat, lng yang baru
    marker = L.marker([lat, lng]).addTo(mapPresence).bindPopup(`${locationType}`).openPopup();
}

// Memanggil initMapPresence setelah halaman selesai dimuat
document.addEventListener('DOMContentLoaded', function () {
    initMapPresence();
});


// Set the image src in the modal
function showPhoto(photoUrl) {
    const img = new Image();

    // Cek apakah gambar tersedia
    img.onload = function() {
        // Jika gambar berhasil dimuat, set gambar ke dalam modal dan buka modal
        document.getElementById('modalPhoto').src = photoUrl;
        
        // Buka modal setelah gambar dimuat
        const photoModal = new bootstrap.Modal(document.getElementById('photoModal'));
        photoModal.show();
    };

    img.onerror = function() {
        // Jika gambar gagal dimuat, tampilkan error menggunakan SweetAlert
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Gambar tidak ditemukan!',
        });
    };

    // Menetapkan URL gambar untuk memulai pengecekan
    img.src = photoUrl;
}

//script for edit
document.addEventListener('DOMContentLoaded', function () {
    const editModal = document.getElementById('editPresence');
    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; 
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
        form.action = `{{ url('presences') }}/${id}/update`; 
        document.getElementById('presenceId').value = id;    
    });
});

document.getElementById('employeeSelect').addEventListener('change', function () {
    var employeeId = this.value; 
    var workDays = @json($workDay);
    var workDaySelect = document.getElementById('workDaySelect');
    var workDayContainer = document.getElementById('workDayContainer');

    // Clear previous options
    workDaySelect.innerHTML = '<option selected disabled>Select Work Day</option>';

    // Cek jika employee_id ada di workDays
    if (employeeId && workDays[employeeId]) {
        var selectedWorkDays = workDays[employeeId];

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
            workDayContainer.style.display = 'block'; // No work days
        }
    } else {
        workDayContainer.style.display = 'block'; // No employee selected
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
@include('presence.map')
@include('presence.photo')