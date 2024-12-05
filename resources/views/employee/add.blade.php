@extends('_layout.main')
@section('title', 'Employees')
@section('content')

<div class="row">
  <div class="col-lg">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Add Employee</h5>
        {{-- <div class="row g-3">
        <div class="col-md-6">
          <div class="row mb-3">
            <label for="inputEmail" class="col-sm-2 col-form-label">Full Name</label>
            <div class="col-sm-8">
              <input type="name" name="name" class="form-control">
            </div>
          </div>

          <div class="row mb-3">
            <label for="inputEmail" class="col-sm-2 col-form-label">email</label>
            <div class="col-sm-8">
              <input type="email" name="email" class="form-control">
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="row mb-3">
            <label for="inputEmail" class="col-sm-2 col-form-label">Full Name</label>
            <div class="col-sm-8">
              <input type="name" name="name" class="form-control">
            </div>
          </div>

          <div class="row mb-3">
            <label for="inputEmail" class="col-sm-2 col-form-label">email</label>
            <div class="col-sm-8">
              <input type="email" name="email" class="form-control">
            </div>
          </div>
        </div>
      </div> --}}
        <!-- General Form Elements -->
            
      <form action="{{route('employee.submit')}}" method="POST" id="addEmployee">
        @csrf
              
        <div class="row mt-10"></div>
          <div class="row mb-3">
            <label for="inputEmail" class="col-sm-2 col-form-label">Full Name</label>
            <div class="col-sm-8">
              <input type="name" name="name" class="form-control">
            </div>
          </div>

          <div class="row mb-3">
            <label for="city" class="col-sm-2 col-form-label">Identity Address</label>
            <div class="col-sm-8">
              <textarea name="city" id="city" cols="96" rows="3" class="form-control"></textarea>
            </div>
          </div>

          <div class="row mb-3">
            <label for="domicile" class="col-sm-2 col-form-label">Current Address</label>
            <div class="col-sm-8">
              <textarea name="domicile" id="domicile" cols="96" rows="3" class="form-control"></textarea>
            </div>
          </div>

          <div class="row mb-3">
            <label for="place_birth" class="col-sm-2 col-form-label">Place of Birth</label>
            <div class="col-sm-8">
              <input type="text" name="place_birth" class="form-control">
            </div>
          </div>

          <div class="row mb-3">
            <label for="date_birth" class="col-sm-2 col-form-label">Date of Birth</label>
            <div class="col-sm-8">
              <input type="date" name="date_birth" class="form-control">
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Blood Type</label>
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
            <label class="col-sm-2 col-form-label">Gender</label>
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
            <label class="col-sm-2 col-form-label">Religion</label>
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
            <label class="col-sm-2 col-form-label">Marrital Status</label>
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
            <label class="col-sm-2 col-form-label">Education</label>
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
            <label for="inputEmail" class="col-sm-2 col-form-label">email</label>
            <div class="col-sm-8">
              <input type="email" name="email" class="form-control">
            </div>
          </div>

          <div class="row mb-3">
            <label for="whatsapp" class="col-sm-2 col-form-label">WhatsApp Number</label>
            <div class="col-sm-8">
              <input type="number" name="whatsapp" class="form-control">
            </div>
          </div>
          
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Bank</label>
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
            <label for="whatsapp" class="col-sm-2 col-form-label">Bank Number</label>
            <div class="col-sm-8">
              <input type="number" name="bank_number" class="form-control">
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Position</label>
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
            <label class="col-sm-2 col-form-label">Job Title</label>
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
            <label class="col-sm-2 col-form-label">Division</label>
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
            <label class="col-sm-2 col-form-label">Department</label>
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
            <label for="inputDate" class="col-sm-2 col-form-label">Joining Date</label>
            <div class="col-sm-8">
              <input type="date" name="joining_date" class="form-control" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Work Schedule</label>
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
            <label class="col-sm-2 col-form-label">Office Location</label>
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

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Employee Status</label>
            <div class="col-sm-8">
              <select class="form-select" name="employee_status" aria-label="Default select example">
                <option selected disabled>Select Status</option>
                @foreach($status as $data)
                <option value="{{ $data->id }}">{{ $data->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Sales Status</label>
            <div class="col-sm-8">
              <select class="form-select" name="sales_status" aria-label="Default select example">
                <option selected disabled>Select Status</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
              </select>
            </div>
          </div>
          
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Appraisal</label>
            <div class="col-sm-8">
              <select class="form-select" name="pa_id" aria-label="Default select example">
                <option value="" selected>Select Appraisal</option>
                @foreach($pa_id as $data)
                <option value="{{ $data->id }}">{{ $data->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label">KPI</label>
            <div class="col-sm-8">
              <select class="form-select" name="kpi_id" aria-label="Default select example">
                <option value="" selected>Select KPI</option>
                @foreach($kpi_id as $data)
                <option value="{{ $data->id }}">{{ $data->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label for="inputCity" class="col-sm-2 col-form-label">Bobot KPI</label>
            <div class="col-sm-8">
              <input type="number" min="0"  name="bobot_kpi" class="form-control">
            </div>
          </div>

          <div class="d-flex justify-content-end">
              <div class="">
                <button type="cancel" class="btn btn-tosca me-3">Cancel</button>
              </div>
              <div class="">
                <button type="submit" class="btn btn-untosca">Add Employee</button>
              </div>
            </div>

        </form>
      </div>
    </div>
  </div>
</div>

@section('script')
<script>
  document.getElementById('addEmployee').addEventListener('submit', function (event) {
      event.preventDefault(); 
      const form = event.target;

      fetch(form.action, {
          method: form.method,
          body: new FormData(form),
          headers: {
              'Accept': 'application/json'
          }
      })
      .then(response => response.json())
      .then(data => {
          if (!data.success) {
              let errorMessage = '';
              for (let field in data.errors) {
                  errorMessage += `<p>${data.errors[field].join('<br>')}</p>`;
              }

              Swal.fire({
                  icon: 'error',
                  title: 'Validation Error',
                  html: errorMessage, 
              });
          } else {
              Swal.fire({
                  icon: 'success',
                  title: 'Success',
                  text: data.message,
              }).then(() => {
                  location.reload();
              });
          }
      })
      .catch(error => {
          console.error('Error:', error);
          Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!',
          });
      });
  });
</script>
@endsection
@endsection