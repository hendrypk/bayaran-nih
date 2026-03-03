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
        <div class="pageTitle"> {{ Auth::user()->name }} {{ __('general.label.lapor_hr') }} </div>
        <div class="right"></div>
    </div>
@endsection

@section('content')
<div class="presence">
    <div class="" id="reportAccordion">
        @foreach($laporHr as $no => $data)
        <div class="card mb-2">
            <div class="card-header" id="heading{{ $no }}">
                <h2 class="d-flex justify-content-between align-items-center">
                    <button class="btn btn-link text-left" type="button" 
                            data-toggle="collapse" 
                            data-target="#collapse{{ $no }}" 
                            aria-expanded="false" 
                            aria-controls="collapse{{ $no }}">
                        {{ $no+1 }}. {{ formatDate($data->report_date) }} - {{ $data->category->name }}
                    </button>

                    @php
                        $badgeClass = match($data->status) {
                            'open' => 'secondary',
                            'on progress' => 'warning',
                            'close' => 'success',
                            default => 'danger'
                        };
                    @endphp
                    <span class="badge badge-{{ $badgeClass }}">{{ $data->status }}</span>
                </h2>
            </div>
    
            <div id="collapse{{ $no }}" class="collapse" 
                aria-labelledby="heading{{ $no }}" 
                data-parent="#reportAccordion">
                <div class="card-body">
                    <p>{{ $data->report_description }}</p>
                    <small class="text-muted">
                        Feedback :
                        @if($data->description)
                            {{ $data->description }} {{ formatDate($data->solve_date) }}
                        @else
                            -
                        @endif
                    </small>
                </div>
            </div>

        </div>
        @endforeach
    </div>
</div>

<a href="{{ route('laporHrAdd') }}" class="btn btn-primary floating-btn">+
</a>

@endsection
@section('script')
<script>
    function showAllPhotos(attachments) {
    const inner = document.getElementById('carouselInner');
    inner.innerHTML = ''; // Kosongkan

    attachments.forEach((item, index) => {
        const fileUrl = `/storage/${item.file_path}`;
        const ext = fileUrl.split('.').pop().toLowerCase();

        let content = '';

        if (['jpg', 'jpeg', 'png'].includes(ext)) {
            content = `<img src="${fileUrl}" class="d-block w-100 rounded" alt="Lampiran">`;
        } else if (['mp4', 'mov', 'avi', 'mkv'].includes(ext)) {
            content = `
                <video controls class="d-block w-100 rounded">
                    <source src="${fileUrl}" type="video/${ext === 'mkv' ? 'mp4' : ext}">
                    Browser tidak mendukung video ini.
                </video>
            `;
        } else if (ext === 'pdf') {
            content = `<iframe src="${fileUrl}" width="100%" height="400px" style="border:none;" class="d-block rounded"></iframe>`;
        } else {
            content = `<div class="text-danger text-center p-3">Format file tidak dikenali.</div>`;
        }

        inner.innerHTML += `
            <div class="carousel-item ${index === 0 ? 'active' : ''}">
                ${content}
            </div>
        `;
    });
}

</script>
@endsection
@include('_employee_app.lapor_hr.modal_photo')