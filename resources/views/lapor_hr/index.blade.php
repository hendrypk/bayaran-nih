@extends('_layout.main')
@section('title', __('option.label.lapor_hr'))
@section('content')

{{ Breadcrumbs::render('lapor_hr') }}
<div class="row align-items-center">
    <div class="col-md-9">
        <x-absence-date-filter action="{{ route('leave.index') }}" 
                        :startDate="request()->get('start_date')" 
                        :endDate="request()->get('end_date')" />
    </div>
    <div class="col-md-3 d-flex justify-content-end">
        @can('create leave')
        {{-- <button type="button" class="btn btn-tosca btn-sm"
                data-bs-toggle="modal" 
                data-bs-target="#modalLaporHr">
            <i class="ri-add-circle-line"></i>
        </button> --}}
        @endcan
    </div>
</div>

<div class="row">
    <div class="col-md">
        <div class="card">
            <div class="card-body">
                <div class="card-header d-flex align-items-center py-0">
                    <div class="col-md-10">
                        <h5 class="card-title mb-0 py-3">{{ __('option.label.lapor_hr') }}</h5>
                    </div>
                </div>
                    <table class="table datatable table-hover">
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
                                <th scope="col">{{ __('general.label.edit') }}</th>
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
                                            data-bs-toggle="modal"
                                            data-bs-target="#photoModal"
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
                                            data-bs-toggle="modal"
                                            data-bs-target="#photoModal"
                                            onclick='showAllPhotos(@json($data->solve_attachments))'>
                                            <i class="ri-eye-line"></i>
                                        </button>
                                    @else
                                        <span class="text-muted">Tidak ada lampiran</span>
                                    @endif
                                </td>
                                <td>{{ $data->status }}</td>
                                <td>
                                    @can('update leave')
                                        <button type="button" class="btn btn-green"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalLaporHr" 
                                            data-id="{{ $data->id }}" 
                                            data-eid="{{ $data->employee->eid }}"
                                            data-employee_id="{{ $data->employee_id }}"
                                            data-name="{{ $data->employee->name }}"
                                            data-category="{{ $data->category_id }}"
                                            data-date="{{ $data->report_date }}"
                                            data-note="{{ $data->report_description }}"
                                            data-report_attachments='@json($data->report_attachments)'
                                            data-solve_date="{{ $data->solve_date }}"
                                            data-solve_description="{{ $data->solve_description }}"
                                            data-status="{{ $data->status }}"
                                            onclick='showAllPhotos(@json($data->report_attachments))'>
                                            <i class="ri-edit-line"></i>
                                        </button>                                
                                    @endcan                                
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
 document.addEventListener('DOMContentLoaded', function () {
    const editModal = document.getElementById('modalLaporHr');
    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        // Ambil data dari button
        const id = button.getAttribute('data-id');
        const eid = button.getAttribute('data-eid');
        const employee_id = button.getAttribute('data-employee_id');
        const name = button.getAttribute('data-name');
        const report_date = button.getAttribute('data-date');
        const report_category = button.getAttribute('data-category');
        const report_description = button.getAttribute('data-note');
        const solve_date = button.getAttribute('data-solve_date');
        const solve_description = button.getAttribute('data-solve_description');
        const status = button.getAttribute('data-status');
        const solve_attachment = button.getAttribute('data-solve_attachment');
        const reportAttachments = JSON.parse(button.getAttribute('data-report_attachments') || '[]');



        // Isi form
        if (report_date && /^\d{4}-\d{2}-\d{2}$/.test(report_date)) {
            document.getElementById('report_date').value = report_date;
        } else {
            console.warn('Invalid date format:', report_date);
            document.getElementById('report_date').value = '';
        }

        if (solve_date && /^\d{4}-\d{2}-\d{2}$/.test(solve_date)) {
            document.getElementById('solve_date').value = solve_date;
        } else {
            document.getElementById('solve_date').value = '';
        }

        document.querySelector('[name="eid"]').value = employee_id;
        document.querySelector('[name="employee_id"]').value = employee_id;
        document.querySelector('[name="report_category"]').value = report_category;
        document.getElementById('report_description').value = report_description || '';
        document.getElementById('solve_description').value = solve_description || '';
        document.querySelector('[name="status"]').value = status;
        
        // Title modal (jika ada)
        const modalTitle = document.getElementById('modalTitle');
        if (modalTitle && name) {
            modalTitle.textContent = `Edit Laporan: ${name}`;
        }

        // Hidden field jika butuh
        const hiddenId = document.getElementById('report_id');
        if (hiddenId) {
            hiddenId.value = id;
        }
        
        const previewContainer = modal.querySelector('#preview-container');
        previewContainer.innerHTML = '';
        reportAttachments.forEach(file => {
            const col = document.createElement('div');
            col.classList.add('col-md-4');
            col.innerHTML = `
                <div class="card">
                    <div class="card-img-top text-center p-3" style="height: 150px; overflow: hidden;">
                        <img src="/storage/${file}" class="img-fluid" style="max-height: 100%; object-fit: cover;">
                    </div>
                    <div class="card-body p-2">
                        <p class="card-text text-truncate mb-1">${file}</p>
                    </div>
                </div>
            `;
            previewContainer.appendChild(col);
        });

        // Bersihkan preview solve_attachment baru
        modal.querySelector('#solve-preview-container').innerHTML = '';
        modal.querySelector('#solve_attachment').value = '';
        
        // checkSolveFieldsFilled();
    });
});

