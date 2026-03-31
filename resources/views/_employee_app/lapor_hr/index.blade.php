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
        <div class="section mt-2">
            <div class="transactions" id="laporAccordion">
                @foreach($laporHr as $no => $data)
                    @php
                        $statusColor = match($data->status) {
                            'open' => 'text-secondary',
                            'on progress' => 'text-warning',
                            'close' => 'text-success',
                            default => 'text-danger'
                        };
                        
                        $bgColor = match($data->status) {
                            'open' => 'bg-secondary',
                            'on progress' => 'bg-warning',
                            'close' => 'bg-success',
                            default => 'bg-danger'
                        };
                    @endphp

                    <div class="item-wrapper border-bottom mb-1">
                        <a href="javascript:void(0);" 
                           class="item py-1 d-block text-decoration-none" 
                           data-toggle="collapse" 
                           data-target="#detail{{ $no }}"
                           aria-expanded="false"
                           aria-controls="detail{{ $no }}">
                            <div class="detail d-flex align-items-center">
                                <div class="icon-box {{ $bgColor }} bg-opacity-10 rounded p-1 mr-2">
                                    <ion-icon name="chatbubble-ellipses-outline" class="{{ $statusColor }}" style="font-size: 24px;"></ion-icon>
                                </div>
                                <div class="flex-grow-1">
                                    <strong class="text-dark d-block">{{ $data->category->name }}</strong>
                                    <small class="text-muted">{{ formatDate($data->report_date) }}</small>
                                </div>
                                <div class="right text-right">
                                    <span class="badge {{ $bgColor }} text-white" style="font-size: 10px;">{{ strtoupper($data->status) }}</span>
                                    <ion-icon name="chevron-down-outline" class="text-muted d-block mt-1 transition-icon"></ion-icon>
                                </div>
                            </div>
                        </a>

                        <div id="detail{{ $no }}" 
                             class="collapse bg-light rounded p-2 mb-2 shadow-sm" 
                             data-parent="#laporAccordion">
                            <div class="text-dark small mb-1">
                                <strong>Deskripsi:</strong><br>
                                {{ $data->report_description }}
                            </div>
                            <hr class="my-1 border-secondary opacity-25">
                            <div class="small">
                                <strong class="text-primary">Feedback HR:</strong><br>
                                <span class="text-muted">
                                    {{ $data->description ?? 'Belum ada tanggapan.' }}
                                    @if($data->solve_date) 
                                        <br><small>🕒 {{ formatDate($data->solve_date) }}</small>
                                    @endif
                                </span>
                            </div>
                            @if($data->attachments->count() > 0)
                                <button class="btn btn-sm btn-outline-primary btn-block mt-2" 
                                        onclick="showAllPhotos({{ $data->attachments }})">
                                    <ion-icon name="images-outline" class="mr-1"></ion-icon> 
                                    Lihat Lampiran ({{ $data->attachments->count() }})
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

<a href="{{ route('laporHrAdd') }}" class="btn btn-primary floating-btn">+</a>
@endsection

@section('styles')
<style>
    /* Animasi rotasi icon chevron saat collapse terbuka */
    .transition-icon {
        transition: transform 0.3s ease;
    }
    [aria-expanded="true"] .transition-icon {
        transform: rotate(180deg);
    }
</style>
@endsection

@section('script')
<script>
    function showAllPhotos(attachments) {
    const inner = document.getElementById('carouselInner');
    inner.innerHTML = ''; 

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
    $('#photoModal').modal('show');
}

</script>
@endsection
@include('_employee_app.lapor_hr.modal_photo')