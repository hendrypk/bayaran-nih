@extends('_layout.main')
@section('title', 'Performance - KPI Detail')
@section('content')

{{-- {{ Breadcrumbs::render('kpi_detail', $kpi->name) }} --}}

<div class="row align-item-center mb-3">
    <div class="col md-9">
        <h3 class="card-title mb-0 py-3">{{ __('performance.label.kpi_detail') }} {{ $kpi->month }} {{ $kpi->year }}</h3>
    </div>
    
    <div class="col-md-3 d-flex justify-content-end">
        @can('update employee')
        <a href="{{ route('kpi.edit', [
            'id' => $kpi->id,
            ]) }}" class="btn btn-tosca btn-sm d-flex justify-content-center align-items-center me-2">
            <i class="ri-edit-line"></i>
        </a>
        @endcan
        
        @can('delete employee')
        <button type="button" class="btn btn-red btn-sm" 
            onclick="confirmDelete({{ $kpi->id }}, '{{ $kpi->month }}', '{{ $kpi->year }}', '{{ $kpi->employees->name }}', 'KPI')">
            <i class="ri-delete-bin-fill"></i>
        </button>
        @endcan
    </div>
</div>

<div class="row mb-3">
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">{{ __('performance.label.employee_information') }}</div>
                {{-- <div class="col-lg-8"> --}}
                    <div class="row mb-2">
                        <div class="col-lg-4 fw-bold"> {{ __('employee.label.eid') }} </div>
                        <div class="col">: {{ $employee->eid }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-4 fw-bold"> {{ __('general.label.name') }} </div>
                        <div class="col">: {{ $employee->name }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-4 fw-bold"> {{ __('employee.label.job_title') }} </div>
                        <div class="col">: {{ $employee->position->job_title->name }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-4 fw-bold"> {{ __('employee.label.position') }} </div>
                        <div class="col">: {{ $employee->position->name }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-4 fw-bold"> {{ __('employee.label.division') }} </div>
                        <div class="col">: {{ $employee->division->name ?? '-' }}</div>
                    </div>
                    <div class="row mb-2    ">
                        <div class="col-lg-4 fw-bold"> {{ __('employee.label.department') }} </div>
                        <div class="col">: {{ $employee->department->name ?? '-' }}</div>
                    </div>
                {{-- </div> --}}
            </div>
        </div>
     </div>


      <!-- Display KPI Details -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title"> {{ __('performance.label.kpi_achievement') }} {{ $kpi->kpiName->name }}</div>
                <div class="small">
                    <div class="d-flex">
                        <span class="fw-bold" style="width:120px;">@lang('general.label.created_by')</span>
                        @php
                            if ($kpi->user_created) {
                                $creator = $kpi->creator->name;
                                $created_at = $kpi->created_at;
                            } else {
                                $creator = '';
                                $created_at = '';
                            }
                        @endphp
                        <span>: {{ $creator ?: '-' }} / {{ $created_at ?: '-' }}</span>
                    </div>
                    <div class="d-flex">
                        <span class="fw-bold" style="width:120px;">@lang('general.label.updated_by')</span>
                        @php
                            if ($kpi->user_updated) {
                                $updater = $kpi->updater->name;
                                $updated_at = $kpi->updated_at;
                            } else {
                                $updater = '';
                                $updated_at = '';
                            }
                        @endphp
                        <span>: {{ $updater ?: '-' }} / {{ $updated_at ?: '-' }}</span>
                    </div>
                </div>
            </div>
            <div class="card-body">
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%;">No</th>
                            <th class="text-center" style="width: 40%;">{{ __('performance.label.aspect') }}</th>
                            <th class="text-center" style="width: 40%;">{{ __('performance.label.description') }}</th>
                            <th class="text-center" style="width: 15%;">{{ __('performance.label.target') }}</th>
                            <th class="text-center" style="width: 15%;">{{ __('performance.label.unit') }}</th>
                            <th class="text-center" style="width: 15%;">{{ __('performance.label.weight') }}</th>
                            <th class="text-center" style="width: 15%;">{{ __('performance.label.achievement') }}</th>
                            <th class="text-center" style="width: 15%;">{{ __('performance.label.grade') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kpi->details as $no=>$gradeKpi)
                            <tr>
                                <td class="text-center">{{ $no+1 }}</td>
                                <td>{{ $gradeKpi->aspect }}</td>
                                <td>{{ $gradeKpi->description }}</td>
                                <td class="text-center">{{ number_format($gradeKpi->target, 2, '.', ',') }}</td>
                                <td class="text-center">{{ $gradeKpi->unit }}</td>
                                <td class="text-center">{{ number_format($gradeKpi->weight, 2, '.', ',') }}</td>
                                <td class="text-end">{{ number_format($gradeKpi->achievement, 2, '.', ',') }}</td>
                                <td class="text-center">{{ number_format($gradeKpi->result, 2, '.', ',') }}</td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="7">{{ __('performance.label.final_grade') }}</th>
                            <th class="text-center">{{$kpi->grade}}</th>
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
            fetch(`/kpi/${id}/delete`, { 
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