<!-- <div class="modal fade" id="addWorkDay" tabindex="-1" aria-labelledby="modalWorkDay" aria-hidden="treu">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="addWorkDayTitle">Add New Work Day</h5>
                <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="true"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('workDay.create') }}" method="POST">
                    @csrf
                    <div class="form-group row mb-3 container">
                        <div class="col-md-5">
                            <label for="name" class="fw-bold">Work Day Name</label>
                            <span style="color: red; font-size: 15px;">*</span>
                        </div>
                        <div class="col-md">
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row mb-3 container">
                        <div class="col-md-5">
                            <label for="tolerance" class="fw-bold">Tolerance in Minute</label>
                        </div>
                        <div class="col-md">
                            <input type="number" id="tolerance" name="tolerance" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row container">
                        <label for="workDay" class="fw-bold"></label>
                    </div>
                    <div class="form-group row container">
                        <table class="table table-striped table-bordered ">
                            <thead class="content-align-center">
                                <th>Day</th>
                                <th>Day-Off</th>
                                <th>Arrival<span style="color: red; font-size: 15px;">*</span></th>
                                <th>Check In<span style="color: red; font-size: 15px;">*</span></th>
                                <th>Check Out<span style="color: red; font-size: 15px;">*</span></th>
                            </thead>
                            @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                            <tbody>
                                <th name="day" id="day">{{ ucfirst($day) }}</th>
                                <td>
                                    <input type="checkbox" id="dayOff[{{ $day }}]" name="dayOff[{{ $day }}]" value="1">
                                </td>
                                <td>
                                    <input type="time" class="form-control" id="arrival[{{ $day }}]" name="arrival[{{ $day }}]">
                                </td>
                                <td>
                                    <input type="time" class="form-control" id="checkIn[{{ $day }}]" name="checkIn[{{ $day }}]">
                                </td>
                                <td>
                                    <input type="time" class="form-control" id="checkOut[{{ $day }}]" name="checkOut[{{ $day }}]">
                                </td>
                            </tbody>
                            @endforeach
                        </table>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Schedule</button>
                </form>
            </div>

        </div>
    </div>
</div>



 -->

 <div class="modal fade" id="addWorkDay" tabindex="-1" aria-labelledby="modalWorkDay" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="addWorkDayTitle">Add New Work Day</h5>
                <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="true"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('workDay.create') }}" method="POST">
                    @csrf
                    <div class="form-group row mb-3 container">
                        <div class="col-md-5">
                            <label for="name" class="fw-bold">Work Day Name</label>
                            <span style="color: red; font-size: 15px;">*</span>
                        </div>
                        <div class="col-md">
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row mb-3 container">
                        <div class="col-md-5">
                            <label for="tolerance" class="fw-bold">Tolerance in Minute</label>
                        </div>
                        <div class="col-md">
                            <input type="number" id="tolerance" name="tolerance" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row container">
                        <table class="table table-striped table-bordered ">
                            <thead class="content-align-center">
                                <th>Day</th>
                                <th>Day-Off</th>
                                <th>Arrival<span style="color: red; font-size: 15px;">*</span></th>
                                <th>Check In<span style="color: red; font-size: 15px;">*</span></th>
                                <th>Check Out<span style="color: red; font-size: 15px;">*</span></th>
                                <th>Break In<span style="color: red; font-size: 15px;">*</span></th>
                                <th>Break Out<span style="color: red; font-size: 15px;">*</span></th>
                                <th>Exclude Break</th>
                            </thead>
                            @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                            <tbody>
                                <th name="day" id="day">{{ ucfirst($day) }}</th>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="dayOff[{{ $day }}]" name="dayOff[{{ $day }}]" value="1" onchange="toggleTimeInputs('{{ $day }}')">
                                    </div>
                                </td>
                                <td>
                                    <input type="time" class="form-control" id="arrival[{{ $day }}]" name="arrival[{{ $day }}]">
                                </td>
                                <td>
                                    <input type="time" class="form-control" id="checkIn[{{ $day }}]" name="checkIn[{{ $day }}]">
                                </td>
                                <td>
                                    <input type="time" class="form-control" id="checkOut[{{ $day }}]" name="checkOut[{{ $day }}]">
                                </td>
                                <td>
                                    <input type="time" class="form-control" id="breakIn[{{ $day }}]" name="breakIn[{{ $day }}]">
                                </td>
                                <td>
                                    <input type="time" class="form-control" id="breakOut[{{ $day }}]" name="breakOut[{{ $day }}]">
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="break[{{ $day }}]" name="break[{{ $day }}]" value="1">
                                    </div>
                                </td>
                            </tbody>
                            @endforeach
                        </table>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-tosca me-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-untosca me-3">Submit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

</script>
