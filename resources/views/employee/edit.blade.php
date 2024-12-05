@extends('_layout.main')
@section('title', 'Employees')
@section('content')

<div class="row">
  <div class="col-lg">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Edit Employee</h5>

        <!-- General Form Elements -->
         <form action="{{route('employee.update', $employee->id)}}" id="editEmployee" method="POST">
          @csrf
          <div class="row mb-3">
            <label for="inputEmail" class="col-sm-4 col-form-label">Full Name</label>
            <div class="col-sm-8">
              <input type="name" name="name" value="{{old('name', $employee->name)}}" class="form-control" required>
            </div>
          </div>

          <div class="row mb-3">
            <label for="city" class="col-sm-4 col-form-label">Identity Address</label>
            <div class="col-sm-8">
              <input type="text" name="city" value="{{old('city', $employee->city)}}" class="form-control" required>
            </div>
          </div>

          <div class="row mb-3">
            <label for="domicile" class="col-sm-4 col-form-label">Current Address</label>
            <div class="col-sm-8">
              <input type="text" name="domicile" value="{{old('domicile', $employee->domicile)}}" class="form-control" required>
            </div>
          </div>

          <div class="row mb-3">
            <label for="place_birth" class="col-sm-4 col-form-label">Place of Birth</label>
            <div class="col-sm-8">
              <input type="text" name="place_birth" value="{{old('place_birth', $employee->place_birth)}}" class="form-control" required>
            </div>
          </div>

          <div class="row mb-3">
            <label for="date_birth" class="col-sm-4 col-form-label">Date of Birth</label>
            <div class="col-sm-8">
              <input type="date" name="date_birth" value="{{old('date_birth', $employee->date_birth)}}" class="form-control" required>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-4 col-form-label">Blood Type</label>
            <div class="col-sm-8">
              <select class="form-select" name="blood_type" aria-label="Default select example">
                <option selected disabled>- Select Blood Type -</option>
                @foreach($bloods as $blood)
                <option value="{{ $blood }}" {{ $blood == $employee->blood_type ? 'selected' : '' }}>{{ $blood }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-4 col-form-label">Gender</label>
            <div class="col-sm-8">
              <select class="form-select" name="gender" aria-label="Default select example" required>
                <option selected disabled>- Select Gender -</option>
                @foreach($genders as $gender)
                <option value="{{ $gender }}" {{ $gender == $employee->gender ? 'selected' : '' }}>{{ $gender }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-4 col-form-label">Religion</label>
            <div class="col-sm-8">
              <select class="form-select" name="religion" aria-label="Default select example" required>
                <option selected disabled>- Select Religion -</option>
                @foreach($religions as $religion)
                <option value="{{ $religion }}" {{ $religion == $employee->religion ? 'selected' : '' }}>{{ $religion }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-4 col-form-label">Marrital Status</label>
            <div class="col-sm-8">
              <select class="form-select" name="marriage" aria-label="Default select example" required>
                <option selected disabled>- Select Marrital Status -</option>
                @foreach($marriage as $marriage)
                <option value="{{ $marriage }}" {{ $marriage == $employee->marriage ? 'selected' : '' }}>{{ $marriage }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-4 col-form-label">Education</label>
            <div class="col-sm-8">
              <select class="form-select" name="education" aria-label="Default select example" required>
                <option selected disabled>- Select Education -</option>
                @foreach($educations as $education)
                <option value="{{ $education }}" {{ $education == $employee->education ? 'selected' : '' }}>{{ $education }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label for="inputEmail" class="col-sm-4 col-form-label">email</label>
            <div class="col-sm-8">
              <input type="email" name="email" value="{{old('email', $employee->email)}}" class="form-control" required>
            </div>
          </div>
          
          <div class="row mb-3">
            <label for="whatsapp" class="col-sm-4 col-form-label">WhatsApp Number</label>
            <div class="col-sm-8">
              <input type="number" name="whatsapp" value="{{old('whatsapp', $employee->whatsapp)}}" class="form-control" required>
            </div>
          </div>
          
          <div class="row mb-3">
            <label class="col-sm-4 col-form-label">Bank</label>
            <div class="col-sm-8">
              <select class="form-select" name="bank" aria-label="Default select example">
                <option selected value="">- Select Bank -</option>
                @foreach($banks as $bank)
                <option value="{{ $bank }}" {{ $bank == $employee->bank ? 'selected' : '' }}>{{ $bank }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label for="whatsapp" class="col-sm-4 col-form-label">Bank Number</label>
            <div class="col-sm-8">
              <input type="number" name="bank_number" value="{{old('bank_number', $employee->bank_number)}}"  class="form-control">
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-4 col-form-label">Position</label>
            <div class="col-sm-8">
              <select class="form-select" name="position_id" aria-label="Default select example" required>
                <option selected value="">Select position</option>
                @foreach($position as $data)
                <option value="{{ $data->id }}" {{ $data->name == $employee->position->name ? 'selected' : '' }}>{{ $data->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          
          <div class="row mb-3">
            <label class="col-sm-4 col-form-label">Job Title</label>
            <div class="col-sm-8">
              <select class="form-select" name="job_title_id" aria-label="Default select example" required>
                <option selected value="">Select Job Title</option>
                @foreach($job_title as $data)
                <option value="{{ $data->id }}" {{ $data->name == $employee->job_title->name ? 'selected' : '' }}>{{ $data->name }}</option>

                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-4 col-form-label">Division</label>
            <div class="col-sm-8">
              <select class="form-select" name="division_id" aria-label="Default select example">
                <option selected value ="">Select Division</option>
                @foreach($division as $data)
                <option value="{{ $data->id }}" {{ !is_null($employee->division) && $data->name == $employee->division->name ? 'selected' : '' }}>{{ $data->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-4 col-form-label">Department</label>
            <div class="col-sm-8">
              <select class="form-select" name="department_id" aria-label="Default select example">
                <option selected value="">Select Department</option>
                @foreach($department as $data)
                <option value="{{ $data->id }}" {{ !is_null($employee->department) && $data->name == $employee->department->name ? 'selected' : '' }}>{{ $data->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label for="inputDate" class="col-sm-4 col-form-label">Joining Date</label>
            <div class="col-sm-8">
              <input type="date" name="joining_date" class="form-control" value="{{ old('joining_date', $employee->joining_date )}}" required>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-4 col-form-label">Work Schedule</label>
            <div class="col-sm-8">    
                @foreach($workDay as $data)       
                <div class="form-check">
                    <input class="form-check-input" 
                          type="checkbox" 
                          id="workDay{{ $data->id }}" 
                          name="workDay[]" 
                          value="{{ $data->id }}"
                          {{ $employee->workDay && $employee->workDay->contains($data->id) ? 'checked' : '' }} @required(true)>
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
                  <input class="form-check-input" 
                        type="checkbox" 
                        id="officeLocations{{ $data->id }}" 
                        name="officeLocations[]" 
                        value="{{ $data->id }}"
                        {{ $employee->officeLocations && $employee->officeLocations->contains($data->id) ? 'checked' : '' }} @required(true)>
                  <label class="form-check-label" for="officeLocations{{ $data->id }}">
                      {{ $data->name }}
                  </label>
              </div>
              @endforeach
          </div>
      </div>


          <div class="row mb-3">
            <label class="col-sm-4 col-form-label">Employee Status</label>
            <div class="col-sm-8">
              <select class="form-select" name="employee_status" aria-label="Default select example" required>
                <option disabled>Select Status</option>
                @foreach($status as $data)
                <option value="{{ $data->id }}" {{ $data->name == $employee->employee_status ? 'selected' : '' }}>{{ $data->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-4 col-form-label">Sales Status</label>
            <div class="col-sm-8">
              <select class="form-select" name="sales_status" aria-label="Default select example" required>
                <option disabled>Select Status</option>
                <option value="1" {{ $employee->sales_status == '1' ? 'selected' : '' }}>Yes</option>
                <option value="0"{{ $employee->sales_status == '0' ? 'selected' : '' }}>No</option>
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-4 col-form-label">Appraisal</label>
            <div class="col-sm-8">
              <select class="form-select" name="pa_id" aria-label="Default select example">
                <option value="" selected>Select Appraisal</option>
                @foreach($pa_id as $data)
                <option value="{{ $data->id }}" {{ $data->id == $employee->pa_id ? 'selected' : '' }}>{{ $data->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-4 col-form-label">KPI</label>
            <div class="col-sm-8">
              <select class="form-select" name="kpi_id" aria-label="Default select example">
                <option value="" selected>Select KPI</option>
                @foreach($kpi_id as $data)
                <option value="{{ $data->id }}" {{ $data->id == $employee->kpi_id ? 'selected' : '' }}>{{ $data->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label for="inputCity" class="col-sm-4 col-form-label">Bobot KPI</label>
            <div class="col-sm-8">
              <input type="number" min="0"  name="bobot_kpi" class="form-control" value="{{ old('bobot_kpi', $employee->bobot_kpi )}}" >
            </div>
          </div>
          
          <div class="d-flex justify-content-between">
            <!-- <div class="row justify-content-end"> -->
              <div class="">
                <a href="{{ url()->previous() }}" class="btn btn-untosca mt-3">Back</a>
              </div>
              <div class="">
                <button type="submit" class="btn btn-tosca">Update Employee</button>
              </div>
            </div>
          <!-- </div>-->
        </form>
        <!-- End General Form Elements -->
      </div>
    </div>
  </div>
</div>
@endsection