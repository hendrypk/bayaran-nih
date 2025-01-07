@extends('_layout.main')
@section('title', 'Employee Resignation')
@section('content')

{{ Breadcrumbs::render('employee_resignation') }}
<div class="row">
  <div class="col-lg">
    <div class="card">
      <div class="card-body">
        <div class="card-header d-flex align-items-center py-0">
          <h5 class="card-title mb-0 py-3">{{ __('employee.label.employee_resignation') }}</h5>
          @can('create resignation')
            <div class="ms-auto my-auto">
                <button type="button"
                class="btn btn-tosca" onclick="openResignModal('add')">
                <i class="ri-add-circle-line"></i>
            </button>
            </div>
          @endcan
        </div>

        <!-- Table with hoverable rows -->
        <table class="table datatable table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">{{ __('employee.label.eid') }}</th>
              <th scope="col">{{ __('employee.label.employee_name') }}</th>
              <th scope="col">{{ __('employee.label.category') }}</th>
              <th scope="col">{{ __('employee.label.resign_date') }}</th>
              <th scope="col">{{ __('employee.label.resign_note') }}</th>
              <th scope="col">{{ __('employee.label.last_position') }}</th>
              <th scope="col">{{ __('employee.label.last_job_title') }}</th>
              <th scope="col">{{ __('employee.label.last_division') }}</th>
              <th scope="col">{{ __('employee.label.last_department') }}</th>
              <th scope="col">{{ __('general.label.action') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($resignEmployees as $no=>$data)
            <tr>
              <th scope="row">{{ $no+1 }}</th>
              <td>{{ $data->eid }}</td>
              <td>{{ $data->name }}</td>
              <td>{{ $data->resignation ?? '-' }}</td>
              <td>{{ $data->resignation_date ?? '-' }}</td>
              <td>{{ $data->resignation_note ?? '-' }}</td>
              <td>{{ $data->position->name ?? '-' }}</td>
              <td>{{ $data->job_title->name ?? '-' }}</td>
              <td>{{ $data->division->name ?? '-' }}</td>
              <td>{{ $data->department->name ?? '-' }}</td>
              <td>
                @can('update resignation')
                <button type="button"
                    class="btn btn-untosca btn-sm" onclick="openResignModal('edit', {
                        id: '{{ $data->id }}',
                        name: '{{ $data->name }}',
                        category: '{{ $data->resignation }}',
                        date: '{{ $data->resignation_date }}',
                        note: '{{ $data->resignation_note }}',
                    })">
                    <i class="ri-edit-box-fill"></i>
                </button>
                @endcan

              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <!-- End Table with hoverable rows -->

      </div>
    </div>
  </div>
</div>

@section('script')
<script>
function openResignModal(action, data = {}) {
    if (action === 'add') {
        $('#resignForm').attr('action', "{{ route('resignation.store') }}");
        $('#resignModalTitle').text('{{ __('employee.label.modal_title_add_resign') }}');
        $('#name').val('');
        $('#category').val('');
        $('#date').val('');
        $('#note').val('');
        $('#name').prop('disabled', false);
    } else if (action === 'edit') {
        $('#resignForm').attr('action', "{{ route('resignation.update') }}");
        $('#resignModalTitle').text('{{ __('employee.label.modal_title_edit_resign') }}');
        $('#name').val(data.id);
        $('#category').val(data.category);
        $('#date').val(data.date);
        $('#note').val(data.note);
        $('#name').prop('disabled', false);
    }

    $('#resignModal').modal('show');

    const deleteButton = document.getElementById('deleteButton');
    if (action === 'edit') {
        deleteButton.style.display = 'inline-block'; // Tampilkan tombol hapus
        deleteButton.setAttribute('onclick', `confirmDelete(${data.id}, '${data.name}', 'resignation')`);
    } else {
        deleteButton.style.display = 'none'; // Sembunyikan tombol hapus untuk mode tambah
    }
}


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

//Handle Alert
$('#resignForm').submit(function(e) {
    e.preventDefault(); 
    
    var form = $(this);
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    title: 'Success!',
                    text: response.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = "{{ route('resignation.index') }}";
                });
            }
        },
        error: function(xhr) {
            // Handle error case
            Swal.fire({
                title: 'Error!',
                text: xhr.responseJSON?.message || 'Something went wrong.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
});

//Delete
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
</script>
@endsection
@endsection
@include('resignation.modal')