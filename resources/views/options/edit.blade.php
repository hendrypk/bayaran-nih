<!-- Edit Position -->
<div class="modal fade" id="positionEditModal" tabindex="-1" aria-labelledby="positionEditModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="positionEditModalLabel">Edit Department</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="edit-form" method="POST" action="" data-update-type="position">
          @csrf
          @method('POST')
          <div class="mb-3">
            <label for="inputPositionName" class="form-label">Position Name</label>
            <input type="text" class="form-control" name="name" id="inputPositionName">
          </div>
          <button type="submit" class="btn btn-tosca">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Edit Job Title Modal -->
<div class="modal fade" id="jobTitleEditModal" tabindex="-1" aria-labelledby="jobTitleEditModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="jobTitleEditModalLabel">Edit Job Title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="edit-form" method="POST" action="" data-update-type="jobTitle">
          @csrf
          @method('POST')
          <div class="mb-3">
            <label for="inputJobTitleName" class="form-label">Job Title Name</label>
            <input type="text" class="form-control" name="name" id="inputJobTitleName">
          </div>
          <div class="mb-3">
            <label for="inputJobTitleSection" class="form-label">Section</label>
            <input type="text" class="form-control" name="section" id="inputJobTitleSection">
          </div>
          <button type="submit" class="btn btn-tosca">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Edit Department Modal -->
<div class="modal fade" id="departmentEditModal" tabindex="-1" aria-labelledby="departmentEditModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="departmentEditModalLabel">Edit Department</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="edit-form" method="POST" action="" data-update-type="department">
          @csrf
          @method('POST')
          <div class="mb-3">
            <label for="inputDepartmentName" class="form-label">Department Name</label>
            <input type="text" class="form-control" name="name" id="inputDepartmentName">
          </div>
          <button type="submit" class="btn btn-tosca">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Edit Division Modal -->
<div class="modal fade" id="divisionEditModal" tabindex="-1" aria-labelledby="divisionEditModalLabel" aria-hidden="true">
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
            <label for="inputDivisionName" class="form-label">Division Name</label>
            <input type="text" class="form-control" name="name" id="inputDivisionName">
          </div>
          <button type="submit" class="btn btn-tosca">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Edit Status Modal -->
<div class="modal fade" id="statusEditModal" tabindex="-1" aria-labelledby="statusEditModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="statusEditModalLabel">Edit Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="edit-form" method="POST" action="" data-update-type="status">
          @csrf
          @method('POST')
          <div class="mb-3">
            <label for="inputStatusName" class="form-label">Status Name</label>
            <input type="text" class="form-control" name="name" id="inputStatusName">
          </div>
          <button type="submit" class="btn btn-tosca">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Edit Modal Office Location -->
<div class="modal fade" id="locationEditModal" tabindex="-1" aria-labelledby="modalLocation" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="">Edit Location</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <form action="" class="edit-form" method="POST" data-update-type="location">
                  @csrf   
                  <div class="mb-3">
                      <label for="inputName" class="form-label">Name</label>
                      <input type="text" class="form-control" name="name" required>
                  </div>   

                  <!-- Hidden inputs for latitude and longitude -->
                  <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', isset($data) ? $data->latitude : '') }}" required>
                  <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', isset($data) ? $data->longitude : '') }}" required>
                  

                  <!-- Map container -->
                  <div class="mb-3">
                      <label for="map" class="form-label">Location</label>
                      <div class="mb-3" id="map" style="height: 300px;"></div> 
                  </div> 

                  <div class="mb-3">
                      <label for="radius" class="form-label">Radius</label>
                      <input type="number" class="form-control" name="radius" requried>
                  </div>
                  <button type="submit" class="btn btn-tosca">Submit</button>
              </form>
          </div>
      </div>
  </div>
</div>


