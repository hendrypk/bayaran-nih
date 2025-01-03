@extends('_layout.main')
@section('title', 'Performance - KPI Detail')
@section('content')

{{ Breadcrumbs::render('kpi_detail', $gradeKpi->first()) }}

<div class="row align-item-center mb-3">
    <div class="col md-9">
        <h3 class="card-title mb-0 py-3">KPI Details for {{ $month ?? 'All Months' }} {{ $year ?? 'All Years' }}</h3>
    </div>
    
    <div class="col-md-3 d-flex justify-content-end">
        @can('update employee')
        <a href="{{ route('kpi.edit', [
            'employee_id' => $employees->id,
            'month' => $month,
            'year' => $year
            ]) }}" class="btn btn-tosca btn-sm d-flex justify-content-center align-items-center me-2">
            <i class="ri-edit-line"></i>
        </a>
        @endcan
        
        @can('delete employee')
        <button type="button" class="btn btn-untosca btn-sm" 
            onclick="confirmDelete({{ $employees->id }}, '{{ $month }}', '{{ $year }}', '{{ $employees->name }}', 'KPI')">
            <i class="ri-delete-bin-fill"></i>
        </button>
        @endcan
    </div>
</div>

<div class="row mb-3    ">
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">Employee Information</div>
                {{-- <div class="col-lg-8"> --}}
                    <div class="row mb-2">
                        <div class="col-lg-4 fw-bold"> EID </div>
                        <div class="col">: {{ $employees->eid }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-4 fw-bold"> Nama </div>
                        <div class="col">: {{ $employees->name }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-4 fw-bold"> Job Title </div>
                        <div class="col">: {{ $employees->job_title->name }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-4 fw-bold"> Position </div>
                        <div class="col">: {{ $employees->position->name }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-4 fw-bold"> Division </div>
                        <div class="col">: {{ $employees->division->name ?? '-' }}</div>
                    </div>
                    <div class="row mb-2    ">
                        <div class="col-lg-4 fw-bold"> Department </div>
                        <div class="col">: {{ $employees->department->name ?? '-' }}</div>
                    </div>
                {{-- </div> --}}
            </div>
        </div>
     </div>


      <!-- Display KPI Details -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    KPI Achievement
                </div>
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%;">No</th>
                            <th class="text-center" style="width: 40%;">Aspect</th>
                            <th class="text-center" style="width: 15%;">Target</th>
                            <th class="text-center" style="width: 15%;">Bobot</th>
                            <th class="text-center" style="width: 15%;">Achievement</th>
                            <th class="text-center" style="width: 15%;">Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gradeKpi as $no=>$gradeKpi)
                            <tr>
                                <td class="text-center">{{ $no+1 }}</td>
                                <td>{{ $gradeKpi->indicator->aspect }}</td>
                                <td class="text-center">{{ number_format($gradeKpi->indicator->target, 2, '.', ',') }}</td>
                                <td class="text-center">{{ number_format($gradeKpi->indicator->bobot, 2, '.', ',') }}</td>
                                <td class="text-end">{{ number_format($gradeKpi->achievement, 2, '.', ',') }}</td>
                                <td class="text-center">{{ number_format($gradeKpi->grade, 2, '.', ',') }}</td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5">Final Grade</th>
                            <th class="text-center">{{$totalGrade}}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
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