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
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ __('employee.label.eid') }}</th>
                        <th scope="col">{{ __('general.label.name') }}</th>
                        <th scope="col">{{ __('general.label.category') }}</th>
                        <th scope="col">{{ __('general.label.report_date') }}</th>
                        <th scope="col">{{ __('general.label.report_description') }}</th>
                        <th scope="col">{{ __('general.label.report_attachment') }}</th>
                        <th scope="col">{{ __('general.label.solve_date') }}</th>
                        <th scope="col">{{ __('general.label.solve_description') }}</th>
                        <th scope="col">{{ __('general.label.solve_attachment') }}</th>
                        <th scope="col">{{ __('general.label.status') }}</th>
                    </tr>
                </thead>
                <tbody>                    
                    @foreach($laporHr as $no=>$data)
                    <tr>
                        <th scope="row">{{ $no+1 }}</th>
                        <td>{{ $data->employee->eid }}</td>
                        <td>{{ $data->employee->name }}</td>
                        <td>{{ $data->category->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($data->report_date)->format('d F Y') }}</td>
                        <td>{{ $data->report_description }}</td>
                        <td>
                            @if($data->report_attachments->isNotEmpty())
                                <button type="button" class="btn btn-yellow"
                                    data-toggle="modal"
                                    data-target="#photoModal"
                                    onclick='showAllPhotos(@json($data->report_attachments))'>
                                    <i class="ri-eye-line"></i>
                                </button>
                            @else
                                <span class="text-muted">Tidak ada lampiran</span>
                            @endif
                        </td>
                        <td>
                            @if ($data->solve_date)
                                {{ \Carbon\Carbon::parse($data->solve_date)->format('d F Y') }}
                            @endif
                        </td>
                        
                        <td>{{ $data->solve_description }}</td>
                        <td>
                            @if($data->solve_attachments->isNotEmpty())
                                <button type="button" class="btn btn-yellow"
                                    data-toggle="modal"
                                    data-target="#photoModal"
                                    onclick='showAllPhotos(@json($data->solve_attachments))'>
                                    <i class="ri-eye-line"></i>
                                </button>
                            @else
                                <span class="text-muted">Tidak ada lampiran</span>
                            @endif
                        </td>
                        <td>{{ $data->status }}</td>
                    </tr>    
                    @endforeach
                    
                    
                </tbody>
            </table>
        </div>
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