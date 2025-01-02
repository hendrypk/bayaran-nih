<div class="modal fade" id="addEntityModal" tabindex="-1" aria-labelledby="modalEntityLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEntityLabel">Add Entity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="entityForm" method="POST">
                    @csrf
                    <div class="mb-3" id="entityFields">
                        <!-- Form fields will be added dynamically here -->
                    </div>
                    <button type="submit" class="btn btn-tosca">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal Office Location -->
<div class="modal fade" id="location" tabindex="-1" aria-labelledby="modalLocation" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLocationTitle">Add Location</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="locationForm" method="POST">
                    @csrf   
                    <div class="mb-3">
                        <label for="inputName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
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
                        <input type="number" class="form-control" id="radius" name="radius" requried>
                    </div>
                    <button type="submit" class="btn btn-tosca">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>