// function checkSolveFieldsFilled() {
//     const solveDate = document.getElementById('solve_date').value.trim();
//     const solveDescription = document.getElementById('solve_description').value.trim();
//     const solveAttachment = document.querySelector('[name="solve_attachment"]').files.length > 0;

//     const isAllFilled = solveDate !== '' && solveDescription !== '' && solveAttachment;

//     const statusSelect = document.querySelector('[name="status"]');
//     for (let option of statusSelect.options) {
//         if (option.value.toLowerCase() === 'close') {
//             option.disabled = !isAllFilled;
//         }
//     }
// }

// Jalankan saat user input:
document.getElementById('solve_date').addEventListener('input', checkSolveFieldsFilled);
document.getElementById('solve_description').addEventListener('input', checkSolveFieldsFilled);
document.querySelector('[name="solve_attachment"]').addEventListener('change', checkSolveFieldsFilled);
document.getElementById('previewPhotoBtn').addEventListener('click', function () {
    const photoModal = new bootstrap.Modal(document.getElementById('photoModal'), {
        backdrop: false
    });
    photoModal.show();
});

function previewFiles(event) {
    const previewContainer = document.getElementById('solve-preview-container');
    const input = event.target;
    const newFiles = event.target.files;

    // Loop through the newly selected files and display their previews
    Array.from(newFiles).forEach((file, index) => {
        const reader = new FileReader();

        reader.onload = function(e) {
            const col = document.createElement('div');
            col.classList.add('col-md-4');
            
            // Check file type
            let fileHtml;
            const fileExt = file.name.split('.').pop().toLowerCase();

            if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExt)) {
                // Image file
                fileHtml = `
                    <div class="card">
                        <div class="card-img-top text-center p-3" style="height: 150px; overflow: hidden;">
                            <img src="${e.target.result}" class="img-fluid" style="max-height: 100%; object-fit: cover;">
                        </div>
                        <div class="card-body p-2">
                            <p class="card-text text-truncate mb-1">${file.name}</p>
                            <button class="btn btn-sm btn-danger w-100" onclick="removePreview(${input.files.length - newFiles.length + index}, event)">Cancel</button>
                        </div>
                    </div>
                `;
            } else {
                // Non-image file
                fileHtml = `
                    <div class="card">
                        <div class="card-body p-2 text-center">
                            <i class="ri-file-text-line" style="font-size: 2rem;"></i>
                            <p class="card-text text-truncate mb-1">${file.name}</p>
                            <button class="btn btn-sm btn-danger w-100" onclick="removePreview(${input.files.length - newFiles.length + index}, event)">Cancel</button>
                        </div>
                    </div>
                `;
            }

            col.innerHTML = fileHtml;
            previewContainer.appendChild(col);
        };

        reader.readAsDataURL(file);
    });
}

// Remove preview and file from input
function removePreview(index, event) {
    const previewContainer = document.getElementById('solve-preview-container');
    const input = document.getElementById('solve_attachment');

    // Remove the preview element
    previewContainer.removeChild(event.target.closest('.col-md-4'));

    // Remove the file from the input element
    const dataTransfer = new DataTransfer();
    const files = input.files;
    
    // Add all files except the one clicked "Cancel" on
    Array.from(files).forEach((file, i) => {
        if (i !== index) {
            dataTransfer.items.add(file);
        }
    });

    // Update input field with new file list (without the canceled file)
    input.files = dataTransfer.files;
}


function confirmDelete(id, name, entity) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to delete the " + entity + ": " + name,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '',
            cancelButtonColor: '',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/${entity}/${id}/delete`, { 
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: data.message, 
                            icon: 'success'
                        }).then(() => {
                            window.location.href = data.redirect;
                        });
                    } else {
                        Swal.fire('Error!', data.message || 'Something went wrong. Try again later.', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error!', 'Failed to delete. Please try again.', 'error');
                    console.error('There was a problem with the fetch operation:', error);
                });
            }
        });
    }

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
@include('lapor_hr.modal')
@include('lapor_hr.modal_photo')
