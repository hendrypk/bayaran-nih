@extends('_layout.main')
@section('title', 'Performance - PA Detail')
@section('content')

<div class="card-title">
    Appraisal Details for {{ $month ?? 'All Months' }} {{ $year ?? 'All Years' }}
</div>

    <!-- Display Employee Information -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="card-title">Employee Information</div>
            <div class="col-lg-4">
                <div class="row mb-2">
                    <div class="col-4 fw-bold"> EID </div>
                    <div class="col">: {{ $employees->eid }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-4 fw-bold"> Nama </div>
                    <div class="col">: {{ $employees->name }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-4 fw-bold"> Job Title </div>
                    <div class="col">: {{ $employees->job_title->name }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-4 fw-bold"> Position </div>
                    <div class="col">: {{ $employees->position->name }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-4 fw-bold"> Division </div>
                    <div class="col">: {{ $employees->division->name }}</div>
                </div>
                <div class="row mb-2    ">
                    <div class="col-4 fw-bold"> Department </div>
                    <div class="col">: {{ $employees->department->name }}</div>
                </div>
            </div>
        </div>
    </div>

      <!-- Display Appraisal Details -->
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                Appraisal Details for {{ $month ?? 'All Months' }} {{ $year ?? 'All Years' }}
            </div>
            <div class="row mb-4">
                <div class="col-md-1">
                    <a href="{{ route('pa.edit', ['employee_id' => $employees->id, 'month' => $month, 'year' => $year]) }}" class="btn btn-outline-success">
                        <i class="ri-edit-line"></i></a>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-outline-danger" 
                    onclick="confirmDelete('{{ $employees->id }}', '{{ $month }}', '{{ $year }}', '{{ $employees->name }}', 'Appraisal')">
                    <i class="ri-delete-bin-fill"></i>
                </button>
                </div>
            </div>
        <div class="row">
            @if ($gradePas->isEmpty())
                <p>No appraisal records found for the given criteria.</p>
            @else
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
            @endif
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