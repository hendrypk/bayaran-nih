@extends('_layout.main')
@section('title', 'Employees')
@section('content')

<div class="row">
  <div class="col-lg">
    <div class="card">
      <div class="card-body">
        <div class="card-header d-flex align-items-center py-0">
          <h5 class="card-title mb-0 py-3">Employee List</h5>
          @can('create employee')
            <div class="ms-auto my-auto">
              <a class="btn btn-tosca" href="{{route('employee.add')}}"><i class="ph-plus-circle me-1">Add Employee</i></a>
            </div>
          @endcan
        </div>

        <!-- Table with hoverable rows -->
        <table class="table datatable table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">EID</th>
              <th scope="col">Name</th>
              <th scope="col">Status</th>
              <th scope="col">Position</th>
              <th scope="col">Job Title</th>
              <th scope="col">Division</th>
              <th scope="col">Department</th>
              <th scope="col">Sales Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach($employee as $no=>$data)
            <tr onclick="window.open('{{ route('employee.detail', $data->id) }}', '_blank')">

              <th scope="row">{{ $no+1 }}</th>
              <td>{{ $data->eid }}</td>
              <td>{{ $data->name }}</td>
              <td>{{ $data->employeeStatus->name ?? '-' }}</td>
              <td>{{ $data->position->name ?? '-' }}</td>
              <td>{{ $data->job_title->name ?? '-' }}</td>
              <td>{{ $data->division->name ?? '-' }}</td>
              <td>{{ $data->department->name ?? '-' }}</td>
              <td>{!! $data->sales_status == 1 ? '<i class="ri-check-double-fill"></i>' : '-' !!}</td>

            </tr>
            @endforeach
          </tbody>
        </table>
        <!-- End Table with hoverable rows -->

      </div>
    </div>
  </div>
</div>

@endsection