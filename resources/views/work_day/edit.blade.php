@extends('_layout.main')
@section('title', 'Edit Work Day')
@section('content')
{{ Breadcrumbs::render('work_day_detail', $name) }}

<div class="row">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <h5 class="card-title">{{ __('option.label.edit_work_day') }} {{ $workDays->name }}</h5>
                </div>
            </div> 
                 
            <form action="{{ route('workDay.update', $workDays->id) }}" method="POST">
                @csrf
                @method('POST')

                <div class="form-group row mb-3 container">
                    <div class="col-md-3">
                        <label for="name" class="fw-bold">{{ __('general.label.name') }}</label>
                        <span style="color: red; font-size: 15px;">*</span>
                    </div>
                    <div class="col-md-3">
                        <label for="tolerance" class="fw-bold">{{ __('option.label.tolerance_in_minute') }}</label>
                    </div>

                    <div class="col-md-3">
                        <label for="tolerance" class="fw-bold">{{ __('option.label.count_late') }}</label>
                    </div>
                </div>
                <div class="form-group row mb-3 container">
                    <div class="col-md-3">
                        <input type="text" class="input-form" name="name" value="{{ $workDays->name }}">
                    </div>
                    <div class="col-md-3">
                        <input type="number" class="input-form" name="tolerance" value="{{ $workDays->tolerance }}">
                    </div>
                    <div class="col-md-3">
                        <select class="select-form" name="countLate" aria-label="Default select example">
                            <option selected disabled>{{ __('employee.placeholders.select_status') }}</option>
                            <option value="1" {{ $workDays->count_late == '1' ? 'selected' : '' }}>Yes</option>
                            <option value="0"{{ $workDays->count_late == '0' ? 'selected' : '' }}>No</option>
                          </select>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <table class="table table-hover">
                        <thead class="table-primary">
                            <th>{{ __('general.label.day') }}</th>
                            <th>{{ __('option.label.day_off') }}</th>
                            <th>{{ __('option.label.arrival') }}</th>
                            <th>{{ __('option.label.check_in') }}</th>
                            <th>{{ __('option.label.check_out') }}</th>
                            <th>{{ __('option.label.break_in') }}</th>
                            <th>{{ __('option.label.break_out') }}</th>
                            <th>{{ __('option.label.exclude_break') }}</th>
                        </thead>
                        <tbody>
                            @foreach($workDays->days as $workDay)
                                <tr>
                                    <td class="text-center">{{ __('option.label.day.' . strtolower($workDay->day)) }}</td>
                                    <td class="text-center">
                                        <div class="form-check form-switch">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <input class="form-check-input" type="checkbox" id="{{ $workDay->day }}-dayOff" name="dayOff[{{ $workDay->day }}]" value="1" {{ $workDay->day_off == 1 ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <input type="time" id="{{ $workDay->day }}-arrival" class="input-form text-center" name="arrival[{{ $workDay->day }}]" value="{{ $workDay->arrival }}" {{ $workDay->day_off == 1 ? 'disabled' : '' }}>
                                    </td>
                                    <td class="text-center">
                                        <input type="time" id="{{ $workDay->day }}-checkIn" class="input-form text-center" name="checkIn[{{ $workDay->day }}]" value="{{ $workDay->start_time }}" {{ $workDay->day_off == 1 ? 'disabled' : '' }}>
                                    </td>
                                    <td class="text-center">
                                        <input type="time" id="{{ $workDay->day }}-checkOut" class="input-form text-center" name="checkOut[{{ $workDay->day }}]" value="{{ $workDay->end_time }}" {{ $workDay->day_off == 1 ? 'disabled' : '' }}>
                                    </td>
                                    <td class="text-center">
                                        <input type="time" id="{{ $workDay->day }}-breakIn" class="input-form text-center" name="breakIn[{{ $workDay->day }}]" value="{{ $workDay->break_start }}" {{ $workDay->day_off == 1 ? 'disabled' : '' }}>
                                    </td>
                                    <td class="text-center">
                                        <input type="time" id="{{ $workDay->day }}-breakOut" class="input-form text-center" name="breakOut[{{ $workDay->day }}]" value="{{ $workDay->break_end }}" {{ $workDay->day_off == 1 ? 'disabled' : '' }}>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check form-switch">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <input class="form-check-input" type="checkbox" name="break[{{ $workDay->day }}]" value="1" {{ $workDay->break == 1 ? 'checked' : '' }} {{ $workDay->day_off == 1 ? 'disabled' : '' }}>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="row mb-2 mt-3 justify-content-end">
                        <div class="d-grid col-1">
                            <a href="{{ route('workDay.index') }}" class="btn btn-red btn-sm">{{ __('general.label.back') }}</a>
                        </div>
                        <div class="d-grid col-1">
                            <button type="submit" class="btn btn-tosca btn-sm">{{ __('general.label.save') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@section('script')
<script>document.addEventListener('DOMContentLoaded', function () {
    // Define the function globally
    function toggleTimeInputs(day) {
        const isDayOff = document.querySelector(`input[id="${day}-dayOff"]`).checked;

        document.querySelector(`input[id="${day}-arrival"]`).disabled = isDayOff;
        document.querySelector(`input[id="${day}-checkIn"]`).disabled = isDayOff;
        document.querySelector(`input[id="${day}-checkOut"]`).disabled = isDayOff;
        document.querySelector(`input[id="${day}-breakIn"]`).disabled = isDayOff;
        document.querySelector(`input[id="${day}-breakOut"]`).disabled = isDayOff;
        document.querySelectorAll(`input[name="break[${day}]"]`).forEach(radio => radio.disabled = isDayOff);
    }

    // Bind change event for all checkboxes
    document.querySelectorAll('input[type=checkbox]').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const day = checkbox.id.split('-')[0]; // Extract the day from the checkbox ID
            toggleTimeInputs(day); // Call the function on checkbox change
        });

        // Trigger change event on page load to set the initial state
        checkbox.dispatchEvent(new Event('change'));
    });
});

    
</script>
@endsection

@endsection
