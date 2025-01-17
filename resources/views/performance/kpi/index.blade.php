@extends('_layout.main')
@section('title', 'Performance - KKPI')
@section('content')

{{ Breadcrumbs::render('kpi') }}
<div class="row">
    <div class="col-md-9">
        <x-month-year-picker :action="route('kpi.list')" :selectedMonth="$selectedMonth" :selectedYear="$selectedYear"/>
    </div>
    <div class="col-md-3 d-flex justify-content-end">
        @can('create kpi')
        <div class="ms-auto my-auto">
            <a class="btn btn-tosca" href="{{ route('kpi.add') }}">
                <i class="ri-add-circle-line"></i></a>
        </div>
        @endcan
    </div>
</div>

<div class="row">
    <div class="col-md">
        <div class="card">
            <div class="card-body">
                <div class="row align-item-center">
                    <div class="col-md-9">
                        <h5 class="card-title mb-0 py-3">{{ __('sidebar.label.kpi') }}</h5>
                    </div>
                </div>

        
                <!-- Table with hoverable rows -->
                    <table class="table datatable table-hover">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">#</th>
                                <th scope="col" class="text-center">{{ __('general.label.month') }}</th>
                                <th scope="col" class="text-center">{{ __('general.label.year') }}</th>
                                <th scope="col" class="text-center">{{ __('employee.label.eid') }}</th>
                                <th scope="col" class="text-center">{{ __('general.label.name') }}</th>
                                <th scope="col" class="text-center">{{ __('performance.label.kpi_grade') }}</th>
                                <th scope="col" class="text-center">{{ __('general.label.view') }}</th>
                                {{-- <th scope="col" class="text-center">Edit</th> --}}
                                <th scope="col" class="text-center">{{ __('general.label.delete') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($gradeKpi as $no=>$gradeKpi)
                            <tr>
                                <th scope="row">{{ $no+1 }}</th>
                                <td class="text-center">{{ $gradeKpi->month }}</td>
                                <td class="text-center">{{ $gradeKpi->year }}</td>
                                <td class="text-center">{{ $gradeKpi->employees->eid }}</td>
                                <td class="text-center">{{ $gradeKpi->employees->name }}</td>
                                <td class="text-center">{{ number_format($gradeKpi->final_kpi, 2, '.', ',') }}</td>

                                <td class="text-center">
                                    <a href="{{ route('kpi.detail', [
                                    'employee_id' => $gradeKpi->employee_id,
                                    'month' => $gradeKpi->month,
                                    'year' => $gradeKpi->year]) }}" class="btn btn-blue">
                                    <i class="ri-eye-fill"></i>
                                    </a>
                                </td>
                                {{-- <td class="text-center">
                                    @can('edit kpi')
                                        <a href="{{ route('kpi.edit', [
                                            'employee_id' => $gradeKpi->employee_id,
                                            'month' => $gradeKpi->month,
                                            'year' => $gradeKpi->year
                                            ]) }}" class="btn btn-outline-success">
                                            <i class="ri-edit-line"></i>
                                        </a>
                                    @endcan
                                </td> --}}
                                <td class="text-center">
                                    @can('delete kpi')
                                        <button type="button" class="btn btn-red" 
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