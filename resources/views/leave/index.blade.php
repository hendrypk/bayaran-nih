@extends('_layout.main')
@section('title', 'Leave')
@section('content')

<div class="row">
{{-- <x-date-filter action="{{ route('overtime.list') }}" 
                    :startDate="request()->get('start_date')" 
                    :endDate="request()->get('end_date')" /> --}}

    <div class="col-md">
        <div class="card">
            <div class="card-body">
                <div class="card-header d-flex align-items-center py-0">
                    <div class="col-md-10">
                        <h5 class="card-title mb-0 py-3">Leave List</h5>
                    </div>
                    @can('create leave')
                        <div class="col-md-2">
                            <button type="button" class="btn btn-untosca"
                            data-bs-toggle="modal" 
                            data-bs-target="#addLeave">
                            Add Manual Leave
                            </button>
                        </div>
                    @endcan
                </div>
                    <table class="table datatable table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">EID</th>
                                <th scope="col">Employee Name</th>
                                <th scope="col">Apply Date</th>
                                <th scope="col">Date</th>
                                <th scope="col">Category</th>
                                <th scope="col">Note</th>
                                <th scope="col">Status</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($leaves as $no=>$leave)
                            <tr>
                                <th scope="row">{{ $no+1 }}</th>
                                <td>{{ $leave->employees->eid }}</td>
                                <td>{{ $leave->employees->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($leave->created_at)->format('d F Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($leave->date)->format('d F Y') }}</td>
                                <td>{{ $leave->category }}</td>
                                <td>{{ $leave->note }}</td>
                                <td>
                                    @if ($leave->status === 0)
                                    <i class="status-leave wait ri-rest-time-line"></i>
                                    @elseif ($leave->status === 1)
                                        <i class="status-leave accept ri-check-double-fill"></i>
                                    @elseif ($leave->status === 2)
                                    <i class="status-leave reject ri-close-fill"></i>
                                    @endif
                                </td>
                                <td>
                                    @can('update leave')
                                        <button type="button" class="btn btn-outline-success"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#overtimeEdit" 
                                            data-id="{{ $leave->id }}" 
                                            data-name="{{ $leave->employees->name }}"
                                            data-employee_id="{{ $leave->employee_id }}"
                                            data-date="{{ $leave->date }}"
                                            data-start="{{ $leave->start_date }}"
                                            data-end="{{ $leave->end_date }}"
                                            data-category="{{ $leave->category }}"
                                            data-note="{{ $leave->note }}">
                                            <i class="ri-edit-line"></i>
                                        </button>
                                    @endcan                                
                                </td>
                                <td>
                                    @can('delete leave')
                                        <button type="button" class="btn btn-outline-danger" 
                                            onclick="confirmDelete({{ $leave->id }}, '{{ $leave->employees->name }}', 'leave')">
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

@endsection
@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const editModal = document.getElementById('overtimeEdit');
    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // Button that triggered the modal
        const id = button.getAttribute('data-id');
        const employee_id = button.getAttribute('data-employee_id');
        const name = button.getAttribute('data-name');
        const date = button.getAttribute('data-date');
        // const start = button.getAttribute('data-start');
        // const end = button.getAttribute('data-end');
        const category = button.getAttribute('data-category');
        const note = button.getAttribute('data-note');

        console.log('date', date)
        
        // Populate the form fields
        document.getElementById('id').value = id;
        document.getElementById('selectEmployee').value = employee_id;
        document.getElementById('leave-date').value = date;
        // document.getElementById('inputStart').value = start;
        // document.getElementById('inputEnd').value = end;
        document.getElementById('selectCategory').value = category;
        document.getElementById('inputNote').value = note;

        // Update modal title
        const modalTitle = document.getElementById('modalTitle');
        modalTitle.textContent = `Edit Leave for ${name}`;
    });
});

function updateAction(id, name, entity, currentStatus) {
    const status = currentStatus == 1 ? 0 : 1; // Switch status: if current is 1, set to 0; otherwise, set to 1

    Swal.fire({
        title: status === 1 ? 'Are you sure to accept?' : 'Are you sure to reject?',
        text: `You are about to ${status === 1 ? 'accept' : 'reject'} the ${entity} for ${name}.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '',
        cancelButtonColor: '',
        confirmButtonText: status === 1 ? 'Yes, accept it!' : 'Yes, reject it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/leave/submit`, { // Adjust the URL if necessary
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Ensure CSRF token is rendered
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id, status }) // Send ID and new status in the request body
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
                        title: 'Updated!',
                        text: data.message,
                        icon: 'success'
                    }).then(() => {
                        location.reload(); // Reload the page or redirect as needed
                    });
                } else {
                    Swal.fire('Error!', data.message || 'Something went wrong. Try again later.', 'error');
                }
            })
            .catch(error => {
                Swal.fire('Error!', 'Failed to update. Please try again.', 'error');
                console.error('There was a problem with the fetch operation:', error);
            });
        }
    });
}



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

@include('leave.add')
@include('leave.edit')
@include('leave.update_status')
@include('modal.delete')