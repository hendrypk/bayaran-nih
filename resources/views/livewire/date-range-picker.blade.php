<div class="{{$class}}">
    <button class="btn btn-untosca date-range-picker me-2 w-100" type="button" title="@lang('general.clear_date_filter')">
        <i class="icon-calendar3 me-2"></i><span></span>
    </button>
</div>

@push('scripts')
    <script>
        const allTimeYearStart = {{ $allTimeYearStart }};
        let dateRangePickerElement = $('.date-range-picker');
        document.addEventListener('DOMContentLoaded', function () {
            moment.locale($('html').attr('lang'));
            function cb(start, end) {
                // Check if "All" filter is selected
                if (start === 'all' && end === 'all') {
                    startDate = 'all';
                    endDate = 'all';
                    $(".date-range-picker span").html('{{ __('general.all') }}');
                    
                    // Dispatch to livewire with special 'all' value
                    Livewire.dispatch('dateRangeChanged', {start: 'all', end: 'all'});
                    
                    @if($updateUrl)
                    // Remove date parameters from URL
                    let url = new URL(window.location.href);
                    url.searchParams.delete('startDate');
                    url.searchParams.delete('endDate');
                    window.history.replaceState({}, '', url);
                    @endif
                    
                    return;
                }
                
                // Format validation should only happen for actual date objects, not strings
                if (typeof start !== 'string' && typeof end !== 'string') {
                    // make sure start and end is valid date format YYYY-MM-DD
                    if (!moment(start, 'YYYY-MM-DD', true).isValid() || !moment(end, 'YYYY-MM-DD', true).isValid()) {
                        alert('Invalid date format');
                        return;
                    }
                    
                    startDate = start;
                    endDate = end;
                    // check if start and end are the same then set .date-range-label to today with format D MMM YYYY, else set it to the selected range
                    if (start.format('YYYY-MM-DD') === end.format('YYYY-MM-DD')) {
                        $(".date-range-picker span").html(start.format("DD MMM YYYY"));
                    } else {
                        // check if year is same as current year then set format to D MMM, else set format to D MMM YYYY
                        if (start.format('YYYY') === moment().format('YYYY')) {
                            $(".date-range-picker span").html(start.format("DD MMM") + " - " + end.format("DD MMM YYYY"));
                        } else {
                            $(".date-range-picker span").html(start.format("DD MMM YYYY") + " - " + end.format("DD MMM YYYY"));
                        }
                    }
                    // dispatch to livewire
                    // Livewire.dispatch('dateRangeChanged', {start: start.startOf('day').format('YYYY-MM-DD HH:mm:ss'), end: end.endOf('day').format('YYYY-MM-DD HH:mm:ss')});
                    Livewire.dispatch('dateRangeChanged', {start: start.format('YYYY-MM-DD 00:00:00'), end: end.format('YYYY-MM-DD 23:59:59')});

                    @if($updateUrl)
                    // replace or add query string
                    let url = new URL(window.location.href);
                    url.searchParams.set('startDate', start.format('YYYY-MM-DD'));
                    url.searchParams.set('endDate', end.format('YYYY-MM-DD'));
                    window.history.replaceState({}, '', url);
                    @endif
                }
            }

            // set ranges from array
            let ranges = {{ json_encode($ranges) }};
            let rangesObj = {};
            let defaultRange = {{ $defaultRange }};
            let startDate, endDate, minDate, maxDate;
            @if($minDate && $minDate != 'false')
                minDate = '{{ $minDate }}';
            @else
                minDate = false
            @endif
            @if($maxDate && $maxDate != 'false')
                @if($maxDate === 'today')
                    maxDate = moment();
                @elseif($maxDate === 'week')
                    maxDate = moment().endOf('week');
                @elseif($maxDate === 'month')
                    maxDate = moment().endOf('month');
                @elseif($maxDate === 'year')
                    maxDate = moment().endOf('year');
                @else
                    maxDate = '{{ $maxDate }}';
                    // check if maxDate is not valid date format YYYY-MM-DD
                    if (!moment(maxDate, 'YYYY-MM-DD', true).isValid()) {
                        maxDate = moment();
                    }
                @endif
            @else
                @if($maxDay)
                    maxDate = moment().add({{ $maxDay }}, 'days');
                @endif
            @endif

            let dateLimit = {
                days: {{ $dateLimit }}
            };
            if (ranges.length > 0) {
                ranges.forEach(function (range) {
                    switch (range) {
                        case 1: // today
                            rangesObj['{{ __('general.today') }}'] = [moment(), moment()];
                            break;
                        case 2: // yesterday
                            rangesObj['{{ __('general.yesterday') }}'] = [moment().subtract(1, "days"), moment().subtract(1, "days")];
                            break;
                        case 3: // last 7 days
                            rangesObj['{{ __('general.last_7_days') }}'] = [moment().subtract(6, "days"), moment()];
                            break;
                        case 4: // last 30 days
                            rangesObj['{{ __('general.last_30_days') }}'] = [moment().subtract(29, "days"), moment()];
                            break;
                        case 5: // this week
                            rangesObj['{{ __('general.this_week') }}'] = [moment().startOf("week"), moment().endOf("week")];
                            break;
                        case 6: // last week
                            rangesObj['{{ __('general.last_week') }}'] = [moment().subtract(1, "week").startOf("week"), moment().subtract(1, "week").endOf("week")];
                            break;
                        case 7: // this month
                            rangesObj['{{ __('general.this_month') }}'] = [moment().startOf("month"), moment().endOf("month")];
                            break;
                        case 8: // last month
                            rangesObj['{{ __('general.last_month') }}'] = [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")];
                            break;
                        case 9: // this year
                            rangesObj['{{ __('general.this_year') }}'] = [moment().startOf("year"), moment().endOf("year")];
                            break;
                        case 10: // last year
                            rangesObj['{{ __('general.last_year') }}'] = [moment().subtract(1, "year").startOf("year"), moment().subtract(1, "year").endOf("year")];
                            break;
                        case 11: // all time
                            rangesObj['{{ __('general.all_time') }}'] = [moment(allTimeYearStart + '-01-01'), moment()];
                            break;
                        case 12: // all (no date filtering)
                            rangesObj['{{ __('general.all') }}'] = ['all', 'all'];
                            break;
                    }
                });
            }

            if ('{{ $startDate }}' && '{{ $endDate }}'){
                startDate = moment('{{ $startDate }}');
                endDate = moment('{{ $endDate }}');
                // make sure startDate is before endDate
                if (startDate.isAfter(endDate)) {
                    startDate = moment('{{ $endDate }}');
                    endDate = moment('{{ $startDate }}');
                }
            } else if (defaultRange){
                switch (defaultRange) {
                    case 1: // today
                        startDate = moment();
                        endDate = moment();
                        break;
                    case 2: // yesterday
                        startDate = moment().subtract(1, "days");
                        endDate = moment().subtract(1, "days");
                        break;
                    case 3: // last 7 days
                        startDate = moment().subtract(6, "days");
                        endDate = moment();
                        break;
                    case 4: // last 30 days
                        startDate = moment().subtract(29, "days");
                        endDate = moment();
                        break;
                    case 5: // this week
                        startDate = moment().startOf("week");
                        endDate = moment().endOf("week");
                        break;
                    case 6: // last week
                        startDate = moment().subtract(1, "week").startOf("week");
                        endDate = moment().subtract(1, "week").endOf("week");
                        break;
                    case 7: // this month
                        startDate = moment().startOf("month");
                        endDate = moment().endOf("month");
                        break;
                    case 8: // last month
                        startDate = moment().subtract(1, "month").startOf("month");
                        endDate = moment().subtract(1, "month").endOf("month");
                        break;
                    case 9: // this year
                        startDate = moment().startOf("year");
                        endDate = moment().endOf("year");
                        break;
                    case 10: // last year
                        startDate = moment().subtract(1, "year").startOf("year");
                        endDate = moment().subtract(1, "year").endOf("year");
                        break;
                    case 11: // all time
                        startDate = moment(allTimeYearStart + '-01-01');
                        endDate = moment();
                        break;
                    case 12: // all (no date filtering)
                        startDate = 'all';
                        endDate = 'all';
                        break;
                }
            } else {
                startDate = moment();
                endDate = moment();
            }

            let parentEl = '{{ $parentEl }}';

            dateRangePickerElement.daterangepicker({
                startDate: startDate,
                endDate: endDate,
                minDate: minDate,
                maxDate: maxDate,
                dateLimit: dateLimit,
                parentEl: parentEl,
                opens: 'left',
                locale: {
                    format: 'DD MMM YYYY',
                },
                ranges: rangesObj,
                autoApply: true
            }, cb);

            // Add overflow styling for scrollable date range picker
            $('.daterangepicker').css({
                'max-height': '550px',
                'overflow-y': 'auto'
            });

            // wait for all elements to be rendered before calling cb
            setTimeout(function(){
                cb(startDate, endDate);
            }, 300);

            function prevNextAction(btn){
                // get date range diff
                let diff = endDate.diff(startDate, 'days')+1;
                let s,e;
                if (btn === 'prev'){
                    // if below minDate then return
                    if (moment(startDate).subtract(diff, 'days').isBefore(minDate)) {
                        return;
                    }
                    s = moment(startDate).subtract(diff, 'days');
                    e = moment(endDate).subtract(diff, 'days');
                } else if (btn === 'next'){
                    // if above maxDate then return
                    if (moment(endDate).add(diff, 'days').isAfter(maxDate)) {
                        return;
                    }
                    s = moment(startDate).add(diff, 'days');
                    e = moment(endDate).add(diff, 'days');
                } else {
                    return;
                }
                dateRangePickerElement.data('daterangepicker').setStartDate(s);
                dateRangePickerElement.data('daterangepicker').setEndDate(e);
                cb(s, e);
            }

            @if($listenKeydown)
            // livewire handle keydown
            $(document).on('keydown', function (event) {
                // keydown left arrow
                if (event.keyCode === 37) {
                    prevNextAction('prev')
                } else if (event.keyCode === 39) { // keydown right arrow
                    prevNextAction('next')
                }
            });
            @endif

            Livewire.on('dateRangePrevNext', function (btn) {
                prevNextAction(btn)
            });
        })

    </script>
@endpush
