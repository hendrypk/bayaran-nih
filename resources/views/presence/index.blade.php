@extends('_layout.main')
@section('title', __('sidebar.label.presences'))
@section('content')


{{ Breadcrumbs::render('presence') }}
<div class="row align-items-center mb-3">
        <div class="mb-2 d-xl-flex justify-content-between">
            <div class="d-grid gap-2">
                <div class="d-flex gap-2 align-items-center">
                    <div class="form-control-feedback form-control-feedback-start w-75">
                        <input type="text" class="form-control form-control-sm" id="search" placeholder="Search...">
                        <div class="form-control-feedback-icon form-control-feedback-icon-sm">
                            <i class="ph-magnifying-glass ph-sm"></i>
                        </div>
                    </div>
                    <select class="form-select form-select-sm w-50" id="status">
                        <option value="" selected>All</option>
                        <option value="presence" selected>Presence</option>
                        <option value="leave">Leave</option>
                        <option value="sick">Sick</option>
                        <option value="permit">Permit</option>
                        <option value="absence">Absence</option>
                    </select>
                    <select class="form-select form-select-sm w-25" id="page_length">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
            <div class="ms-auto d-grid gap-2">

                <livewire:date-range-picker :ranges="[1,2,7,8,3,4,9,10,11]" :defaultRange="7" :updateUrl="true" :dateLimit="360"
                                            :maxDate="0" startDate="{{ app('request')->input('startDate') }}"
                                            endDate="{{ app('request')->input('endDate') }}"/>
                <div class="d-flex gap-2 justify-content-end">
                    <button id="downloadExcel" class="btn btn-tosca btn-sm d-flex align-items-center gap-1">
                        <i class="ri-download-cloud-2-fill"></i>
                        <span>{{ __('general.label.export') }}</span>
                    </button>

                    {{-- @can('presence export')
                        <form action="{{ route('presence.export') }}" method="POST" class="m-0">
                            @csrf
                            <input type="hidden" id="exportStart" name="start_date" value="{{ request()->get('start_date') }}">
                            <input type="hidden" id="exportEnd" name="end_date" value="{{ request()->get('end_date') }}">
                            <input type="hidden" id="exportStatus" name="status" value="{{ request()->get('status') }}">
                        
                            <button type="submit" class="btn btn-tosca btn-sm d-flex align-items-center gap-1">
                                <i class="ri-download-cloud-2-fill"></i>
                                <span>{{ __('general.label.export') }}</span>
                            </button>
                        </form>
                    @endcan --}}

                    <a href="{{ route('presence.import') }}" 
                    class="btn btn-tosca btn-sm d-flex align-items-center gap-1">
                        <i class="ri-file-upload-fill"></i>
                        <span>{{ __('general.label.import') }}</span>
                    </a>
                    @can('create presence')
                    <x-modal-trigger
                        class="btn btn-tosca"
                        title="{{ __('attendance.label.add_manual_presence') }}"
                        modal="presence-manual-modal"
                        size="lg">
                        <i class="ri-add-circle-line"></i>
                    </x-modal-trigger>
                    @endcan
                </div>
                
            </div>
        </div>
    </div>
