@extends('_layout.main')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">{{ $role->name }} Detail</h5>
            <div>
                <a href="{{ route('role.edit', $role->id) }}" class="btn btn-tosca">
                    <i class="ri-edit-box-fill"></i>
                </a>
                <button type="button" class="btn btn-untosca" 
                    onclick="confirmDelete({{ $role->id }}, '{{ $role->name }}', 'role')">
                    <i class="ri-delete-bin-fill"></i>
                </button>
            </div>
        </div>
        
        <div class="card-body">
            <form id="" action="" method="POST">
                @csrf
                @method('PUT')

                <!-- Role Name Input -->
                {{-- <div class="mb-3">
                    <label class="form-label fw-bold">Role Name</label>
                    <input disabled type="text" name="name" class="form-control" value="{{ $role->name }}" required>
                </div> --}}

                <!-- Permissions Table -->
                <div class="mb-3">
                    {{-- <label class="fs-6 fw-bold form-label">Role Permissions</label> --}}
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td>Root Access</td>
                                    <td>
                                        <input disabled class="form-check-input" type="checkbox" id="select_all_permissions">
                                        <label class="form-check-label" for="select_all_permissions">Select All</label>
                                    </td>
                                </tr>

                                @foreach($groupedPermissions as $group => $permissions)
                                    <tr>
                                        <td class="fw-bold text-muted">{{ ucfirst($group) }}</td>
                                        <td>
                                            <div class="row">
                                                @foreach($permissions as $permission)
                                                    <div class="col-lg-3 col-md-4">
                                                        <label class="form-check-label">
                                                            <input disabled type="checkbox" class="form-check-input" name="permissions[]" value="{{ $permission->id }}"
                                                                {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                            {{ ucfirst(explode(' ', $permission->name)[0]) }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <a href="{{ route('role.index') }}" class="btn btn-tosca">Back</a>
            </form>
        </div>
    </div>
</div>

<script>
    // JavaScript for Select/Deselect All Permissions
    document.getElementById('select_all_permissions').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
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
