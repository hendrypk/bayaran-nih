@php
    use Carbon\Carbon;
    $defaultStartDate = $startDate ?? Carbon::now()->startOfMonth()->format('Y-m-d');
    $defaultEndDate = $endDate ?? Carbon::now()->endOfDay()->format('Y-m-d');
    $today = Carbon::now()->endOfDay()->format('Y-m-d');
@endphp

<form method="GET" action="{{ $action }}" class="mb-3">
    <div class="row d-flex align-items-end">
        <div class="col-md-2">
            <label for="start_date" class="form-label">{{ __('general.label.start_date') }}</label>
            <input type="date" id="start_date" name="start_date" class="form-control" value="{{ $defaultStartDate }}" max="{{ $today }}">
        </div>
        <div class="col-md-2">
            <label for="end_date" class="form-label">{{ __('general.label.end_date') }}</label>
            <input type="date" id="end_date" name="end_date" class="form-control" value="{{ $defaultEndDate }}">
        </div>
        <div class="col-md-2">
            <label for="date_type" class="form-label">{{ __('general.label.filter_by') }}</label>
            <select name="date_type" class="form-control">
                <option value="created_at" {{ request('date_type') == 'created_at' ? 'selected' : '' }}>{{ __('attendance.label.apply_date') }}</option>
                <option value="date" {{ request('date_type') == 'date' ? 'selected' : '' }}>{{ __('attendance.label.absence_date') }}</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-tosca btn-sm">Filter</button>
        </div>


    </div>
</form>