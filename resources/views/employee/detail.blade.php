@extends('_layout.main')
@section('title', 'Employees')
@section('content')
{{ Breadcrumbs::render('employee_detail', $employee) }}
<div class="row align-item-center">
    <div class="col-md-9">
        <h3 class="card-title mb-0 py-3">Employee Detail | {{ $employee->name }}</h3>
    </div>

    <div class="col-md-3 d-flex justify-content-end">
        @can('update employee')
        <a href="{{ route('employee.edit', $employee->id) }}" class="btn btn-tosca btn-sm d-flex justify-content-center align-items-center me-2">
            <i class="ri-edit-line"></i>
        </a>
        @endcan
        
        @can('delete employee')
        <button type="button" class="btn btn-red btn-sm" 
            onclick="confirmDelete({{ $employee->id }}, '{{ $employee->name }}', 'employee')">
            <i class="ri-delete-bin-fill"></i>
        </button>
        @endcan
    </div>
</div>

<div class="row">
    <div class="col-md-2 mt-3">
        <div class="card card-body">
            <div class="align-items-start">
                <div class="nav flex-column nav-pills mt-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#biodata" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">{{ __('employee.label.biodata') }}</button>
                    <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#staffing" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">{{ __('employee.label.staffing') }}</button>
                    <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#career" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">{{ __('employee.label.career') }}</button>
                    <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#performance" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">{{ __('sidebar.label.performance') }}</button>
                    <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#payslip" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">{{ __('employee.label.payslip') }}</button>
                    <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#account" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">{{ __('employee.label.account') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-10 mt-3">
        <div class="card card-body">
            <div class="align-items-start">
                <div class="tab-content" id="v-pills-tabContent">

                    <div class="tab-pane fade show active" id="biodata" role="tabpanel" aria-labelledby="v-pills-home-tab">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="card-title">{{ __('employee.label.biodata') }}</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-4 label ">{{ __('employee.label.eid') }}</div>
                            <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->eid }}</div>
                            <div class="col-lg-4 col-md-4 label ">{{ __('employee.label.full_name') }}</div>
                            <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->name }}</div>
                            <div class="col-lg-4 col-md-4 label ">{{ __('employee.label.place_and_date_of_birth') }}</div>
                            <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->place_birth }}, {{ \Carbon\Carbon::parse($employee->date_birth)->format('d F Y') }}</div>
                            <div class="col-lg-4 col-md-4 label ">{{ __('employee.label.current_address') }}</div>
                            <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->domicile }}</div>
                            <div class="col-lg-4 col-md-4 label ">{{ __('employee.label.blood_type') }}</div>
                            <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->blood_type }}</div>
                            <div class="col-lg-4 col-md-4 label ">{{ __('employee.label.gender') }}</div>
                            <div class="col-lg-8 col-md-8"><span>: </span>{{ __('employee.options.gender.' . $employee->gender) }}</div>
                            <div class="col-lg-4 col-md-4 label ">{{ __('employee.label.religion') }}</div>
                            <div class="col-lg-8 col-md-8"><span>: </span>{{ __('employee.options.religion.' . $employee->religion) }}</div>
                            <div class="col-lg-4 col-md-4 label ">{{ __('employee.label.marital_status') }}</div>
                            <div class="col-lg-8 col-md-8"><span>: </span>{{ __('employee.options.marital_status.' . $employee->marriage) }}</div>
                            <div class="col-lg-4 col-md-4 label ">{{ __('employee.label.education') }}</div>
                            <div class="col-lg-8 col-md-8"><span>: </span>{{ __('employee.options.education.' . $employee->education) }}</div>
                            <div class="col-lg-4 col-md-4 label ">{{ __('employee.label.whatsapp') }}</div>
                            <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->whatsapp }}</div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="staffing" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                        <div class="row">
                                <div class="col-md-10">
                                    <div class="card-title">{{ __('employee.label.staffing') }}</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 label ">{{ __('employee.label.position') }}</div>
                                <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->position->name }}</div>
                                <div class="col-lg-4 col-md-4 label ">{{ __('employee.label.job_title') }}</div>
                                <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->position->job_title->name ?? '-' }}</div>
                                <div class="col-lg-4 col-md-4 label ">{{ __('employee.label.division') }}</div>
                                <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->position->division->name ?? '-' }}</div>
                                <div class="col-lg-4 col-md-4 label ">{{ __('employee.label.department') }}</div>
                                <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->position->department->name ?? '-' }}</div>
                                <div class="col-lg-4 col-md-4 label ">{{ __('employee.label.joining_date') }}</div>
                                <div class="col-lg-8 col-md-8"><span>: </span>{{ \Carbon\Carbon::parse($employee->joining_date)->format('d F Y') }}</div>
                                <div class="col-lg-4 col-md-4 label">{{ __('employee.label.work_schedule') }}</div>
                                <div class="col-lg-8 col-md-8">
                                    <span>: </span>
                                    @if($employee->workDay->isEmpty())
                                        <span>No Schedule</span>
                                    @else
                                        @foreach($employee->workDay as $index => $workDay)
                                            {{ $workDay->name }}@if(!$loop->last), @endif
                                        @endforeach
                                    @endif
                                </div>  
                                <div class="col-lg-4 col-md-4 label">{{ __('employee.label.office_location') }}</div>
                                <div class="col-lg-8 col-md-8">
                                    <span>: </span>
                                    @if($employee->officeLocations->isEmpty())
                                        <span>No Location</span>
                                    @else
                                        @foreach($employee->officeLocations as $index => $officeLocations)
                                            {{ $officeLocations->name }}@if(!$loop->last), @endif
                                        @endforeach
                                    @endif
                                </div>  
                                <div class="col-lg-4 col-md-4 label ">{{ __('employee.label.employee_status') }}</div>
                                <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->employeeStatus->name }}</div>
                                <div class="col-lg-4 col-md-4 label ">{{ __('employee.label.sales_status') }}</div>
                                <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->sales_status == 1 ? 'Yes' : 'No' }}</div>
                                <div class="col-lg-4 col-md-4 label ">{{ __('employee.label.kpi') }}</div>
                                <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->kpis->name ?? '-' }}</div>
                                <div class="col-lg-4 col-md-4 label ">{{ __('employee.label.kpi_weight') }}</div>
                                <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->bobot_kpi ?? '-' }}</div>
                                <div class="col-lg-4 col-md-4 label ">{{ __('employee.label.appraisal') }}</div>
                                <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->pas->name ?? '-' }}</div>
                                <div class="col-lg-4 col-md-4 label ">{{ __('employee.label.work_duration') }}</div>
                                <div class="col-lg-8 col-md-8"><span>: </span>{{ $years }} {{ __('general.label.years') }} {{ $months }} {{ __('general.label.months') }} {{ $days }} {{ __('general.label.days') }}</div>
                            </div>
                    </div>

                    <div class="tab-pane fade" id="career" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="card-title">{{ __('employee.label.career') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="performance" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="card-title">{{ __('sidebar.label.performance') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="payslip" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="card-title">{{ __('employee.label.payslip') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="account" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                        <div class="row mb-3">
                            <div class="col-md-10">
                                <div class="card-title">{{ __('employee.label.account') }}</div>
                            </div>
                        </div>
                        <form action="{{ route('employee.account.reset', $employee->id) }}" method="POST" id="resetUsernamePassword">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-lg-2 col-md-3 col-sm-2">
                                    <label for="username">{{ __('employee.label.username') }}</label>
                                </div>
                                <div class="col-lg-4 col-md-3 col-sm-2">
                                    <input type="text" name="username" class="input-form" value="{{ $employee->username }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-2 col-md-3 col-sm-2">
                                    <label for="password">{{ __('employee.label.password') }}</label>
                                </div>
                                <div class="col-lg-4 col-md-3 col-sm-2">
                                    <input id="password" class="input-form" type="password" name="password">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="">
                                    <button type="submit" class="btn btn-tosca">{{ __('general.label.update') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <a href="{{ route('employee.list') }}" class="btn btn-untosca mt-3">{{ __('general.label.back') }}</a> --}}

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      const entity = button.getAttribute('data-entity'); // e.g., 'position', 'department', etc.
      const id = button.getAttribute('data-id'); // Entity ID
      const name = button.getAttribute('data-name'); // Entity name (optional)
      
      // Update modal title and body text
      const entityNameElement = document.getElementById('entityName');
      entityNameElement.textContent = entity;
      
      // Update form action URL
      const form = document.getElementById('deleteForm');
      form.action = `/${entity}/${id}/delete`;

      // Optionally update the modal title to include the entity's name
      const modalTitle = document.getElementById('deleteModalLabel');
      modalTitle.textContent = `Delete ${entity.charAt(0).toUpperCase() + entity.slice(1)}: ${name} on ${date}`;
    });
  });

  $('#resetUsernamePassword').submit(function(e) {
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
                    // confirmButtonText: 'OK'
                    timer: 2000, // Auto close after 2 seconds
                    showConfirmButton: false 
                }).then(() => {
                    window.location.href = "{{ route('employee.detail', ['id' => $employee->id]) }}";
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

function confirmDelete(id, name, entity) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to delete the " + entity + ": " + name,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '',
            cancelButtonColor: '',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/${entity}/${id}/delete`, { 
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: data.message, // Use message from the server
                            icon: 'success'
                        }).then(() => {
                            // Reload the page or redirect to another route
                            window.location.href = data.redirect; // Redirect to the desired route
                        });
                    } else {
                        Swal.fire('Error!', data.message || 'Something went wrong. Try again later.', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error!', 'Failed to delete. Please try again.', 'error');
                    console.error('There was a problem with the fetch operation:', error);
                });
            }
        });
    }
</script>
@endsection

@endsection

@include('modal.delete')