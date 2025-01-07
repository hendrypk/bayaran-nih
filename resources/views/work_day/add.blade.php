 <div class="modal fade" id="addWorkDay" tabindex="-1" aria-labelledby="modalWorkDay" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="addWorkDayTitle">{{ __('option.label.add_new_work_day') }}</h5>
                <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="true"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('workDay.create') }}" method="POST">
                    @csrf
                    <div class="form-group row mb-3 container">
                        <div class="col-md-5">
                            <label for="name" class="fw-bold">{{ __('general.label.name') }}</label>
                            <span style="color: red; font-size: 15px;">*</span>
                        </div>
                        <div class="col-md">
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row mb-3 container">
                        <div class="col-md-5">
                            <label for="tolerance" class="fw-bold">{{ __('option.label.tolerance_in_minute') }}</label>
                        </div>
                        <div class="col-md">
                            <input type="number" id="tolerance" name="tolerance" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row container">
                        <table class="table table-striped table-bordered ">
                            <thead class="content-align-center">
                                <th>{{ __('general.label.day') }}</th>
                                <th>{{ __('option.label.day_off') }}</th>
                                <th>{{ __('option.label.arrival') }}<span style="color: red; font-size: 15px;">*</span></th>
                                <th>{{ __('option.label.check_in') }}<span style="color: red; font-size: 15px;">*</span></th>
                                <th>{{ __('option.label.check_out') }}<span style="color: red; font-size: 15px;">*</span></th>
                                <th>{{ __('option.label.break_in') }}<span style="color: red; font-size: 15px;">*</span></th>
                                <th>{{ __('option.label.break_out') }}<span style="color: red; font-size: 15px;">*</span></th>
                                <th>{{ __('option.label.exclude_break') }}</th>
                            </thead>
                            @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                            <tbody>
                                <td>{{ __('option.label.day.' . strtolower($day)) }}</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="dayOff[{{ $day }}]" name="dayOff[{{ $day }}]" value="1" onchange="toggleTimeInputs('{{ $day }}')">
                                    </div>
                                </td>
                                <td>
                                    <input type="time" class="form-control" id="arrival[{{ $day }}]" name="arrival[{{ $day }}]">
                                </td>
                                <td>
                                    <input type="time" class="form-control" id="checkIn[{{ $day }}]" name="checkIn[{{ $day }}]">
                                </td>
                                <td>
                                    <input type="time" class="form-control" id="checkOut[{{ $day }}]" name="checkOut[{{ $day }}]">
                                </td>
                                <td>
                                    <input type="time" class="form-control" id="breakIn[{{ $day }}]" name="breakIn[{{ $day }}]">
                                </td>
                                <td>
                                    <input type="time" class="form-control" id="breakOut[{{ $day }}]" name="breakOut[{{ $day }}]">
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="break[{{ $day }}]" name="break[{{ $day }}]" value="1">
                                    </div>
                                </td>
                            </tbody>
                            @endforeach
                        </table>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-tosca me-3" data-bs-dismiss="modal">{{ __('general.label.cancel') }}</button>
                        <button type="submit" name="action" class="btn btn-untosca me-3">{{ __('general.label.save') }}</button>
                      </div>
                </form>
            </div>

        </div>
    </div>
</div>

</script>
