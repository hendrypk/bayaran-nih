@extends('_layout.main')
@section('title', 'Performance - KKPI')
@section('content')

<div class="row">
<x-month-year-picker :action="route('kpi.list')" :selectedMonth="$selectedMonth" :selectedYear="$selectedYear" />

    <div class="col-md">
        <div class="card">
            <div class="card-body">
                <div class="card-header d-flex align-items-center py-0">
                    <h5 class="card-title mb-0 py-3">Key Performance Indicator</h5>
                    @can('create kpi')
                        <div class="ms-auto my-auto">
                            <a class="btn btn-tosca" href="{{ route('kpi.add') }}"><i class="ph-plus-circle me-1">Add KPI Report</i></a>
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
                                <th scope="col">KPI Grade</th>
                                <th scope="col">View</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($gradeKpi as $no=>$gradeKpi)
                            <tr>
                                <th scope="row">{{ $no+1 }}</th>
                                <td>{{ $gradeKpi->month }}</td>
                                <td>{{ $gradeKpi->year }}</td>
                                <td>{{ $gradeKpi->employee_id }}</td>
                                <td>{{ $gradeKpi->employees->name }}</td>
                                <td> -> Coming Soon <- </td>
                                <td>
                                    <a href="{{ route('kpi.detail', [
                                    'employee_id' => $gradeKpi->employee_id,
                                    'month' => $gradeKpi->month,
                                    'year' => $gradeKpi->year]) }}" class="btn btn-outline-primary">
                                    <i class="ri-eye-fill"></i>
                                    </a>
                                </td>
                                <td>
                                    @can('edit kpi')
                                        <a href="{{ route('kpi.edit', [
                                            'employee_id' => $gradeKpi->employee_id,
                                            'month' => $gradeKpi->month,
                                            'year' => $gradeKpi->year
                                            ]) }}" class="btn btn-outline-success">
                                            <i class="ri-edit-line"></i>
                                        </a>
                                    @endcan
                                </td>
                                <td>
                                    @can('delete kpi')
                                        <button type="button" class="btn btn-outline-danger" 
                                            onclick="confirmDelete({{ $gradeKpi->employee_id }}, '{{ $gradeKpi->month }}', '{{ $gradeKpi->year }}', '{{ $gradeKpi->employees->name }}', 'KPI')">
                                            <i class="ri-delete-bin-fill"></i>
                                        </button>
                                    @endcan
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

@include('modal.delete')

@endsection