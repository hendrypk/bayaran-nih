@extends('_layout.main')
@section('title', 'Performance - PA Detail')
@section('content')

{{-- {{ Breadcrumbs::render('pa_detail', $employee, $selectedMonth, $selectedYear) }} --}}
{{ Breadcrumbs::render('pa_detail', $employees, $month, $year) }}

<div class="row align-item-center mb-3">
    <div class="col-md-9">
        <h5 class="card-title mb-0 py-3">Appraisal Detail for {{ $employees->name }} | {{ $month ?? 'All Months' }} {{ $year ?? 'All Years' }}</h5>
    </div>
    <div class="col-md-3 d-flex justify-content-end">
        <a href="{{ route('pa.edit', ['employee_id' => $employees->id, 'month' => $month, 'year' => $year]) }}" class="btn btn-tosca btn-sm me-2">
            <i class="ri-edit-line"></i>
        </a>
        <button type="button" class="btn btn-untosca btn-sm" 
            onclick="confirmDelete('{{ $employees->id }}', '{{ $month }}', '{{ $year }}', '{{ $employees->name }}', 'Appraisal')">
            <i class="ri-delete-bin-fill"></i>
        </button>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">Employee Information</div>
                <div class="row mb-2">
                    <div class="col-4 fw-bold">EID</div>
                    <div class="col-8">: {{ $employees->eid }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-4 fw-bold">Nama</div>
                    <div class="col-8">: {{ $employees->name }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-4 fw-bold">Job Title</div>
                    <div class="col-8">: {{ $employees->job_title->name }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-4 fw-bold">Position</div>
                    <div class="col-8">: {{ $employees->position->name }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-4 fw-bold">Division</div>
                    <div class="col-8">: {{ $employees->division->name }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-4 fw-bold">Department</div>
                    <div class="col-8">: {{ $employees->department->name }}</div>
                </div>                
                
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    PA Achievement
                </div>
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Aspect</th>
                            <th scope="col">Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gradePas as $gradePa)
                            <tr>
                                <td>{{ $gradePa->appraisal->aspect }}</td>
                                <td>{{ $gradePa->grade }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Total</th>
                            <th>{{$totalGrade}}</th>
                        </tr>
                        <tr>
                            <th>Final Grade</th>
                            <th>{{$avgGrade}}</th>
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
//Delete Modal
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
            fetch(`/appraisal/${id}/${month}/${year}/delete`, { 
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