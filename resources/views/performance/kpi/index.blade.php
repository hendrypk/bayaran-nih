@extends('_layout.main')
@section('title', 'Performance - KKPI')
@section('content')

{{ Breadcrumbs::render('kpi') }}
<div class="mb-3 d-flex justify-content-between align-items-center">
    <form action="{{ route('kpi.list') }}" method="GET">
        <div class="row d-flex align-items-end">
            <div class="col-md-5">
                <label class="form-label">{{ __('general.label.month') }}</label>
                <select class="select-form" name="month">
                    @foreach(range(1, 12) as $m)
                        @php
                            $monthName = DateTime::createFromFormat('!m', $m)->format('F');
                        @endphp
                        <option value="{{ $m }}"
                            {{ request('month', date('n')) == $m ? 'selected' : '' }}>
                            {{ $monthName }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-5">
                <label class="form-label">{{ __('general.label.year') }}</label>
                <select class="select-form" name="year">
                    @foreach(range(date('Y') - 1, date('Y') + 5) as $y)
                        <option value="{{ $y }}"
                            {{ request('year', date('Y')) == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2 align-self-end">
                <button type="submit" class="btn btn-tosca btn-sm">Filter</button>
            </div>
        </div>
    </form>
        @can('create kpi')
        <div class="ms-auto my-auto">
            <a class="btn btn-tosca" href="{{ route('kpi.add') }}">
                <i class="ri-add-circle-line"></i></a>
        </div>
        @endcan
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

                @livewire('kpi-datatable', [
                    'month' => request('month', date('n')),
                    'year'  => request('year', date('Y'))
                ])

        </div>
    </div>
</div>
@endsection