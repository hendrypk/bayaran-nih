@extends('_layout.main')
@section('title', 'Presence Summary')
@section('content')
    <form action="" method="POST">
        @csrf
        <h1>Work Schedule</h1>

        @foreach(['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'] as $day)
            <div class="day-schedule">
                <label for="{{ $day }}-holiday">{{ ucfirst($day) }}</label>
                <input type="checkbox" id="{{ $day }}-holiday" name="{{ $day }}_holiday" value="1" {{ old($day . '_holiday') ? 'checked' : '' }}>
                <label for="{{ $day }}-holiday">Holiday</label>
                <br>
                <label for="{{ $day }}-start">Start Time:</label>
                <input type="time" id="{{ $day }}-start" name="{{ $day }}_start" {{ old($day . '_holiday') ? 'disabled' : '' }} value="{{ old($day . '_start') }}">
                <label for="{{ $day }}-end">End Time:</label>
                <input type="time" id="{{ $day }}-end" name="{{ $day }}_end" {{ old($day . '_holiday') ? 'disabled' : '' }} value="{{ old($day . '_end') }}">
                <br><br>
            </div>
        @endforeach

        <button type="submit">Save Schedule</button>
    </form>

@section('script')
    <script>
        $(document).ready(function() {
            // Disable time inputs if the holiday checkbox is checked
            $('input[type=checkbox]').on('change', function() {
                var day = $(this).attr('id').split('-')[0];
                var isHoliday = $(this).is(':checked');
                $('#' + day + '-start').prop('disabled', isHoliday);
                $('#' + day + '-end').prop('disabled', isHoliday);
            });
        });
    </script>

@endsection
@endsection