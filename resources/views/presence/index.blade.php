@extends('_layout.main')
@section('title', __('sidebar.label.presences'))
@section('content')


{{ Breadcrumbs::render('presence') }}
<div class="row align-items-center mb-3">
    <!-- Filter -->
    <div class="col-md-6">
        <div class="d-flex flex-wrap gap-2">
            <!-- Status Filter -->
                <form action="{{ route('presence.list.admin') }}" method="GET" class="m-0 d-flex">
                    <input type="hidden" name="start_date" value="{{ request()->get('start_date') }}">
                    <input type="hidden" name="end_date" value="{{ request()->get('end_date') }}">
                    <select id="status" name="status" class="form-select" onchange="this.form.submit()">
                        <option value="presence" {{ request()->get('status') === 'presence' ? 'selected' : '' }}>Presence</option>
                        <option value="absence" {{ request()->get('status') === 'absence' ? 'selected' : '' }}>Absence</option>
                    </select>
                </form>


            <!-- Date Range Filter -->
            <livewire:date-range-filter 
                startDate="{{ request()->get('start_date') ?: '' }}" 
                endDate="{{ request()->get('end_date') ?: '' }}" />
        </div>
    </div>

    <!-- Actions -->
    <div class="col-md-6">
        <div class="d-flex justify-content-md-end justify-content-start flex-wrap gap-2">
            @can('presence export')
                <form action="{{ route('presence.export') }}" method="POST" class="m-0">
                    @csrf
                    <input type="hidden" id="exportStart" name="start_date" value="{{ request()->get('start_date') }}">
                    <input type="hidden" id="exportEnd" name="end_date" value="{{ request()->get('end_date') }}">
                    <input type="hidden" id="exportStatus" name="status" value="{{ request()->get('status') }}">
                
                    <button type="submit" class="btn btn-tosca btn-sm d-flex align-items-center gap-1">
                        <i class="ri-download-cloud-2-fill"></i>
                        <span>{{ __('general.label.export') }}</span>
                    </button>
                </form>
            @endcan

            <a href="{{ route('presence.import') }}" 
               class="btn btn-tosca btn-sm d-flex align-items-center gap-1">
                <i class="ri-file-upload-fill"></i>
                <span>{{ __('general.label.import') }}</span>
            </a>

            @can('create presence')
                <button type="button" class="btn btn-tosca btn-sm d-flex align-items-center"
                        data-bs-toggle="modal" 
                        data-bs-target="#addPresence">
                    <i class="ri-add-circle-line"></i>
                </button>
            @endcan
        </div>
    </div>
</div>

<div class="row">
        <div class="col-md">
        <div class="card">
            <div class="card-body">
                <div class="card-header d-flex align-items-center py-0">
                    <div class="col-md-9">
                        <h5 class="card-title mb-0 py-3">{{ __('attendance.label.presence_list') }}</h5>
                    </div>
                </div>
                <div class="card-table-wrapper"> 
                    <livewire:presence-table
                        :status="request()->get('status')" 
                        :startDate="request()->get('start_date')" 
                        :endDate="request()->get('end_date')" />
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
<script>

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

function showLocationAndPhoto(locationType, location, photoUrl) {
    if (!mapPresence) initMapPresence();

    if (!location) {
        Swal.fire({ icon: 'error', title: 'Oops...', text: 'Lokasi presensi tidak ditemukan!' });
        return;
    }

    const [lat, lng] = location.split(',').map(Number);
    if (isNaN(lat) || isNaN(lng)) {
        Swal.fire({ icon: 'error', title: 'Oops...', text: 'Koordinat lokasi tidak valid!' });
        return;
    }

    const img = new Image();
    img.onload = function() {
        document.getElementById('modalPhoto').src = photoUrl;

        const modalEl = document.getElementById('locationPhotoModal');
        const modal = new bootstrap.Modal(modalEl);
        modal.show();

        // Jalankan setelah modal benar-benar terbuka
        modalEl.addEventListener('shown.bs.modal', function onShown() {
            modalEl.removeEventListener('shown.bs.modal', onShown);

            mapPresence.invalidateSize();

            if (marker) mapPresence.removeLayer(marker);
            mapPresence.setView([lat, lng], 15);
            marker = L.marker([lat, lng])
                .addTo(mapPresence)
                .bindPopup(`${locationType}`)
                .openPopup();
        });
    };

    img.onerror = function() {
        Swal.fire({ icon: 'error', title: 'Oops...', text: 'Gambar tidak ditemukan!' });
    };

    img.src = photoUrl;
}

