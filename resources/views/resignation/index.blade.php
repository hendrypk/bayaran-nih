@extends('_layout.main')
@section('title', 'Employee Resignation')
@section('content')

<div class="row">
  <div class="col-lg">
    <div class="card">
      <div class="card-body">
        <div class="card-header d-flex align-items-center py-0">
          <h5 class="card-title mb-0 py-3">Employee Resignation</h5>
          @can('create resignation')
            <div class="ms-auto my-auto">
                <button type="button"
                class="btn btn-tosca" onclick="openResignModal('add')">
                Add Resignation
            </button>
            </div>
          @endcan
        </div>

        <!-- Table with hoverable rows -->
        <table class="table datatable table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">EID</th>
              <th scope="col">Name</th>
              <th scope="col">Category</th>
              <th scope="col">Resign Date</th>
              <th scope="col">Last Position</th>
              <th scope="col">Last Job Title</th>
              <th scope="col">Last Division</th>
              <th scope="col">Last Department</th>
              <th scope="col">Action</th>
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
              <td>{{ $data->position->name ?? '-' }}</td>
              <td>{{ $data->job_title->name ?? '-' }}</td>
              <td>{{ $data->division->name ?? '-' }}</td>
              <td>{{ $data->department->name ?? '-' }}</td>
              <td>
                @can('update resignation')
                <button type="button"
                    class="btn btn-outline-success" onclick="openResignModal('edit', {
                        id: '{{ $data->id }}',
                        name: '{{ $data->name }}',
                        category: '{{ $data->resignation }}',
                        date: '{{ $data->resignation_date }}',
                    })">
                    <i class="ri-edit-box-fill"></i>
                </button>
                @endcan
                @can('delete resignation')
                <button type="button" class="btn btn-outline-danger" 
                    onclick="confirmDelete({{ $data->id }}, '{{ $data->name }}', 'resignation')">
                    <i class="ri-delete-bin-fill"></i>
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
        $('#resignModalTitle').text('Add Resignation');
        $('#name').val('');
        $('#category').val('');
        $('#date').val('');
        $('#name').prop('disabled', false);
    } else if (action === 'edit') {
        $('#resignForm').attr('action', "{{ route('resignation.update') }}");
        $('#resignModalTitle').text('Edit Resignation');
        $('#name').val(data.id);
        $('#category').val(data.category);
        $('#date').val(data.date);
        $('#name').prop('disabled', false);
    }

    $('#resignModal').modal('show');
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