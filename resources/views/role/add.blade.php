@extends('_layout.main')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">{{ __('option.label.add_new_role') }}</h5>
        </div>
        <div class="card-body"><form id="form_role_edit" action="{{ isset($role) ? route('role.update', $role->id) : route('role.store') }}" method="POST">
            @csrf
            @if(isset($role))
                @method('PUT') <!-- Use PUT for updates -->
            @endif
        
            <!-- Role Name Input -->
            <div class="mb-3">
                <label class="form-label fw-bold">{{ __('option.label.role_name') }}</label>
                <input type="text" name="name" class="input-form" value="{{ $role->name ?? '' }}" required>
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
                                    <label for="select_all_permissions">{{__('general.label.select_all') }}</label>
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