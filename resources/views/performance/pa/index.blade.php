@extends('_layout.main')
@section('title', 'Performance - PA')
@section('content')

{{ Breadcrumbs::render('pa') }}
<div class="row">
    <div class="col-md-9">
        <x-month-year-picker :action="route('kpi.list')" :selectedMonth="$selectedMonth" :selectedYear="$selectedYear"/>
    </div>
    <div class="col-md-3 d-flex justify-content-end">
        @can('create kpi')
        <div class="ms-auto my-auto">
            <x-modal-trigger
                class="btn btn-tosca"
                title="{{ __('performance.label.add_new_employee_appraisal') }}"
                modal="pa-form"
                size="xl">
                <i class="ri-add-circle-line"></i>
            </x-modal-trigger>
        </div>
        @endcan
    </div>
</div>

<div class="row">
    <div class="col-md">
        <div class="card">
            <div class="card-body">
                <div class="card-header d-flex align-items-center py-0">
                    <h5 class="card-title mb-0 py-3">{{ __('performance.label.employee_appraisal') }}</h5>
                </div>
                @livewire('pa-datatable', ['month' => request('month', date('F')), 'year' => request('year', date('Y'))])

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