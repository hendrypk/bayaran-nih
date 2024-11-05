@extends('_layout.main')
@section('title', 'Performance - PA')
@section('content')

<div class="row">
<x-month-year-picker :action="route('appraisal.list')" :selectedMonth="$selectedMonth" :selectedYear="$selectedYear" />

    <div class="col-md">
        <div class="card">
            <div class="card-body">
                <div class="card-header d-flex align-items-center py-0">
                    <h5 class="card-title mb-0 py-3">Employee Appraisal</h5>
                    @can('create pa')
                        <div class="ms-auto my-auto">
                            <button type="button" class="btn btn-tosca" data-bs-toggle="modal" data-bs-target="#addPa">Add Employee Appraisal</button>
                        </div>
                    @endcan
                </div>
        
                <!-- Table with hoverable rows -->
                    <table class="table datatable table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Month</th>
                                <th scope="col">Year</th>
                                <th scope="col">EID</th>
                                <th scope="col">Employee Name</th>
                                <th scope="col">Grade</th>
                                <th scope="col">Detail</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @foreach($averageGrades as $no=> $grade)
                                    @php
                                        $employee = $employees->firstWhere('id', $grade->employee_id);
                                    @endphp
                                <th scope="row">{{ $no+1 }}</th>
                                <td>{{ $selectedMonth }}</td>
                                <td>{{ $selectedYear }}</td>
                                <td>{{ $employee->eid }}</td>
                                <td>{{ $employee->name }}</td>  
                                <td>{{ number_format($grade->average_grade, 2) }}</td>                               
                                <td>
                                    <a href="{{ route('appraisal.detail', [
                                    'employee_id' => $employee->id,
                                    'month' => $selectedMonth,
                                    'year' => $selectedYear]) }}"
                                    class="btn btn-outline-primary">
                                    <i class="ri-eye-fill"></i>
                                    </a>
                                </td>
                                <td>
                                    @can('update pa')
                                        <a href="{{ route('appraisal.edit', [
                                            'employee_id' => $employee->id,
                                            'month' => $selectedMonth,
                                            'year' => $selectedYear]) }}"
                                            class="btn btn-outline-success">
                                            <i class="ri-edit-line"></i>
                                        </a>
                                    @endcan
                                </td>
                                <td>
                                    <button type="button" class="btn btn-outline-danger" 
                                        onclick="confirmDelete({{ $grade->employee_id }}, '{{ $selectedMonth }}', '{{ $selectedYear }}', '{{ $grade->employees->name }}', 'KPI')">
                                        <i class="ri-delete-bin-fill"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                <!-- End Table with hoverable rows -->
            </div>
        </div>
    </div>
</div>
@foreach ($averageGrades as $grade)
            @php
                $employee = $employees->firstWhere('id', $grade->employee_id);
            @endphp
            <tr>
                <td>{{ $employee->id ?? 'N/A' }}</td>
                <td>{{ $employee->name ?? 'N/A' }}</td>
                <td>{{ $selectedMonth }}</td>
                <td>{{ $selectedYear }}</td>
                <td>{{ number_format($grade->average_grade, 2) }}</td>
            </tr>
        @endforeach

@section('script')

<script>
//Script for Delete Modal
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

@include('performance.pa.add')
@include('modal.delete')
@endsection