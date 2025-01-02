<div class="modal fade" id="editPresence" tabindex="-1" aria-labelledby="editPresenceLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPresenceLabel">Edit Presence</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPresenceForm" action="" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label for="name" class="form-label">Name</label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="name" disabled>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label for="date" class="form-label">Date</label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="date" name="date" disabled>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label for="workDay" class="form-label">Work Day</label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="workDay" id="workDay" disabled>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label for="checkin" class="form-label">Check In</label>
                        </div>
                        <div class="col-sm-9">
                            <input type="time" step="1" class="form-control" id="checkin" name="checkin" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label for="checkout" class="form-label">Check Out</label>
                        </div>
                        <div class="col-sm-9">
                            <input type="time" step="1" class="form-control" id="checkout" name="checkout" required>
                        </div>
                    </div>

                    <!-- Hidden input for ID -->
                    <input type="hidden" id="presenceId" name="id">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-tosca me-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="action" class="btn btn-untosca">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>
  