<!-- Edit Position -->
<div class="modal fade" id="positionEditModal" tabindex="-1" aria-labelledby="positionEditModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="positionEditModalLabel">{{ __('option.label.edit_position') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="edit-form" method="POST" action="" data-update-type="position">
          @csrf
          @method('POST')
          <input type="hidden" name="id" id="id">
          <div class="mb-3">
            <label for="inputPositionName" class="form-label">{{ __('general.label.name') }}</label>
            <input type="text" class="input-form" name="name" id="inputPositionName">

          <label for="jobTitleSection" class="form-label mt-2">{{ __('option.label.job_title') }}</label>
          <select class="select-form" name="job_title_id" aria-label="Default select example">
              <option selected disabled>{{ __('employee.placeholders.select_job_title') }}</option>
              @foreach($job_titles as $data)
                  <option value="{{ $data->id }}">{{ $data->name }}</option>
              @endforeach
          </select>

          <label for="jobTitleSection" class="form-label mt-2">{{ __('option.label.department') }}</label>
          <select class="select-form" name="department_id" aria-label="Default select example">
              <option selected value="">{{ __('employee.placeholders.select_department') }}</option>
              @foreach($departments as $data)
                  <option value="{{ $data->id }}">{{ $data->name }}</option>
              @endforeach
          </select>

          <label for="jobTitleSection" class="form-label mt-2">{{ __('option.label.division') }}</label>
          <select class="select-form" name="division_id" aria-label="Default select example">
              <option selected value="">{{ __('employee.placeholders.select_division') }}</option>
              @foreach($divisions as $data)
                  <option value="{{ $data->id }}">{{ $data->name }}</option>
              @endforeach
          </select>

        </div>
          <div class="d-flex justify-content-end mt-2">
            <button type="button" class="btn btn-red me-3" data-bs-dismiss="modal">{{ __('general.label.cancel') }}</button>
            <button type="submit" name="action" class="btn btn-tosca">{{ __('general.label.save') }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Edit Job Title Modal -->
<div class="modal fade" id="jobTitleEditModal" tabindex="-1" aria-labelledby="jobTitleEditModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="jobTitleEditModalLabel">{{ __('option.label.edit_job_title') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="edit-form" method="POST" action="" data-update-type="jobTitle">
          @csrf
          @method('POST')
          <div class="mb-3">
            <label for="inputJobTitleName" class="form-label">{{ __('general.label.name') }}</label>
            <input type="text" class="input-form" name="name" id="inputJobTitleName">
          </div>
          <div class="mb-3">
            <label for="inputJobTitleSection" class="form-label">{{ __('option.label.section') }}</label>
            <input type="text" class="input-form" name="section" id="inputJobTitleSection">
          </div>
          <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-red me-3" data-bs-dismiss="modal">{{ __('general.label.cancel') }}</button>
            <button type="submit" name="action" class="btn btn-tosca">{{ __('general.label.save') }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Edit Department Modal -->
<div class="modal fade" id="departmentEditModal" tabindex="-1" aria-labelledby="departmentEditModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="departmentEditModalLabel">{{ __('option.label.edit_department') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="edit-form" method="POST" action="" data-update-type="department">
          @csrf
          @method('POST')
          <div class="mb-3">
            <label for="inputDepartmentName" class="form-label">{{ __('general.label.name') }}</label>
            <input type="text" class="input-form" name="name" id="inputDepartmentName">
          </div>
          <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-red me-3" data-bs-dismiss="modal">{{ __('general.label.cancel') }}</button>
            <button type="submit" name="action" class="btn btn-tosca">{{ __('general.label.save') }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Edit Division Modal -->
<div class="modal fade" id="divisionEditModal" tabindex="-1" aria-labelledby="divisionEditModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="divisionEditModalLabel">Edit Division</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="edit-form" method="POST" action="" data-update-type="division">
          @csrf
          @method('POST')
          <div class="mb-3">
            <label for="inputDivisionName" class="form-label">{{ __('general.label.name') }}</label>
            <input type="text" class="input-form" name="name" id="inputDivisionName">
          </div>
          <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-red me-3" data-bs-dismiss="modal">{{ __('general.label.cancel') }}</button>
            <button type="submit" name="action" class="btn btn-tosca">{{ __('general.label.save') }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Edit Status Modal -->
<div class="modal fade" id="holidayEditModal" tabindex="-1" aria-labelledby="holidayEditModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="holidayEditModalLabel">{{ __('option.label.edit_holiday') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="edit-form" method="POST" action="" data-update-type="holiday">
          @csrf
          @method('POST')
          <div class="mb-3">
            <label for="inputHolidayName" class="form-label">{{ __('general.label.name') }}</label>
            <input type="text" class="input-form" name="name" id="inputHolidayName">
          </div>
          <div class="mb-3">
            <label class="col-sm-3 col-form-label">{{ __('general.label.date') }}</label>
            <input type="date" name="date" class="input-form">
          </div>
          <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-red me-3" data-bs-dismiss="modal">{{ __('general.label.cancel') }}</button>
            <button type="submit" name="action" class="btn btn-tosca">{{ __('general.label.save') }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Edit Holiday Modal -->
<div class="modal fade" id="statusEditModal" tabindex="-1" aria-labelledby="statusEditModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="statusEditModalLabel">{{ __('option.label.edit_status') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="edit-form" method="POST" action="" data-update-type="status">
          @csrf
          @method('POST')
          <div class="mb-3">
            <label for="inputStatusName" class="form-label">{{ __('general.label.name') }}</label>
            <input type="text" class="input-form" name="name" id="inputStatusName">
          </div>
          <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-red me-3" data-bs-dismiss="modal">{{ __('general.label.cancel') }}</button>
            <button type="submit" name="action" class="btn btn-tosca">{{ __('general.label.save') }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Edit Modal Office Location -->
<div class="modal fade" id="locationEditModal" tabindex="-1" aria-labelledby="modalLocation" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="">{{ __('option.label.edit_location') }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <form action="" class="edit-form" method="POST" data-update-type="location">
                  @csrf   
                  <div class="mb-3">
                      <label for="inputName" class="form-label">{{ __('general.label.name') }}</label>
                      <input type="text" class="input-form" name="name" required>
                  </div>   

                  <!-- Hidden inputs for latitude and longitude -->
                  <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', isset($data) ? $data->latitude : '') }}" required>
                  <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', isset($data) ? $data->longitude : '') }}" required>
                  

                  <!-- Map container -->
                  <div class="mb-3">
                      <label for="map" class="form-label">{{ __('option.label.location') }}</label>
                      <div class="mb-3" id="map" style="height: 300px;"></div> 
                  </div> 

                  <div class="mb-3">
                      <label for="radius" class="form-label">{{ __('general.label.radius') }}</label>
                      <input type="number" class="input-form" name="radius" requried>
                  </div>
                  <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-tosca me-3" data-bs-dismiss="modal">{{ __('general.label.cancel') }}</button>
                    <button type="submit" name="action" class="btn btn-untosca me-3">{{ __('general.label.save') }}</button>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>


