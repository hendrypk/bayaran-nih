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

<!-- Edit Sales Person Modal -->
<!-- <div class="modal fade" id="salesPersonEditModal" tabindex="-1" aria-labelledby="salesPersonEditModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="salesPersonEditModalLabel">Edit Sales Person</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="edit-form" method="POST" action="" data-update-type="salesPerson">
          @csrf
          @method('POST')
          <div class="mb-3">
            <label for="inputSalesPersonName" class="form-label">Sales Name</label>
            <input type="text" class="form-control" name="name" id="inputSalesPersonName">
          </div>
          <button type="submit" class="btn btn-tosca">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div> -->

<!-- Edit Work Schedule Modal -->
<div class="modal fade" id="scheduleEditModal" tabindex="-1" aria-labelledby="scheduleEditModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="scheduleEditModalLabel">Edit Schedule</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="edit-form" method="POST" action="" data-update-type="schedule">
          @csrf
          @method('POST')
          <div class="mb-3">
            <label for="inputScheduleName" class="form-label">Schedule Name</label>
            <input type="text" class="form-control" name="name" id="inputScheduleName">
          </div>
          <div class="mb-3">
            <label for="inputArrival" class="form-label">Arrival</label>
            <input type="time" class="form-control" name="arrival" id="inputArrival" >
          </div>  
          <div class="mb-3">
            <label for="inputStart" class="form-label">Start at</label>
            <input type="time" class="form-control" name="start" id="inputStart" >
          </div>
          <div class="mb-3">
            <label for="inputEnd" class="form-label">End at</label>
            <input type="time" class="form-control" name="end" id="inputEnd">
          </div>
          <button type="submit" class="btn btn-tosca">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Edit Calendar Modal -->
<div class="modal fade" id="calendarEditModal" tabindex="-1" aria-labelledby="calendarEditModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="calendarEditModalLabel">Edit On-Day</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="edit-form" method="POST" action="" data-update-type="calendar">
          @csrf
          @method('POST')
          <div class="row g-3">
            <div class="col md-4">
              <label for="inputName" class="form-label">Name</label>
              <input type="text" class="form-control" name="name" id="inputName">
          </div>

          <div class="row g-3">
            <div class="col md-4">
              <label for="jan" class="form-label">Januari</label>
              <input type="text" class="form-control" name="jan" id="jan">
            </div>
            <div class="col md-4">
              <label for="feb" class="form-label">February</label>
              <input type="text" class="form-control" name="feb" id="feb">
            </div>
            <div class="col md-4">
              <label for="mar" class="form-label">March</label>
              <input type="text" class="form-control" name="mar" id="mar">
            </div>
          </div>
          <div class="row g-3">
            <div class="col md-4">
              <label for="apr" class="form-label">April</label>
              <input type="text" class="form-control" name="apr" id="apr">
            </div>
            <div class="col md-4">
              <label for="ma" class="form-label">May</label>
              <input type="text" class="form-control" name="may" id="may">
            </div>
            <div class="col md-4">
              <label for="jun" class="form-label">June</label>
              <input type="text" class="form-control" name="jun" id="jun">
            </div>
            </div>
            <div class="row g-3">
            <div class="col md-4">
              <label for="jul" class="form-label">July</label>
              <input type="text" class="form-control" name="jul" id="jul">
            </div>
            <div class="col md-4">
              <label for="aug" class="form-label">August</label>
              <input type="text" class="form-control" name="aug" id="aug">
            </div>
            <div class="col md-4">
              <label for="sep" class="form-label">September</label>
              <input type="text" class="form-control" name="sep" id="sep">
            </div>
          </div>
          <div class="row g-3">
            <div class="col md-4">
              <label for="oct" class="form-label">October</label>
              <input type="text" class="form-control" name="oct" id="oct">
            </div>
            <div class="col md-4">
              <label for="nov" class="form-label">November</label>
              <input type="text" class="form-control" name="nov" id="nov">
            </div>
            <div class="col md-4">
              <label for="dec" class="form-label">December</label>
              <input type="text" class="form-control" name="dec" id="dec">
            </div>
          </div>
          <div class="row g-3 d-grid gap-2 col-6 mx-auto">
            <button type="submit" class="btn btn-tosca">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Add Modal Office Location -->
<div class="modal fade" id="locationEditModal" tabindex="-1" aria-labelledby="modalLocation" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="">Edit Location</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <form action="" method="POST">
                  @csrf   
                  <div class="mb-3">
                      <label for="inputName" class="form-label">Name</label>
                      <input type="text" class="form-control" name="name" required>
                  </div>   

                  <!-- Hidden inputs for latitude and longitude -->
                  <input type="hidden" id="latitude" name="latitude" required>
                  <input type="hidden" id="longitude" name="longitude" required>

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