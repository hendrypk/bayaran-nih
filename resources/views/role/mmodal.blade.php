{{-- <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{ $modal_title }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body p-x">
            <form id="form_modal_role" class="form-validate" action="{{$action }}" method="POST">
                @if(!empty($role))
                    <input type="hidden" name="role_id" value="{{ $role->id }}">
                @endif
                <div class="mb-3">
                    <label class="form-label fw-bold">Role Name</label>
                    <input type="text" placeholder="Enter a role name" name="name" class="form-control" value="{{ !empty($role)?$role->name:'' }}">
                </div>

                <div class="row">
                    <label class="fs-6 fw-bold form-label">Role Permission</label>
                    <div class="table-responsive">
                        <table class="table align-middle table-border-dashed fs-6">
                            <tbody class="text-muted fw-semibold">
                            <tr>
                                <td class="text-muted">Root Access
                                    <i class="ph-info" data-bs-popup="tooltip" data-bs-placement="auto" data-bs-original-title="Allows full access"></i>
                                </td>
                                <td class="row">
                                    <label class="col-12 form-check">
                                        <input type="checkbox" class="form-check-input" value="" id="ilz_role_select_all">
                                        <span class="form-check-label">Select All</span>
                                    </label>
                                </td>
                            </tr>
                            @php
                            if ($permissions){
                                $groupName = '';
                                $n = 0;
                                $i = 0;
                                foreach ($permissions as $permission){
                                    $n++;
                                    $mt = '';
                                    if ($groupName != $permission->group_name){
                                        $groupName = $permission->group_name;
                                        echo '<tr>
                                                <td class="text-muted">'.$groupName.'</td>
                                                <td>';
                                    } else {
                                        $mt = 'mt-6';
                                    }
                                    if($n <= 1){
                                        echo '<div class="d-flex '.$mt.' row">';
                                    }
                                    echo '<label class="form-check col-lg-3 col-md-6">
                                        <input type="checkbox" class="form-check-input" value="'.$permission->id.'" name="permissions[]" '.(!empty($role) && in_array($permission->name, $role->permissions->pluck('name')->all())?"checked":"").'/>
                                        <span class="form-check-label" data-bs-toggle="tooltip" title="'.$permission->name.'">'.ucfirst(explode(' ', $permission->name)[0]).'</span>
                                    </label>';

                                    if ($n >= 4 || !isset($permissions[$i+1]) || $groupName != $permissions[$i+1]->group_name){
                                        $n=0;
                                        echo '</div>';
                                    }
                                    if ( !isset($permissions[$i+1]) || $groupName != $permissions[$i+1]->group_name){
                                        echo '</td></tr>';
                                    }
                                    $i++;
                                }
                            }
                            @endphp
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
            <button type="submit" form="form_modal_role" class="btn btn-primary">Save</button>
        </div>
    </div>
</div> --}}