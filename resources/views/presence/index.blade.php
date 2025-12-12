@extends('_layout.main')
@section('title', __('sidebar.label.presences'))
@section('content')


{{ Breadcrumbs::render('presence') }}
<div class="row align-items-center mb-3">
    <!-- Filter -->
    <div class="col-md-6">
        <div class="d-flex flex-wrap gap-2">
                <form action="{{ route('presence.list.admin') }}" method="GET" class="m-0 d-flex">
                    <input type="hidden" name="start_date" value="{{ request()->get('start_date') }}">
                    <input type="hidden" name="end_date" value="{{ request()->get('end_date') }}">
                    <select id="status" name="status" class="form-select" onchange="this.form.submit()">
                        <option value="presence" {{ request()->get('status') === 'presence' ? 'selected' : '' }}>Presence</option>
                        <option value="absence" {{ request()->get('status') === 'absence' ? 'selected' : '' }}>Absence</option>
                    </select>
                </form>


            <livewire:date-range-filter 
                startDate="{{ request()->get('start_date') ?: '' }}" 
                endDate="{{ request()->get('end_date') ?: '' }}" />
        </div>
    </div>

    <div class="col-md-6">
        <div class="d-flex justify-content-md-end justify-content-start flex-wrap gap-2">
            @can('presence export')
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
            @endcan

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
                {{-- <button type="button" class="btn btn-tosca btn-sm d-flex align-items-center"
                        data-bs-toggle="modal" 
                        data-bs-target="#addPresence">
                    <i class="ri-add-circle-line"></i>
                </button> --}}
            @endcan
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
                    {!! $p->table(['id' => 'presences-datatable','class'=>'table table-responsive'], false) !!}
                </div>
            </div>
        </div>
    </div>
</div>

</div>
@endsection

@push('scripts')
    {!! $p->scripts() !!}
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