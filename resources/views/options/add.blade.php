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

<!-- Add Modal Office Location -->
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
</div>

<!-- Add Modal Sales Person -->
<div class="modal fade" id="addSalesPerson" tabindex="-1" aria-labelledby="modalSalesPerson" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSalesPerson">Add Sales Person</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('salesPerson.add')}}" method="POST">
                    @csrf   
                    <div class="mb-3">
                        <select class="form-select" name="salesPerson" aria-label="Default select example">
                            <option selected>Select Sales Person</option>
                            @foreach($employees as $data)
                            <option selected value="{{ $data->name }}">{{ $data->name }}</option>
                            @endforeach
                        </select>
                    </div>              
                    <button type="submit" class="btn btn-tosca">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal Work Schedule -->
<div class="modal fade" id="addSchedule" tabindex="-1" aria-labelledby="modalSchedule" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSchedule">Add Work Schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('schedule.add')}}" method="POST">
                    @csrf   
                    <div class="mb-3">
                        <label for="inputName" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputArrival" class="form-label">Arrival</label>
                        <input type="time" class="form-control" name="arrival">
                    </div>  
                    <div class="mb-3">
                        <label for="inputName" class="form-label">Start at</label>
                        <input type="time" class="form-control" name="start" required>
                    </div>          
                    <div class="mb-3">
                        <label for="inputName" class="form-label">End at</label>
                        <input type="time" class="form-control" name="end" required>
                    </div>         
                    <button type="submit" class="btn btn-tosca">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- <!-- Add Modal indicator --> --}}

<!-- Add Modal On Day Calendar -->
<div class="modal fade" id="addOnDayCalendar" tabindex="-1" aria-labelledby="modalOnDayCalendar" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addOnDayCalendar">Add On-Day</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('onDayCalendar.add')}}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="inputName" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" id="inputName">
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                        <label for="jan" class="form-label">Januari</label>
                        <input type="text" class="form-control" name="jan">
                        </div>
                        <div class="col-md-4">
                        <label for="feb" class="form-label">February</label>
                        <input type="text" class="form-control" name="feb">
                        </div>
                        <div class="col-md-4">
                        <label for="mar" class="form-label">March</label>
                        <input type="text" class="form-control" name="mar">
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                        <label for="apr" class="form-label">April</label>
                        <input type="text" class="form-control" name="apr">
                        </div>
                        <div class="col-md-4">
                        <label for="ma" class="form-label">May</label>
                        <input type="text" class="form-control" name="may">
                        </div>
                        <div class="col-md-4">
                        <label for="jun" class="form-label">June</label>
                        <input type="text" class="form-control" name="jun">
                        </div>
                        </div>
                        <div class="row g-3">
                        <div class="col-md-4">
                        <label for="jul" class="form-label">July</label>
                        <input type="text" class="form-control" name="jul">
                        </div>
                        <div class="col-md-4">
                        <label for="aug" class="form-label">August</label>
                        <input type="text" class="form-control" name="aug">
                        </div>
                        <div class="col-md-4">
                        <label for="sep" class="form-label">September</label>
                        <input type="text" class="form-control" name="sep">
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                        <label for="oct" class="form-label">October</label>
                        <input type="text" class="form-control" name="oct">
                        </div>
                        <div class="col-md-4">
                        <label for="nov" class="form-label">November</label>
                        <input type="text" class="form-control" name="nov">
                        </div>
                        <div class="col-md-4">
                        <label for="dec" class="form-label">December</label>
                        <input type="text" class="form-control" name="dec">
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




                    <!-- <div class="row g-3">
                        <div class="col md-4">
                            <label for="inputName" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col md-4">
                            <label for="inputName" class="form-label">January</label>
                            <input type="text" class="form-control" name="jan" required>
                        </div>
                        <div class="col md-4">
                            <label for="inputName" class="form-label">February</label>
                            <input type="text" class="form-control" name="feb" required>
                        </div>
                        <div class="col md-4">
                            <label for="inputName" class="form-label">March</label>
                            <input type="text" class="form-control" name="mar" required>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col md-4">
                            <label for="inputName" class="form-label">April</label>
                            <input type="text" class="form-control" name="apr" required>
                        </div>
                        <div class="col md-4">
                            <label for="inputName" class="form-label">May</label>
                            <input type="text" class="form-control" name="may" required>
                        </div>
                        <div class="col md-4">
                            <label for="inputName" class="form-label">June</label>
                            <input type="text" class="form-control" name="jun" required>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col md-4">
                            <label for="inputName" class="form-label">July</label>
                            <input type="text" class="form-control" name="jul" required>
                        </div>
                        <div class="col md-4">
                            <label for="inputName" class="form-label">August</label>
                            <input type="text" class="form-control" name="aug" required>
                        </div>
                        <div class="col md-4">
                            <label for="inputName" class="form-label">September</label>
                            <input type="text" class="form-control" name="sep" required>
                        </div>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col md-4">
                            <label for="inputName" class="form-label">October</label>
                            <input type="text" class="form-control" name="oct" required>
                        </div>
                        <div class="col md-4">
                            <label for="inputName" class="form-label">November</label>
                            <input type="text" class="form-control" name="nov" required>
                        </div>
                        <div class="col md-4">
                            <label for="inputName" class="form-label">December</label>
                            <input type="text" class="form-control" name="dec" required>
                        </div>
                    </div>
                    
                    <div class="row g-3 d-grid gap-2 col-6 mx-auto">
                        <button type="submit" class="btn btn-tosca">Submit</button>
                    </div> -->