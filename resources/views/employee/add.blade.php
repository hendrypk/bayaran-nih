@extends('_layout.main')
@section('title', __('sidebar.label.add_employee'))
@section('content')


{{ Breadcrumbs::render('add_employee') }}
<div class="row">
  <div class="col-lg">
    <div class="card">
      <div class="card-body">            
        <div class="container">
          <h5 class="card-title mt-3">{{ __('sidebar.label.add_employee') }}</h5>
      <form action="{{route('employee.submit')}}" method="POST" id="addEmployee">
        @csrf
              
        <div class="row mt-10"></div>
          <div class="row mb-3">
            <label for="name" class="col-sm-2 col-form-label">{{ __('employee.label.full_name') }}</label>
            <div class="col-sm-8">
              <input type="name" name="name" class="input-form">
            </div>
          </div>

          <div class="row mb-3">
            <label for="city" class="col-sm-2 col-form-label">{{ __('employee.label.identity_address') }}</label>
            <div class="col-sm-8">
              <textarea name="city" id="city" cols="96" rows="3" class="input-form"></textarea>
            </div>
          </div>

          <div class="row mb-3">
            <label for="domicile" class="col-sm-2 col-form-label">{{ __('employee.label.current_address') }}</label>
            <div class="col-sm-8">
              <textarea name="domicile" id="domicile" cols="96" rows="3" class="input-form"></textarea>
            </div>
          </div>

          <div class="row mb-3">
            <label for="place_birth" class="col-sm-2 col-form-label">{{ __('employee.label.place_of_birth') }}</label>
            <div class="col-sm-8">
              <input type="text" name="place_birth" class="input-form">
            </div>
          </div>

          <div class="row mb-3">
            <label for="date_birth" class="col-sm-2 col-form-label">{{ __('employee.label.date_of_birth') }}</label>
            <div class="col-sm-8">
              <input type="date" name="date_birth" class="input-form">
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label">{{ __('employee.label.blood_type') }}</label>
            <div class="col-sm-8">
              <select class="select-form" name="blood_type" aria-label="Default select example">
                <option selected disabled>{{ __('employee.placeholders.select_blood_type') }}</option>
                @foreach($bloods as $blood)
                <option value="{{ $blood }}">{{ $blood }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label">{{ __('employee.label.gender') }}</label>
            <div class="col-sm-8">
              <select name="gender" id="gender" class="input-form">
                <option selected disabled>{{ __('employee.placeholders.select_gender') }}</option>
                @foreach (__('employee.options.gender') as $value => $label)
                    <option value="{{ $value }}">
                        {{ $label }}
                    </option>
                @endforeach
              </select>
              {{-- <select class="form-select" name="gender" aria-label="Default select example">
                <option selected disabled>{{ __('employee.placeholders.select_gender') }}</option>
                @foreach($genders as $gender)
                <option value="{{ $gender }}">{{ $gender }}</option>
                @endforeach
              </select> --}}
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label">{{ __('employee.label.religion') }}</label>
            <div class="col-sm-8">
              <select name="religion" id="religion" class="input-form">
                <option selected disabled>{{ __('employee.placeholders.select_religion') }}</option>
                @foreach (__('employee.options.religion') as $value => $label)
                    <option value="{{ $value }}">
                        {{ $label }}
                    </option>
                @endforeach
              </select>

              {{-- <select class="form-select" name="religion" aria-label="Default select example">
                <option selected disabled>{{ __('employee.placeholders.select_religion') }}</option>
                @foreach($religions as $religion)
                <option value="{{ $religion }}">{{ $religion }}</option>
                @endforeach
              </select> --}}
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label">{{ __('employee.label.marital_status') }}</label>
            <div class="col-sm-8">
              <select name="marriage" id="marriage" class="input-form">
                <option selected disabled>{{ __('employee.placeholders.select_marital_status') }}</option>
                @foreach (__('employee.options.marital_status') as $value => $label)
                    <option value="{{ $value }}">
                        {{ $label }}
                    </option>
                @endforeach
              </select>
              {{-- <select class="form-select" name="marriage" aria-label="Default select example">
                <option selected disabled>{{ __('employee.placeholders.select_marital_status') }}</option>
                @foreach($marriage as $marriage)
                <option value="{{ $marriage }}">{{ $marriage }}</option>
                @endforeach
              </select> --}}
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label">{{ __('employee.label.education') }}</label>
            <div class="col-sm-8">
              <select name="education" id="education" class="input-form">
                <option selected disabled>{{ __('employee.placeholders.select_education') }}</option>
                @foreach (__('employee.options.education') as $value => $label)
                    <option value="{{ $value }}">
                        {{ $label }}
                    </option>
                @endforeach
              </select>
              {{-- <select name="education" class="input-form">
                <option selected disabled>{{ __('employee.placeholders.select_education') }}</option>
                @foreach($educations as $education)
                  <option value="{{ $education }}">{{ $education }}</option>
                @endforeach
            </select> --}}
            
              {{-- <select class="form-select" name="education" aria-label="Default select example">
                <option selected disabled>{{ __('employee.placeholders.select_education') }}</option>
                @foreach($educations as $education)
                <option value="{{ $education }}">{{ __('employee.education.' . $education) }}</option>
                @endforeach
              </select> --}}
            </div>
          </div>

          <div class="row mb-3">
            <label for="inputEmail" class="col-sm-2 col-form-label">{{ __('employee.label.email') }}</label>
            <div class="col-sm-8">
              <input type="email" name="email" class="input-form">
            </div>
          </div>

          <div class="row mb-3">
            <label for="whatsapp" class="col-sm-2 col-form-label">{{ __('employee.label.whatsapp') }}</label>
            <div class="col-sm-8">
              <input type="number" name="whatsapp" class="input-form">
            </div>
          </div>
          
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label">{{ __('employee.label.bank') }}</label>
            <div class="col-sm-8">
              <select class="form-select" name="bank" aria-label="Default select example">
                <option selected disabled>{{ __('employee.placeholders.select_bank') }}</option>
                @foreach($banks as $bank)
                <option value="{{ $bank }}">{{ $bank }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label for="whatsapp" class="col-sm-2 col-form-label">{{ __('employee.label.bank_number') }}</label>
            <div class="col-sm-8">
              <input type="number" name="bank_number" class="input-form">
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label">{{ __('employee.label.position') }}</label>
            <div class="col-sm-8">
              <select class="form-select" name="position_id" aria-label="Default select example">
                <option selected disabled>{{ __('employee.placeholders.select_position') }}</option>
                @foreach($position as $data)
                <option value="{{ $data->id }}">{{ $data->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
{{--           
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label">{{ __('employee.label.job_title') }}</label>
            <div class="col-sm-8">
              <select class="form-select" name="job_title_id" aria-label="Default select example">
                <option selected disabled>{{ __('employee.placeholders.select_job_title') }}</option>
                @foreach($job_title as $data)
                <option value="{{ $data->id }}">{{ $data->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label">{{ __('employee.label.division') }}</label>
            <div class="col-sm-8">
              <select class="form-select" name="division_id" aria-label="Default select example">
                <option selected disabled>{{ __('employee.placeholders.select_division') }}</option>
                @foreach($division as $data)
                <option value="{{ $data->id }}">{{ $data->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label">{{ __('employee.label.department') }}</label>
            <div class="col-sm-8">
              <select class="form-select" name="department_id" aria-label="Default select example">
                <option selected disabled>{{ __('employee.placeholders.select_department') }}</option>
                @foreach($department as $data)
                <option value="{{ $data->id }}">{{ $data->name }}</option>
                @endforeach
              </select>
            </div>
          </div> --}}

          <div class="row mb-3">
            <label for="inputDate" class="col-sm-2 col-form-label">{{ __('employee.label.joining_date') }}</label>
            <div class="col-sm-8">
              <input type="date" name="joining_date" class="input-form" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label">{{ __('employee.label.work_schedule') }}</label>
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
            <label class="col-sm-2 col-form-label">{{ __('employee.label.office_location') }}</label>
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
            <label class="col-sm-2 col-form-label">{{ __('employee.label.employee_status') }}</label>
            <div class="col-sm-8">
              <select class="form-select" name="employee_status" aria-label="Default select example">
                <option selected disabled>{{ __('employee.placeholders.select_status') }}</option>
                @foreach($status as $data)
                <option value="{{ $data->id }}">{{ $data->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label">{{ __('employee.label.sales_status') }}</label>
            <div class="col-sm-8">
              <select class="form-select" name="sales_status" aria-label="Default select example">
                <option selected disabled>{{ __('employee.placeholders.select_status') }}</option>
                <option value="1">Yes</option>
                <option selected value="0">No</option>
              </select>
            </div>
          </div>
          
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label">{{ __('employee.label.appraisal') }}</label>
            <div class="col-sm-8">
              <select class="form-select" name="pa_id" aria-label="Default select example">
                <option value="" selected>{{ __('employee.placeholders.select_appraisal') }}</option>
                @foreach($pa_id as $data)
                <option value="{{ $data->id }}">{{ $data->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label">{{ __('employee.label.kpi') }}</label>
            <div class="col-sm-8">
              <select class="form-select" name="kpi_id" aria-label="Default select example">
                <option value="" selected>{{ __('employee.placeholders.select_kpi') }}</option>
                @foreach($kpi_id as $data)
                <option value="{{ $data->id }}">{{ $data->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label for="inputCity" class="col-sm-2 col-form-label">{{ __('employee.label.kpi_weight') }}</label>
            <div class="col-sm-8">
              <input type="number" min="0"  name="bobot_kpi" class="input-form">
            </div>
          </div>

          <div class="d-flex justify-content-end">
            <div class="">
              <a href="{{ url()->previous() }}" class="btn btn-tosca me-3">
                  {{ __('general.label.cancel') }}
              </a>
            </div>
            <div class="">
              <button type="submit" class="btn btn-untosca">{{ __('sidebar.label.add_employee') }}</button>
            </div>
          </div>

        </form>
        </div>
      </div>
    </div>
  </div>
</div>

@section('script')
<script>
// document.querySelector('form').addEventListener('submit', (event) => {
//     const selectedWorkDays = [...document.querySelectorAll('input[name="workDay[]"]:checked')]
// });

// document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
//         checkbox.addEventListener('change', () => {
//             const selectedValues = [...document.querySelectorAll('input[type="checkbox"]:checked')]
//         });
//     });
$('#addEmployee').submit(function(e) {
    e.preventDefault(); 
    
    var form = $(this);
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    title: 'Success!',
                    text: response.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = "{{ route('employee.list') }}";
                });
            }
        },
        error: function(xhr) {
            // Handle error case
            if (xhr.status === 422) {
                // Validation error
                var errors = xhr.responseJSON.errors;
                var errorMessages = '';
                
                // Loop through validation errors and append them to a string
                for (var field in errors) {
                    if (errors.hasOwnProperty(field)) {
                        errorMessages += errors[field].join(', ') + '\n';
                    }
                }

                // Show SweetAlert with error messages
                Swal.fire({
                    title: 'Error!',
                    text: errorMessages || 'Something went wrong.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            } else {
                // Show generic error message for other issues
                Swal.fire({
                    title: 'Error!',
                    text: xhr.responseJSON?.message || 'Something went wrong.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        }
    });
});
</script>

@endsection
@endsection