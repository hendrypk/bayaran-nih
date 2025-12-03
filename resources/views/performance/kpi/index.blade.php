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
                @livewire('kpi-datatable', ['month' => request('month', date('F')), 'year' => request('year', date('Y'))])
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