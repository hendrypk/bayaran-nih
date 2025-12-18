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
            <x-modal-trigger
                class="btn btn-tosca"
                title="{{ __('performance.label.add_new_employee_kpi') }}"
                modal="kpi-form"
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
                    <h5 class="card-title mb-0 py-3">{{ __('sidebar.label.kpi') }}</h5>
                </div>
                @livewire('kpi-datatable', [
                    'month' => request('month', date('n')),
                    'year'  => request('year', date('Y'))
                ])
            </div>
        </div>
    </div>
</div>
@endsection