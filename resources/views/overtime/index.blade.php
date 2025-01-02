@extends('_layout.main')
@section('title', 'Overtime')
@section('content')


{{ Breadcrumbs::render('overtime') }}
<div class="row align-items-center">
    <div class="col-md-9">
        <x-date-filter action="{{ route('overtime.list') }}" 
                        :startDate="request()->get('start_date')" 
                        :endDate="request()->get('end_date')" />
    </div>
    <div class="col-md-3 d-flex justify-content-end">
        <form action="{{ route('overtime.export') }}" method="POST" class="me-2" style="margin: 0;">
            @csrf
            <input type="hidden" name="start_date" value="{{ request()->get('start_date') }}">
            <button type="submit" class="btn btn-tosca btn-sm">
                <i class="ri-download-cloud-2-fill"></i>
            </button>
        </form>
        <button type="button" class="btn btn-untosca btn-sm"
                data-bs-toggle="modal" 
                data-bs-target="#addOvertime">
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
                        <h5 class="card-title mb-0 py-3">Overtime List</h5>
                    </div>
                    {{-- <div class="col-md-1">
                        <form action="{{ route('overtime.export') }}" method="POST">
                            @csrf
                            <input type="hidden" name="start_date" value="{{ request()->get('start_date') }}">
                            <input type="hidden" name="end_date" value="{{ request()->get('end_date') }}">
                            <button type="submit" class="btn btn-tosca"><i class="ri-download-cloud-2-fill"></i></button>
                        </form>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-untosca"
                        data-bs-toggle="modal" 
                        data-bs-target="#addOvertime">
                        <i class="ri-add-circle-line"></i>
                        </button>
                    </div> --}}
                </div>
        
                <!-- Table with hoverable rows -->
                    <table class="table datatable table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">EID</th>
                                <th scope="col">Employee Name</th>
                                <th scope="col">Date</th>
                                <th scope="col">Start at</th>
                                <th scope="col">End at</th>
                                <th scope="col">Total</th>
                                <th scope="col">Status</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($overtimes as $no=>$overtime)
                            <tr>
                                <th scope="row">{{ $no+1 }}</th>
                                <td>{{ $overtime->employees->eid }}</td>
                                <td>{{ $overtime->employees->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($overtime->date)->format('d F Y') }}</td>
                                <td>{{ $overtime->start_at }}</td>
                                <td>{{ $overtime->end_at }}</td>
                                <td> {{ $overtime->total }} <span>minutes</span></td>
                                <td>
                                    @if ($overtime->status === 1)
                                        <i class="status-leave accept ri-check-double-fill"></i>
                                    @else
                                        <i class="status-leave reject ri-close-fill"></i>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-outline-success"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#overtimeEdit" 
                                        data-id="{{ $overtime->id }}" 
                                        data-name="{{ $overtime->employees->name }}"
                                        data-employee_id="{{ $overtime->employee_id }}"
                                        data-date="{{ $overtime->date }}"
                                        data-start="{{ $overtime->start_at }}"
                                        data-end="{{ $overtime->end_at }}">
                                        <i class="ri-edit-line"></i>
                                    </button>
                                </td>
                                    <td>
                                        {{-- <button type="button" class="btn btn-outline-danger"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal" 
                                            data-entity="overtime" 
                                            data-id="{{ $overtime->id }}" 
                                            data-name="{{ $overtime->employee_id }}"
                                            data-date="{{ \Carbon\Carbon::parse($overtime->date)->format('d F Y') }}">
                                            <i class="ri-delete-bin-fill"></i>
                                        </button> --}}

                                        <button type="button" class="btn btn-outline-danger" 
                                            onclick="confirmDelete({{ $overtime->id }}, '{{ $overtime->employees->name }}', 'overtimes')">
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
</div>

@endsection
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
      const date = button.getAttribute('data-date'); // Entity date (optional)
      
      // Update modal title and body text
      const entityNameElement = document.getElementById('entityName');
      entityNameElement.textContent = entity;
      
      // Update form action URL
      const form = document.getElementById('deleteForm');
      form.action = `/${entity}/${id}/delete`;

      // Optionally update the modal title to include the entity's name
      const modalTitle = document.getElementById('deleteModalLabel');
      modalTitle.textContent = `Delete ${entity.charAt(0).toUpperCase() + entity.slice(1)}: ${name} on ${date}`;
    });
  });

  document.addEventListener('DOMContentLoaded', function () {
    const editModal = document.getElementById('overtimeEdit');
    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // Button that triggered the modal
        const id = button.getAttribute('data-id');
        const employee_id = button.getAttribute('data-employee_id');
        const name = button.getAttribute('data-name');
        const date = button.getAttribute('data-date');
        const start = button.getAttribute('data-start');
        const end = button.getAttribute('data-end');

        console.log('id', id);
        // Set the form action URL
        const form = document.getElementById('editOvertimeForm');
        let actionUrl = form.getAttribute('action');
        form.setAttribute('action', actionUrl.replace('__id__', id));
        console.log(actionUrl)

        // Populate the form fields
        document.getElementById('selectEmployee').value = employee_id;
        document.getElementById('inputDate').value = date;
        document.getElementById('inputStart').value = start;
        document.getElementById('inputEnd').value = end;

        // Update modal title
        const modalTitle = document.getElementById('modalEditOvertimeTitle');
        modalTitle.textContent = `Edit Overtime for ${name}`;
    });
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

@include('overtime.add')
@include('overtime.edit')
@include('modal.delete')