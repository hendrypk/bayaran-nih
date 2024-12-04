@extends('_layout.main')
@section('title', 'Employees')
@section('content')

<h3 class="card-title mb-0 py-3">Employee Detail | {{ $employee->name }}</h3>

<div class="row">
    <div class="col-md-2 mt-3">
        <div class="card card-body">
            <div class="align-items-start">
                <div class="nav flex-column nav-pills me-3 mt-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#biodata" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Biodata</button>
                    <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#staffing" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Staffing</button>
                    <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Paslip</button>
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
                                <div class="card-title">Employee Detail</div>
                            </div>
                            @can('update employee')
                                <div class="col-md ms-auto align-self-center">
                                    <a href="{{ route('employee.edit', $employee->id) }}" class="btn btn-outline-success">
                                        <i class="ri-edit-line"></i>
                                    </a>
                                </div>
                            @endcan

                            @can('delete employee')
                            <div class="col-md ms-auto align-self-center">
                                <button type="button" class="btn btn-outline-danger"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteModal" 
                                    data-entity="employee" 
                                    data-id="{{ $employee->id }}" 
                                    data-name="{{ $employee->name }}">
                                    <i class="ri-delete-bin-fill"></i>
                                </button>
                            </div>
                            @endcan
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-4 label ">Employee ID</div>
                            <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->eid }}</div>
                            <div class="col-lg-4 col-md-4 label ">Full Name</div>
                            <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->name }}</div>
                            <div class="col-lg-4 col-md-4 label ">Place and Date Birth</div>
                            <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->place_birth }}, {{ \Carbon\Carbon::parse($employee->date_birth)->format('d F Y') }}</div>
                            <div class="col-lg-4 col-md-4 label ">Domicile</div>
                            <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->domicile }}</div>
                            <div class="col-lg-4 col-md-4 label ">Blood Type</div>
                            <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->blood_type }}</div>
                            <div class="col-lg-4 col-md-4 label ">Gender</div>
                            <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->gender }}</div>
                            <div class="col-lg-4 col-md-4 label ">Religion</div>
                            <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->religion }}</div>
                            <div class="col-lg-4 col-md-4 label ">Marrital</div>
                            <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->marriage }}</div>
                            <div class="col-lg-4 col-md-4 label ">Education</div>
                            <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->education }}</div>
                            <div class="col-lg-4 col-md-4 label ">Whatssapp</div>
                            <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->whatsapp }}</div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="staffing" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                        <div class="row">
                                <div class="col-md-10">
                                    <div class="card-title">Staffing Detail</div>
                                </div>
                                <div class="col-md ms-auto align-self-center">
                                    <a href="{{ route('employee.edit', $employee->id) }}" class="btn btn-outline-success">
                                        <i class="ri-edit-line"></i>
                                    </a>
                                </div>
                                <div class="col-md ms-auto align-self-center">
                                    <button type="button" class="btn btn-outline-danger"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal" 
                                        data-entity="employee" 
                                        data-id="{{ $employee->id }}" 
                                        data-name="{{ $employee->name }}">
                                        <i class="ri-delete-bin-fill"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 label ">Full Name</div>
                                <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->name }}</div>
                                <div class="col-lg-4 col-md-4 label ">Employee ID</div>
                                <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->eid }}</div>
                                <div class="col-lg-4 col-md-4 label ">Position</div>
                                <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->position->name ?? '-' }}</div>
                                <div class="col-lg-4 col-md-4 label ">Job Title</div>
                                <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->job_title->name ?? '-' }}</div>
                                <div class="col-lg-4 col-md-4 label ">Division</div>
                                <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->division->name ?? '-' }}</div>
                                <div class="col-lg-4 col-md-4 label ">Department</div>
                                <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->department->name ?? '-' }}</div>
                                <div class="col-lg-4 col-md-4 label ">Joining Date</div>
                                <div class="col-lg-8 col-md-8"><span>: </span>{{ \Carbon\Carbon::parse($employee->joining_date)->format('d F Y') }}</div>
                                <div class="col-lg-4 col-md-4 label">Work Schedule</div>
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
                                <div class="col-lg-4 col-md-4 label">Office Locatin</div>
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
                                <div class="col-lg-4 col-md-4 label ">Employee Status</div>
                                <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->employeeStatus->name }}</div>
                                <div class="col-lg-4 col-md-4 label ">Sales Status</div>
                                <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->sales_status == 1 ? 'Yes' : 'No' }}</div>
                                <div class="col-lg-4 col-md-4 label ">KPI</div>
                                <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->kpis->name ?? '-' }}</div>
                                <div class="col-lg-4 col-md-4 label ">Bobot KPI</div>
                                <div class="col-lg-8 col-md-8"><span>: </span>{{ $employee->bobot_kpi ?? '-' }}</div>
                                <div class="col-lg-4 col-md-4 label ">Masa Kerja</div>
                                <div class="col-lg-8 col-md-8"><span>: </span>{{ $years }} tahun {{ $months }} bulan {{ $days }} hari</div>
                            </div>
                    </div>

                    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<a href="{{ route('employee.list') }}" class="btn btn-untosca mt-3">Back</a>

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
</script>
@endsection

@endsection

@include('modal.delete')