<!-- Add Modal Position -->
<div class="modal fade" id="addPosition" tabindex="-1" aria-labelledby="modalPosition" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPosition">Add Position</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('position.add') }}" method="POST">
                    @csrf   
                    <div class="mb-3">
                        <label for="inputName" class="form-label">Name</label>
                        <input type="text" class="form-control" name="position" required>
                    </div>        
                    <button type="submit" class="btn btn-tosca">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal JobTitle -->
<div class="modal fade" id="addJobTitle" tabindex="-1" aria-labelledby="modalJobTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addJobTitle">Add Job Title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('jobTitle.add') }}" method="POST">
                    @csrf   
                    <div class="mb-3">
                        <label for="inputName" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputName" class="form-label">Section</label>
                        <input type="text" class="form-control" name="section" required>
                    </div>                            
                    <button type="submit" class="btn btn-tosca">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal Division -->
<div class="modal fade" id="addDivision" tabindex="-1" aria-labelledby="modalDivision" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDivision">Add Division</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('division.add')}}" method="POST">
                    @csrf   
                    <div class="mb-3">
                        <label for="inputName" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>                  
                    <button type="submit" class="btn btn-tosca">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal Department -->
<div class="modal fade" id="addDepartment" tabindex="-1" aria-labelledby="modalDepartment" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDepartment">Add Department</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('department.add')}}" method="POST">
                    @csrf   
                    <div class="mb-3">
                        <label for="inputName" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>                  
                    <button type="submit" class="btn btn-tosca">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal Employee Status -->
<div class="modal fade" id="addStatus" tabindex="-1" aria-labelledby="modalStatus" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStatus">Add Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('status.add') }}" method="POST">
                    @csrf   
                    <div class="mb-3">
                        <label for="inputName" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>                          
                    <button type="submit" class="btn btn-tosca">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- <!-- Add Modal Office Location -->
<div class="modal fade" id="addLocation" tabindex="-1" aria-labelledby="modalLocation" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Add Location</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('location.add') }}" method="POST">
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
</div> --}}


{{-- <div class="modal fade" id="addLocation" tabindex="-1" aria-labelledby="modalLocation" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Add Location</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('location.add') }}" method="POST">
                    @csrf   
                    <div class="mb-3">
                        <label for="inputName" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>  
                    <div class="mb-3">
                        <label for="latitude" class="form-label">Latitude</label>
                        <input type="text" class="form-control" name="latitude" requried>
                    </div>
                    <div class="mb-3">
                        <label for="longitude" class="form-label">Longitude</label>
                        <input type="text" class="form-control" name="longitude" requried>
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
</div> --}}