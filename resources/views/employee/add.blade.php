@extends('_layout.main')
@section('title', 'Employees')
@section('content')

<div class="row">
  <div class="col-lg">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Add Employee</h5>

        <!-- General Form Elements -->
         <form action="{{route('employee.submit')}}" method="POST">
          @csrf
          <!-- <div class="row mb-3">
            <label for="inputText" class="col-sm-4 col-form-label" required>Employee ID</label>
            <div class="col-sm-8">
              <input type="id" name="eid" class="form-control">
            </div>
          </div> -->
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

          <div class="d-flex justify-content-between">
              <div class="">
                <a href="{{ route('employee.list') }}" class="btn btn-untosca mt-3">Back</a>
              </div>
              <div class="">
                <button type="submit" class="btn btn-tosca">Add Employee</button>
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