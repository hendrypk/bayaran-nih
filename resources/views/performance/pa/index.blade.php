@extends('_layout.main')
@section('title', 'Performance - PA')
@section('content')

{{ Breadcrumbs::render('pa') }}
<div class="row">
    <div class="col-md-9">
        <x-month-year-picker :action="route('pa.list')" :selectedMonth="$selectedMonth" :selectedYear="$selectedYear"/>
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
                @livewire('pa-datatable', [
                    'month' => request('month', date('n')),
                    'year' => request('year', date('Y'))])
            </div>
        </div>
    </div>
</div>

@endsection