</div>
<div class="content-container">

    <div class="row">
            <div class="col-md">
            <div class="card">
                <div class="card-body">
                    <div class="card-header d-flex align-items-center py-0">
                        <div class="col-md-9">
                            <h5 class="card-title mb-0 py-3">{{ __('attendance.label.presence_list') }}</h5>
                        </div>
                    </div>
                    <div class="card-table-wrapper"> 
                        {!! $p->table(['id' => 'presence_table','class'=>'table table-responsive'], false) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
    {!! $p->scripts() !!}
        <script>
        let startDate = '{{ app('request')->input('startDate') }}';
        let endDate = '{{ app('request')->input('endDate') }}';
        let search = '{{ app('request')->input('search') }}';
        let status = '{{ app('request')->input('status') }}';
        document.addEventListener('DOMContentLoaded', function () {
            Livewire.on('dateRangeChanged', ({start, end}) => {
                startDate = start;
                endDate = end;
                console.log();
                // check if datatable is initialized
                if ($.fn.DataTable.isDataTable('#presence_table')) {
                    // reload datatable
                    $('#presence_table').DataTable().ajax.reload();
                }
            });
        });
        $(document).ready(function () {
            if (!status) status = '';            // set status select option selected based on query string
            $('#status').val(status);
            // set search input value based on query string
            $('#search').val(search);
            if (search !== '') {
                // apply datatable search based on query string
                $('#presence_table').DataTable().search(search).draw();
            }

            $('#search').on('keyup', function () {
                // replace url with new query string
                let url = new URL(window.location.href);
                url.searchParams.set('search', this.value);
                window.history.replaceState({}, '', url);
                $('#presence_table').DataTable().search(this.value).draw();
            });
            $('#page_length').on('change', function () {
                $('#presence_table').DataTable().page.len(this.value).draw();
            });
            $('#status').on('change', function () {
                status = this.value;
                // replace url with new query string
                let url = new URL(window.location.href);
                url.searchParams.set('status', status);
                window.history.replaceState({}, '', url);
                $('#presence_table').DataTable().ajax.reload();
                dispatchFilters();
            });
            $(document).on('click', '#downloadExcel', function() {
    const form = $('<form>', {
        action: "{{ route('presence.export') }}",
        method: 'POST'
    });

    // CSRF token
    form.append($('<input>', {
        type: 'hidden',
        name: '_token',
        value: '{{ csrf_token() }}'
    }));

    // Filter inputs
    form.append($('<input>', {type: 'hidden', name: 'start_date', value: startDate}));
    form.append($('<input>', {type: 'hidden', name: 'end_date', value: endDate}));
    form.append($('<input>', {type: 'hidden', name: 'status', value: status}));
    form.append($('<input>', {type: 'hidden', name: 'search', value: search}));

    // Append & submit
    $('body').append(form);
    form.submit();
});


            // $(document).on('click', '#print', function(){
            //     // $(".buttons-print")[0].click(); //trigger the click event
            //     // $(".buttons-excel")[0].click(); //trigger the click event
            //     // go to route sales.quotation.download-list
            //     window.location.href = '?startDate=' + startDate + '&endDate=' + endDate + '&status=' + status;
            // });

            dispatchFilters();
        });

        function dispatchFilters() {
            Livewire.dispatch('filterChanged', {filters: {status_id: status} });
        }
    </script>
@endpush

@section('script')
<script>
    let mapIn = null;
    let mapOut = null;
    let markerIn = null;
    let markerOut = null;

    document.addEventListener('livewire:init', () => {

        Livewire.on('load-presence-map', (data) => {

            const inLoc  = data.checkInLocation;
            const outLoc = data.checkOutLocation;

            if (!mapIn) {
                mapIn = L.map('mapCheckIn');
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(mapIn);
            }

            if (inLoc) {
                const [lat, lng] = inLoc.split(',').map(Number);

                setTimeout(() => {
                    mapIn.invalidateSize();
                    mapIn.setView([lat, lng], 16);

                    if (markerIn) mapIn.removeLayer(markerIn);
                    markerIn = L.marker([lat, lng]).addTo(mapIn).bindPopup("Lokasi Check In");
                }, 100);
            }

            if (!mapOut) {
                mapOut = L.map('mapCheckOut');
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(mapOut);
            }

            if (outLoc) {
                const [lat2, lng2] = outLoc.split(',').map(Number);

                setTimeout(() => {
                    mapOut.invalidateSize();
                    mapOut.setView([lat2, lng2], 16);

                    if (markerOut) mapOut.removeLayer(markerOut);
                    markerOut = L.marker([lat2, lng2]).addTo(mapOut).bindPopup("Lokasi Check Out");
                }, 100);
            }

            setTimeout(() => {
                if (mapIn) mapIn.invalidateSize();
                if (mapOut) mapOut.invalidateSize();
            }, 500);
        });

    });

    document.addEventListener('shown.bs.modal', function(e) {
        if (e.target.id === 'presenceDetailModal') {

            setTimeout(() => {
                if (mapIn) mapIn.invalidateSize();
                if (mapOut) mapOut.invalidateSize();
            }, 80);
        }
    });
    document.addEventListener('hidden.bs.modal', function(e) {
    if (e.target.id === 'x-ilz-modal') {

        if (mapIn) {
            mapIn.remove();
            mapIn = null;
        }

        if (mapOut) {
            mapOut.remove();
            mapOut = null;
        }

        markerIn = null;
        markerOut = null;
    }
});

</script>
@endsection