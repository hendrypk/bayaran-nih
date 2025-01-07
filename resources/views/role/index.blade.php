@extends('_layout.main')
@section('title', 'Options')
@section('content')

{{ Breadcrumbs::render('role') }}

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="card-header d-flex align-items-center py-0">
                    <h5 class="card-title mb-0 py-3">{{ __('option.label.role') }}</h5>
                    <div class="ms-auto my-auto">
                        @can('create role')
                            <a href="{{ route('role.create') }}" class="btn btn-untosca"> {{ __('option.label.add_role') }}</a>
                        @endcan
                    </div>
                </div>
        
                <table class="table datatable table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ __('general.label.name') }}</th>
                            <th scope="col">{{ __('general.label.detail') }}</th>
                            <th scope="col">{{ __('general.label.delete') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $no=>$role)
                        <tr>
                            <th scope="row">{{ $no+1 }}</th>
                            <td>{{ $role->name }}</td>
                            @csrf
                            {{-- <td>
                                <a href="{{ route('role.detail', $role->id) }}"
                                    class="btn btn-outline-primary">
                                    <i class="ri-eye-fill"></i>
                                </a>
                            </td> --}}
                             <td>
                                @can('update role')
                                    <a href="{{ route('role.edit', $role->id) }}"
                                        class="btn btn-tosca">
                                        <i class="ri-edit-box-fill"></i>
                                    </a>
                                @endcan
                            </td>
                            <td>
                                @can('delete role')
                                    <button type="button" class="btn btn-untosca" 
                                        onclick="confirmDelete({{ $role->id }}, '{{ $role->name }}', 'role')">
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
