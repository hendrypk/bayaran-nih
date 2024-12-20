<div class="modal fade" id="columnsModal" tabindex="-1" role="dialog" aria-labelledby="columnsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="columnsModalLabel">Select Columns</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="GET" action="{{ route('employee.list') }}">
                    <label for="columns">Select Columns:</label>
                    <select name="columns[]" id="columns" class="form-control" multiple>
                        <option value="eid">EID</option>
                        <option value="email">Email</option>
                        <option value="username">Username</option>
                        <option value="password">Password</option>
                        <option value="name">Name</option>
                        <option value="city">City</option>
                        <option value="domicile">Domicile</option>
                        <option value="place_birth">Place of Birth</option>
                        <option value="date_birth">Date of Birth</option>
                        <option value="blood_type">Blood Type</option>
                        <option value="gender">Gender</option>
                        <option value="religion">Religion</option>
                        <option value="marriage">Marriage</option>
                        <option value="education">Education</option>
                        <option value="whatsapp">WhatsApp</option>
                        <option value="bank">Bank</option>
                        <option value="bank_number">Bank Number</option>
                        <option value="position_id">Position ID</option>
                        <option value="job_title_id">Job Title ID</option>
                        <option value="division_id">Division ID</option>
                        <option value="department_id">Department ID</option>
                        <option value="joining_date">Joining Date</option>
                        <option value="employee_status">Employee Status</option>
                        <option value="sales_status">Sales Status</option>
                        <option value="pa_id">PA ID</option>
                        <option value="kpi_id">KPI ID</option>
                        <option value="bobot_kpi">Bobot KPI</option>
                        <option value="role">Role</option>
                        <option value="resignation">Resignation</option>
                    </select>
                    <button type="submit" class="btn btn-primary mt-2">Apply Filter</button>
                </form>
            </div>
        </div>
    </div>
</div>