document.addEventListener('DOMContentLoaded', function () {
    initMapPresence();

    // ===== Employee → WorkDays Dropdown =====
    function setupEmployeeWorkDays(employeeSelectId, workDaySelectId, workDayContainerId, workDays) {
        const employeeSelect = document.getElementById(employeeSelectId);
        const workDaySelect = document.getElementById(workDaySelectId);
        const workDayContainer = document.getElementById(workDayContainerId);

        if (!employeeSelect || !workDaySelect || !workDayContainer) return;

        employeeSelect.addEventListener('change', function () {
            const employeeId = this.value;

            // Clear previous options
            workDaySelect.innerHTML = '<option selected disabled>Select Work Day</option>';

            if (employeeId && workDays[employeeId] && workDays[employeeId].length > 0) {
                workDays[employeeId].forEach(function (workDay) {
                    const option = document.createElement('option');
                    option.value = workDay.id;
                    option.text = workDay.name;
                    workDaySelect.appendChild(option);
                });
                workDaySelect.disabled = false;
                workDayContainer.style.display = 'block';
            } else {
                workDaySelect.disabled = true;
                workDayContainer.style.display = 'none';
            }
        });
    }

    // ===== Modal Edit =====
    const editModal = document.getElementById('editPresence');
    if (editModal) {
        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; 
            const id = button.getAttribute('data-id');
            const employee_id = button.getAttribute('data-employee-id');
            const name = button.getAttribute('data-name');
            const date = button.getAttribute('data-date');
            const workDay = button.getAttribute('data-workDay');
            const workDayName = button.getAttribute('data-workday-name');
            const checkin = button.getAttribute('data-checkin');
            const checkout = button.getAttribute('data-checkout');

            document.getElementById('id').value = id;
            document.getElementById('employee_id').value = employee_id;
            document.getElementById('name').value = name;
            document.getElementById('date').value = date;
            document.getElementById('workDay').value = workDay;
            document.getElementById('workDayName').value = workDayName;
            document.getElementById('checkin').value = checkin;
            document.getElementById('checkout').value = checkout;

            // Set form action dynamically
            const form = document.getElementById('editPresenceForm');
            if (form) form.action = `{{ url('presences') }}/save`; 
            const presenceIdInput = document.getElementById('presenceId');
            if (presenceIdInput) presenceIdInput.value = id;    

            // Setup workDays dropdown for edit modal
            setupEmployeeWorkDays('employeeSelectEdit', 'workDaySelectEdit', 'workDayContainerEdit', @json($workDays));
        });
    }

    // ===== Modal Add =====
    setupEmployeeWorkDays('employeeSelect', 'workDaySelect', 'workDayContainer', @json($workDays));

    // Fungsi untuk update hidden input form export
    function syncExportFormWithURL() {
        const params = new URLSearchParams(window.location.search);
        const startDate = params.get('start_date') || '';
        const endDate = params.get('end_date') || '';

        document.getElementById('exportStart').value = startDate;
        document.getElementById('exportEnd').value = endDate;
    }

    // Jalankan saat halaman pertama kali dimuat
    syncExportFormWithURL();

    // Jalankan setiap kali date range picker diubah
    const observer = new MutationObserver(syncExportFormWithURL);
    observer.observe(document.querySelector('#dateRangeInput'), { attributes: true, attributeFilter: ['value'] });

});


function confirmDelete(id, name, entity) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to delete the " + entity + ": " + name,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '',
            cancelButtonColor: '',
            cancelButtonText: 'Cancel',
            confirmButtonText: 'Yes, delete it!',
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
@include('presence.photoAndMap')