@extends('_layout.main')
@section('title', 'Leave')
@section('content')

{{ Breadcrumbs::render('leave') }}
<div class="row align-items-center">
    <div class="col-md-9">
        <x-date-filter action="{{ route('leave.index') }}" 
                        :startDate="request()->get('start_date')" 
                        :endDate="request()->get('end_date')" />
    </div>
    <div class="col-md-3 d-flex justify-content-end">
        @can('create leave')
        <button type="button" class="btn btn-untosca btn-sm"
                data-bs-toggle="modal" 
                data-bs-target="#addLeave">
            <i class="ri-add-circle-line"></i>
        </button>
        @endcan
    </div>
</div>

<div class="row">
    <div class="col-md">
        <div class="card">
            <div class="card-body">
                <div class="card-header d-flex align-items-center py-0">
                    <div class="col-md-10">
                        <h5 class="card-title mb-0 py-3">Leave List</h5>
                    </div>
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
                                            onclick="confirmDelete({{ $leave->id }}, '{{ $leave->employees->name }}', 'leaves')">
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
        const button = event.relatedTarget; 
        const id = button.getAttribute('data-id');
        const employee_id = button.getAttribute('data-employee_id');
        const name = button.getAttribute('data-name');
        const date = button.getAttribute('data-date');
        const category = button.getAttribute('data-category');
        const note = button.getAttribute('data-note');

        // Populate the form fields
        document.getElementById('id').value = id;
        document.getElementById('selectEmployee').value = employee_id;
        document.getElementById('leave-date').value = date;
        document.getElementById('selectCategory').value = category;
        document.getElementById('inputNote').value = note;

        // Update modal title
        const modalTitle = document.getElementById('modalTitle');
        modalTitle.textContent = `Edit Leave for ${name}`;
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
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' 
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
                            text: data.message, 
                            icon: 'success'
                        }).then(() => {
                            window.location.href = data.redirect;
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