@extends('_layout.main')
@section('title', $isEditing ? 'Edit KPI' : 'Add KPI')
@section('content')
{{ Breadcrumbs::render('kpi.form', $isEditing ?? false, $id ?? null) }}

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <livewire:kpi-form :kpiId="$id ?? null" />
            </div>
        </div>
    </div>
</div>
@endsection