<!-- Accept/Reject Modal -->
<div class="modal fade" id="acceptRejectModal" tabindex="-1" aria-labelledby="acceptRejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="acceptRejectModalLabel">Update Leave Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="modalText">You are about to update the status of the leave request.</p>
                <form id="acceptRejectForm">
                    @csrf
                    <input type="hidden" id="leaveId" name="leaveId">
                    <input type="hidden" id="actionStatus" name="status">
                    <!-- Add any other inputs you need to send with the form -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="acceptBtn" class="btn btn-primary">Accept</button>
                <button type="button" id="rejectBtn" class="btn btn-danger">Reject</button>
            </div>
        </div>
    </div>
</div>
