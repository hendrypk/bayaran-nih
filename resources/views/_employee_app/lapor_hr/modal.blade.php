<!-- Add Modal Position -->
@extends('_employee_app._layout_employee.main')
@section('header.title', 'Lapor HR')
@include('_employee_app._layout_employee.header')
@section('header')
<div class="appHeader blue text-light">
        <div class="left">
            <a href="{{ route('employee.app') }}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle"> {{ Auth::user()->name }} Apply Leave </div>
        <div class="right"></div>
    </div>
@endsection

@section('content')
<div class="presence">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('laporHrSubmit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="report_id">
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">{{ __('general.label.report_date') }}</label>
                    <div class="col-sm-9">
                        <input type="date" name="report_date" class="form-control" id="report_date">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">{{ __('general.label.report_category') }}</label>
                    <div class="col-sm-9">
                        <select class="select-form" name="report_category" aria-label="Default select example">
                            <option selected disabled>{{ __('general.label.select_category') }}</option>
                            @foreach($reportCategory as $data)
                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">{{ __('general.label.report_description') }}</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="report_description" id="report_description" cols="30" rows="3"></textarea>
                    </div>
                </div>  

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">{{ __('general.label.report_attachment') }}</label>
                    <div class="col-sm-9 d-flex align-items-center">
                        <input type="file" name="report_attachment[]" multiple class="form-control">
                    </div>
                </div>  
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-tosca me-3" data-bs-dismiss="modal">{{ __('general.label.cancel') }}</button>
                    <button type="submit" class="btn btn-untosca">{{ __('general.label.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<div class="modal fade" id="modalLaporHr" tabindex="-1" aria-labelledby="modalLaporHr" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLaporHr">{{ __('general.label.edit_lapor_hr') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>

