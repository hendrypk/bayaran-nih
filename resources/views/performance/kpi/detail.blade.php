@extends('_layout.main')
@section('title', 'Performance - KPI Detail')
@section('content')

<div class="card-title">
    Appraisal Details for {{ $month ?? 'All Months' }} {{ $year ?? 'All Years' }}
</div>

<div class="row">
    <!-- Display Employee Information -->
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">Employee Information</div>
                <div class="col-lg-8">
                    <div class="row mb-2">
                        <div class="col-lg-6 fw-bold"> EID </div>
                        <div class="col">: {{ $employees->eid }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-6 fw-bold"> Nama </div>
                        <div class="col">: {{ $employees->name }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-6 fw-bold"> Job Title </div>
                        <div class="col">: {{ $employees->job_title->name }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-6 fw-bold"> Position </div>
                        <div class="col">: {{ $employees->position->name }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-6 fw-bold"> Division </div>
                        <div class="col">: {{ $employees->division }}</div>
                    </div>
                    <div class="row mb-2    ">
                        <div class="col-lg-6 fw-bold"> Department </div>
                        <div class="col">: {{ $employees->department }}</div>
                    </div>
                </div>
            </div>
        </div>
     </div>
</div>

      <!-- Display KPI Details -->
<div class="col-lg-8">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                KPI Details for {{ $month ?? 'All Months' }} {{ $year ?? 'All Years' }}
            </div>
            <div class="row mb-4">
                <div class="col-lg-1">
                    <a href="{{ route('kpi.edit', [
                        'employee_id' => $employees->id,
                        'month' => $month,
                        'year' => $year
                        ]) }}" class="btn btn-outline-success">
                        <i class="ri-edit-line"></i>
                    </a>
                </div>
                <div class="col-lg-1">
                    <a href="" class="btn btn-outline-danger"
                        data-bs-toggle="modal" 
                        data-bs-target="#deleteModal" 
                        data-entity="appraisal" 
                        data-eid="{{ $employees->id }}" 
                        data-month="{{ $month }}" 
                        data-year="{{ $year }}" ><i class="ri-delete-bin-fill"></i></a>

                            <button type="button" class="btn btn-outline-danger" 
                            onclick="confirmDelete({{ $employees->id }}, '{{ $month }}', '{{ $year }}', '{{ $employees->name }}', 'KPI')">
                            <i class="ri-delete-bin-fill"></i>
                        </button>
                </div>
            </div>
        <div class="row">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Aspect</th>
                            <th scope="col">Target</th>
                            <th scope="col">Bobot</th>
                            <th scope="col">Achievement</th>
                            <th scope="col">Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gradeKpi as $gradeKpi)
                            <tr>
                                <td>{{ $gradeKpi->indicator->aspect }}</td>
                                <td>{{ $gradeKpi->indicator->target }}</td>
                                <td>{{ $gradeKpi->indicator->bobot }}</td>
                                <td>{{ $gradeKpi->achievement }}</td>
                                <td>{{ $gradeKpi->grade }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Final Grade</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>{{$totalGrade}}</th>
                        </tr>
                    </tfoot>
                </table>
        </div>
    </div>
</div>



@include('modal.delete')
@section('script')

<script>

function confirmDelete(id, month, year, name, entity) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You are about to delete the " + entity + " " + name + " on " + month + " " + year,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '',
        cancelButtonColor: '',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/kpi/${id}/${month}/${year}/delete`, { 
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token for Laravel
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
                        text: data.message,
                        icon: 'success'
                    }).then(() => {
                        window.location.href = data.redirect;
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