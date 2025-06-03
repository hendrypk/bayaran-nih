<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="userForm" action="" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">{{ __('general.label.name') }}</label>
                        <div class="col-sm-8">
                            <input type="text" id="inputName" name="name" class="input-form" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">{{ __('option.label.username') }}</label>
                        <div class="col-sm-8">
                            <input type="text" id="username" name="username" class="input-form" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">{{ __('option.label.email') }}</label>
                        <div class="col-sm-8">
                            <input type="email" id="email" name="email" class="input-form" required>
                        </div>
                    </div>   

                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">{{ __('option.label.password') }}</label>
                        <div class="col-sm-8">
                            <input type="text" id="password" name="password" class="input-form">
                        </div>
                    </div>   

                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">{{ __('option.label.role') }}</label>
                        <div class="col-sm-8">
                            <select class="select-form" name="role_id" id="selectRole" aria-label="Default select example" required>
                                <option selected>{{ __('option.label.select_role') }}</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>   

                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">{{ __('employee.label.division') }}</label>
                        <div class="col-sm-8">
                            <select class="select-form" name="division" id="division" aria-label="Default select example">
                                <option value="" selected>{{ __('employee.placeholders.select_division') }}</option>
                                @foreach($divisions as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">{{ __('employee.label.department') }}</label>
                        <div class="col-sm-8">
                            <select class="select-form" name="department" id="department" aria-label="Default select example">
                                <option value="" selected>{{ __('employee.placeholders.select_department') }}</option>
                                @foreach($departments as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-red me-3" data-bs-dismiss="modal">{{ __('general.label.cancel') }}</button>
                        <button type="submit" name="action" class="btn btn-tosca me-3">{{ __('general.label.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
