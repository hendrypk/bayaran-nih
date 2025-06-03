    @extends('_layout.main')
    @section('content')
    {{ Breadcrumbs::render('role_detail', $role->id) }}
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">{{ __('option.label.detail_role') }} {{ $role->name }}</h5>
            </div>
            <div class="card-body">
                <form id="form_role_edit" action="{{ route('role.update', $role->id) }}" method="POST">
                    @csrf
                    @method('POST')

                    <!-- Role Name Input -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('option.label.role_name') }}</label>
                        <input type="text" name="name" class="input-form" value="{{ $role->name }}" required>
                    </div>

                    <!-- Permissions Table -->
                    <div class="mb-3">
                        <label class="fs-6 fw-bold form-label">{{ __('option.label.role_permissions') }}</label>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td>Root Access</td>
                                        <td>
                                            <input type="checkbox" class="form-check-input" id="select_all_permissions">
                                            <label for="select_all_permissions">{{ __('general.label.select_all') }}</label>
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
                                                                <input type="checkbox" class="form-check-input" name="permissions[]" value="{{ $permission->id }}"
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
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('role.index') }}" class="btn btn-red me-3">{{ __('general.label.back') }}</a>
                        <button type="submit" name="action" class="btn btn-tosca">{{ __('general.label.save') }}</button>
                    </div>
                    
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
    </script>
    @endsection

{{-- <!-- Modal -->
<div class="modal fade" id="roleModal" tabindex="-1" aria-labelledby="roleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="roleModalLabel">{{ $modal_title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_role_edit" action="{{ $action }}" method="POST">
                @csrf
                @method(isset($role) ? 'PUT' : 'POST') <!-- Use PUT for updates -->
                <input type="hidden" name="role_id" value="{{ $role->id ?? '' }}">
                
                <!-- Role Name Input -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Role Name</label>
                    <input type="text" name="name" class="input-form" value="{{ $role->name ?? '' }}" required>
                </div>

                <!-- Permissions Table -->
                <div class="mb-3">
                    <label class="fs-6 fw-bold form-label">Role Permissions</label>
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td>Root Access</td>
                                    <td>
                                        <input type="checkbox" id="select_all_permissions">
                                        <label for="select_all_permissions">Select All</label>
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
                                                            <input type="checkbox" class="form-check-input" name="permissions[]" value="{{ $permission->id }}"
                                                                {{ isset($role) && $role->permissions->contains($permission->id) ? 'checked' : '' }}>
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

                <button type="submit" class="btn btn-untosca">Save Changes</button>
                <a href="{{ route('role.index') }}" class="btn btn-tosca">Cancel</a>
            </form>
        </div>
    </div>
</div> --}}
