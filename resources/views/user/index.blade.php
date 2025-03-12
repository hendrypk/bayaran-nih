@extends('_layout.main')
@section('title', __('sidebar.label.user') )
@section('content')

{{ Breadcrumbs::render('user') }}

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="card-header d-flex align-items-center py-0">
                    <h5 class="card-title mb-0 py-3">{{ __('option.label.user') }}</h5>
                    @can('create user')
                        <div class="ms-auto my-auto">
                            <button type="button" class="btn btn-tosca" onclick="openUserModal('add')">{{ __('option.label.add_user') }}</button>
                        </div>
                    @endcan
                </div>
        
                <table class="table datatable table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ __('general.label.name') }}</th>
                            <th scope="col">{{ __('option.label.username') }}</th>
                            <th scope="col">{{ __('option.label.email') }}</th>
                            <th scope="col">{{ __('option.label.role') }}</th>
                            <th scope="col">{{ __('general.label.edit') }}</th>
                            <th scope="col">{{ __('general.label.delete') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach($users as $no=>$user)
                            <tr>
                                <th scope="row">{{ $no+1 }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                @foreach ($user->roles as $role)
                                    <td>{{ $role->name ?? '-' }}</td>
                                @endforeach
                                @csrf
                                 <td>
                                    @can('update user')
                                        <button type="button"
                                            class="btn btn-green" onclick="openUserModal('edit', {
                                                id: '{{ $user->id }}',
                                                name: '{{ $user->name }}',
                                                username: '{{ $user->username }}',
                                                email: '{{ $user->email }}',
                                                role_id: '{{ $user->roles->first()->id ?? '' }}',
                                                division: '{{ $user->division_id }}',
                                                department: '{{ $user->department_id }}'
                                            })">
                                            <i class="ri-edit-box-fill"></i>
                                        </button>
                                    @endcan
                                </td>
                                <td>
                                    @can('delete user')
                                        <button type="button" class="btn btn-red" 
                                            onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}', 'user')">
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
function openUserModal(action, data = {}) {
    if (action === 'add') {
        $('#userForm').attr('action', "{{ route('user.store') }}");
        $('#userModalTitle').text('{{ __('option.label.add_user') }}');
        $('#inputName').val('');
        $('#selectRole').val('');
        $('#division').val('');
        $('#department').val('');
    } else if (action === 'edit') {
        $('#userForm').attr('action', "{{ route('user.update', ['id' => '__id__']) }}".replace('__id__', data.id));
        $('#userModalTitle').text('{{ __('option.label.edit_user') }}');
        $('#inputName').val(data.name);
        $('#username').val(data.username);
        $('#email').val(data.email);
        $('#selectRole').val(data.role_id);
        $('#division').val(data.division);
        $('#department').val(data.department);
    }

    $('#userModal').modal('show');
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
@include('user.modal')