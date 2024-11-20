@extends('_layout.main')
@section('title', 'Employees')
@section('content')

<div class="row">
  <div class="col-lg">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Add Employee</h5>
        <div class="col-md">
              <div class="align-items-start">
                <div class="nav nav-pills" id="v-pills-tab" role="tablist" aria-orientation="horizontal">

                  <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#biodata" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Biodata</button>
                  <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#staffing" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Staffing</button>
                  <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#payroll" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Payroll</button>
              </div>
          </div>
      </div>
        <!-- General Form Elements -->

    {{-- <div class="col-md-12 mt-3">
      <div class="align-items-start">
        <div class="tab-content" id="v-pills-tabContent">

          <div class="tab-pane fade show active" id="biodata" role="tabpanel" aria-labelledby="v-pills-basic-information-tab">
            <form action="{{route('employee.submit')}}" method="POST">
              @csrf
              <div class="row g-3 mb-2">
                <div class="col-md-3 profile-card pt-4 d-flex flex-column align-items-center">
                  <div class="card-body">
                    <img src="{{asset('e-presensi/assets/img/bayaran-favicon.png')}}" class="profile-rounded-circle" alt="profile">
                  </div>
                </div>
                <div class="col-md">
                  <div class="row g-3 mb-2">
                    <div class="row g-3 mb-2">
                      <div class="col-md-6">
                        <label for="name" class="form-label">Full Name <span class="span-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" required>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <label for="place_birth" class="form-label">Place Birth <span class="span-danger">*</span></label>
                      <input type="text" class="form-control" id="place_birth" name="place_birth" required>
                    </div>
                    <div class="col-md-6">
                      <label for="date_birth" class="form-label">Date Birth <span class="span-danger">*</span></label>
                      <input type="date" class="form-control" id="date_birth" name="date_birth" required>
                    </div>
                    <div class="col-md-6">
                      <label for="gender" class="form-label">Gender <span class="span-danger">*</span></label>
                      <select class="form-select" name="gender" aria-label="Default select example">
                        <option selected disabled>- Select Gender -</option>
                        @foreach($genders as $gender)
                          <option value="{{ $gender }}">{{ $gender }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label for="blood_type" class="form-label">Blood Type</label>
                      <select class="form-select" name="blood_type" aria-label="Default select example">
                        <option selected disabled>- Select Blood Type -</option>
                        @foreach($bloods as $blood)
                          <option value="{{ $blood }}">{{ $blood }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label for="religion" class="form-label">Religion <span class="span-danger">*</span></label>
                      <select class="form-select" name="religion" aria-label="Default select example">
                        <option selected disabled>- Select Religion -</option>
                        @foreach($religions as $religion)
                          <option value="{{ $religion }}">{{ $religion }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label for="marriage" class="form-label">Marrital <span class="span-danger">*</span></label>
                      <select class="form-select" name="marriage" aria-label="Default select example">
                        <option selected disabled>- Select Marrital -</option>
                        @foreach($marriage as $marriage)
                          <option value="{{ $marriage }}">{{ $marriage }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>

          <div class="tab-pane fade" id="staffing" role="tabpanel" aria-labelledby="v-pills-career-tab">
            <div class="col-md-6">          <div class="row mb-3">
              <label class="col-sm-4 col-form-label">Position</label>
              <div class="col-sm-8">
                <select class="form-select" name="position_id" aria-label="Default select example">
                  <option selected disabled>Select position</option>
                  @foreach($position as $data)
                  <option value="{{ $data->id }}">{{ $data->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            
            <div class="row mb-3">
              <label class="col-sm-4 col-form-label">Job Title</label>
              <div class="col-sm-8">
                <select class="form-select" name="job_title_id" aria-label="Default select example">
                  <option selected disabled>Select Job Title</option>
                  @foreach($job_title as $data)
                  <option value="{{ $data->id }}">{{ $data->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
  
            <div class="row mb-3">
              <label class="col-sm-4 col-form-label">Division</label>
              <div class="col-sm-8">
                <select class="form-select" name="division_id" aria-label="Default select example">
                  <option selected disabled>Select Division</option>
                  @foreach($division as $data)
                  <option value="{{ $data->id }}">{{ $data->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
  
            <div class="row mb-3">
              <label class="col-sm-4 col-form-label">Department</label>
              <div class="col-sm-8">
                <select class="form-select" name="department_id" aria-label="Default select example">
                  <option selected disabled>Select Department</option>
                  @foreach($department as $data)
                  <option value="{{ $data->id }}">{{ $data->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
  
            <div class="row mb-3">
              <label for="inputDate" class="col-sm-4 col-form-label">Joining Date</label>
              <div class="col-sm-8">
                <input type="date" name="joining_date" class="form-control" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
              </div>
            </div>
  
            <div class="row mb-3">
              <label class="col-sm-4 col-form-label">Work Schedule</label>
              <div class="col-sm-8">    
                  @foreach($workDay as $data)       
                      <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="workDay{{ $data->id }}" name="workDay[]" value="{{ $data->id }}">
                          <label class="form-check-label" for="workDay{{ $data->id }}">
                              {{ $data->name }}
                          </label>
                      </div>
                  @endforeach
              </div>
            </div>
  
              <div class="row mb-3">
                <label class="col-sm-4 col-form-label">Office Location</label>
                <div class="col-sm-8">    
                    @foreach($officeLocations as $data)       
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="officeLocations{{ $data->id }}" name="officeLocations[]" value="{{ $data->id }}">
                            <label class="form-check-label" for="officeLocations{{ $data->id }}">
                                {{ $data->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
              </div>
              <!-- <p>Checkbox values:</p>
              <p id="debug-workdays"></p> -->
  
            <div class="row mb-3">
              <label class="col-sm-4 col-form-label">Employee Status</label>
              <div class="col-sm-8">
                <select class="form-select" name="employee_status" aria-label="Default select example">
                  <option selected disabled>Select Status</option>
                  @foreach($status as $data)
                  <option value="{{ $data->name }}">{{ $data->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
  
            <div class="row mb-3">
              <label class="col-sm-4 col-form-label">Sales Status</label>
              <div class="col-sm-8">
                <select class="form-select" name="sales_status" aria-label="Default select example">
                  <option selected disabled>Select Status</option>
                  <option value="1">Yes</option>
                  <option value="0">No</option>
                </select>
              </div>
            </div>
            
  
            <div class="row mb-3">
              <label class="col-sm-4 col-form-label">KPI</label>
              <div class="col-sm-8">
                <select class="form-select" name="kpi_id" aria-label="Default select example">
                  <option selected>Select KPI</option>
                  @foreach($kpi_id as $data)
                  <option value="{{ $data->id }}">{{ $data->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
  
            <div class="row mb-3">
              <label for="inputCity" class="col-sm-4 col-form-label">Bobot KPI</label>
              <div class="col-sm-8">
                <input type="number" min="0"  name="bobot_kpi" class="form-control">
              </div>
            </div>
            </div>
          </div>

          <div class="tab-pane fade" id="payroll" role="tabpanel" aria-labelledby="v-pills-payroll-tab">
            <div class="col-md-6">
              <label for="date_birth" class="form-label">Place Birth <span class="span-danger">*</span></label>
              <input type="date" class="form-control" id="date_birth" name="date_birth" required>
            </div>
          </div>

        </div>
      </div>
    </div> --}}






          {{-- <div class="col-md-6">
            <div class="row g-3 mb-2">
              <div class="col-md-12">
                <label for="name" class="form-label">Full Name <span class="span-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" required>
              </div>
              <div class="col-md-12">
                <label for="email" class="form-label">Email <span class="span-danger">*</span></label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>
              <div class="col-md-12">
                <label for="city" class="form-label">Identity Address <span class="span-danger">*</span></label>
                <input type="text" class="form-control" id="city" name="city" required>
              </div>
            </div>
          </div>
        </div> --}}
          



{{-- <div class="row mt  -10"></div>
          <div class="row mb-3">
            <label for="inputEmail" class="col-sm-4 col-form-label">Full Name</label>
            <div class="col-sm-8">
              <input type="name" name="name" class="form-control">
            </div>
          </div>

          <div class="row mb-3">
            <label for="inputEmail" class="col-sm-4 col-form-label">email</label>
            <div class="col-sm-8">
              <input type="email" name="email" class="form-control">
            </div>
          </div>

          <div class="row mb-3">
            <label for="city" class="col-sm-4 col-form-label">Identity Address</label>
            <div class="col-sm-8">
              <input type="text" name="city" class="form-control">
            </div>
          </div>

          <div class="row mb-3">
            <label for="domicile" class="col-sm-4 col-form-label">Current Address</label>
            <div class="col-sm-8">
              <input type="text" name="domicile" class="form-control">
            </div>
          </div>

          <div class="row mb-3">
            <label for="place_birth" class="col-sm-4 col-form-label">Place of Birth</label>
            <div class="col-sm-8">
              <input type="text" name="place_birth" class="form-control">
            </div>
          </div>

          <div class="row mb-3">
            <label for="date_birth" class="col-sm-4 col-form-label">Date of Birth</label>
            <div class="col-sm-8">
              <input type="date" name="date_birth" class="form-control">
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-4 col-form-label">Blood Type</label>
            <div class="col-sm-8">
              <select class="form-select" name="blood_type" aria-label="Default select example">
                <option selected disabled>- Select Blood Type -</option>
                @foreach($bloods as $blood)
                <option value="{{ $blood }}">{{ $blood }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-4 col-form-label">Gender</label>
            <div class="col-sm-8">
              <select class="form-select" name="gender" aria-label="Default select example">
                <option selected disabled>- Select Gender -</option>
                @foreach($genders as $gender)
                <option value="{{ $gender }}">{{ $gender }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-4 col-form-label">Religion</label>
            <div class="col-sm-8">
              <select class="form-select" name="religion" aria-label="Default select example">
                <option selected disabled>- Select Religion -</option>
                @foreach($religions as $religion)
                <option value="{{ $religion }}">{{ $religion }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-4 col-form-label">Marrital Status</label>
            <div class="col-sm-8">
              <select class="form-select" name="marriage" aria-label="Default select example">
                <option selected disabled>- Select Marriage Status -</option>
                @foreach($marriage as $marriage)
                <option value="{{ $marriage }}">{{ $marriage }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-4 col-form-label">Education</label>
            <div class="col-sm-8">
              <select class="form-select" name="education" aria-label="Default select example">
                <option selected disabled>- Select Education -</option>
                @foreach($educations as $education)
                <option value="{{ $education }}">{{ $education }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label for="whatsapp" class="col-sm-4 col-form-label">WhatsApp Number</label>
            <div class="col-sm-8">
              <input type="number" name="whatsapp" class="form-control">
            </div>
          </div>
          
          <div class="row mb-3">
            <label class="col-sm-4 col-form-label">Bank</label>
            <div class="col-sm-8">
              <select class="form-select" name="bank" aria-label="Default select example">
                <option selected disabled>- Select Bank -</option>
                @foreach($banks as $bank)
                <option value="{{ $bank }}">{{ $bank }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label for="whatsapp" class="col-sm-4 col-form-label">Bank Number</label>
            <div class="col-sm-8">
              <input type="number" name="bank_number" class="form-control">
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-4 col-form-label">Position</label>
            <div class="col-sm-8">
              <select class="form-select" name="position_id" aria-label="Default select example">
                <option selected disabled>Select position</option>
                @foreach($position as $data)
                <option value="{{ $data->id }}">{{ $data->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          
          <div class="row mb-3">
            <label class="col-sm-4 col-form-label">Job Title</label>
            <div class="col-sm-8">
              <select class="form-select" name="job_title_id" aria-label="Default select example">
                <option selected disabled>Select Job Title</option>
                @foreach($job_title as $data)
                <option value="{{ $data->id }}">{{ $data->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-4 col-form-label">Division</label>
            <div class="col-sm-8">
              <select class="form-select" name="division_id" aria-label="Default select example">
                <option selected disabled>Select Division</option>
                @foreach($division as $data)
                <option value="{{ $data->id }}">{{ $data->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-4 col-form-label">Department</label>
            <div class="col-sm-8">
              <select class="form-select" name="department_id" aria-label="Default select example">
                <option selected disabled>Select Department</option>
                @foreach($department as $data)
                <option value="{{ $data->id }}">{{ $data->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label for="inputDate" class="col-sm-4 col-form-label">Joining Date</label>
            <div class="col-sm-8">
              <input type="date" name="joining_date" class="form-control" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-4 col-form-label">Work Schedule</label>
            <div class="col-sm-8">    
                @foreach($workDay as $data)       
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="workDay{{ $data->id }}" name="workDay[]" value="{{ $data->id }}">
                        <label class="form-check-label" for="workDay{{ $data->id }}">
                            {{ $data->name }}
                        </label>
                    </div>
                @endforeach
            </div>
          </div>

            <div class="row mb-3">
              <label class="col-sm-4 col-form-label">Office Location</label>
              <div class="col-sm-8">    
                  @foreach($officeLocations as $data)       
                      <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="officeLocations{{ $data->id }}" name="officeLocations[]" value="{{ $data->id }}">
                          <label class="form-check-label" for="officeLocations{{ $data->id }}">
                              {{ $data->name }}
                          </label>
                      </div>
                  @endforeach
              </div>
            </div>
            <!-- <p>Checkbox values:</p>
            <p id="debug-workdays"></p> -->

          <div class="row mb-3">
            <label class="col-sm-4 col-form-label">Employee Status</label>
            <div class="col-sm-8">
              <select class="form-select" name="employee_status" aria-label="Default select example">
                <option selected disabled>Select Status</option>
                @foreach($status as $data)
                <option value="{{ $data->name }}">{{ $data->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-4 col-form-label">Sales Status</label>
            <div class="col-sm-8">
              <select class="form-select" name="sales_status" aria-label="Default select example">
                <option selected disabled>Select Status</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
              </select>
            </div>
          </div>
          

          <div class="row mb-3">
            <label class="col-sm-4 col-form-label">KPI</label>
            <div class="col-sm-8">
              <select class="form-select" name="kpi_id" aria-label="Default select example">
                <option selected>Select KPI</option>
                @foreach($kpi_id as $data)
                <option value="{{ $data->id }}">{{ $data->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label for="inputCity" class="col-sm-4 col-form-label">Bobot KPI</label>
            <div class="col-sm-8">
              <input type="number" min="0"  name="bobot_kpi" class="form-control">
            </div>
          </div> --}}

          <div class="d-flex justify-content-end">
              <div class="">
                <button type="cancel" class="btn btn-tosca me-3">Cancel</button>
              </div>
              <div class="">
                <button type="submit" class="btn btn-untosca">Add Employee</button>
              </div>
            </div>

        </form>
        <!-- End General Form Elements -->
      </div>
    </div>
  </div>
</div>

@section('script')
<script>
document.querySelector('form').addEventListener('submit', (event) => {
    const selectedWorkDays = [...document.querySelectorAll('input[name="workDay[]"]:checked')]
    //     .map(checkbox => checkbox.value);
    // console.log(selectedWorkDays);
});

document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            const selectedValues = [...document.querySelectorAll('input[type="checkbox"]:checked')]
            //     .map(checked => checked.value);
            // document.getElementById('debug-workdays').innerText = JSON.stringify(selectedValues);
        });
    });
</script>

@endsection
@endsection