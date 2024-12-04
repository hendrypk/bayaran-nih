@extends('_layout.main')
@section('title', 'Employees')
@section('content')

<div class="row">
  <div class="col-lg">
    <div class="card">
      <div class="card-body">
        <div class="card-header d-flex align-items-center py-0">
          <h5 class="card-title mb-0 py-3">Employee List</h5>
          @can('create employee')
            <div class="ms-auto my-auto">
              <button type="button" class="btn btn-untosca" onclick="resignationModal('add')">Add Resignation</button>
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
            @foreach($resignEmployees as $no=>$employee)
            <tr>
              <th scope="row">{{ $no+1 }}</th>
              <td>{{ $employee->eid }}</td>
              <td>{{ $employee->name }}</td>
              <td>{{ $employee->resignation ?? '-' }}</td>
              <td>{{ \Carbon\Carbon::parse($employee->resignation_date)->format('d F Y') }}</td>
              <td>{{ $employee->position->name ?? '-' }}</td>
              <td>{{ $employee->job_title->name ?? '-' }}</td>
              <td>{{ $employee->division->name ?? '-' }}</td>
              <td>{{ $employee->department->name ?? '-' }}</td>
              <td>
                <button type="button" class="btn btn-outline-success" onclick="resignationModal('edit',
                {
                    id: '{{ $employee->id }}',
                    name: '{{ $employee->name }}',
                    category: '{{ $employee->resignation }}',
                    date: '{{ $employee->resignation_date }}'
                })"><i class="ri-edit-line"></i></button>
                
                <button type="button" class="btn btn-outline-danger" 
                    onclick="confirmDelete({{ $employee->id }}, '{{ $employee->name }}', 'resignation')">
                <i class="ri-delete-bin-fill"></i>
            </button>
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
function resignationModal(action, data = {}) {
    if (action === 'add') {
        $('#resignationForm').attr('action', "{{ route('resignation.store') }}");
        $('#resignationModalTitle').text('Add Resignation');
        $('#employee').val('');
        $('#category').val('');
        $('#date').val('');
    } else if (action === 'edit') {
        $('#resignationForm').attr('action', "{{ route('resignation.update') }}");
        $('#resignationModalTitle').text('Edit Resignation');
        $('#employee').val(data.id).trigger('change');;
        $('#category').val(data.category);
        $('#date').val(data.date);
    }
    $('#resignationModal').modal('show');
}

function save(form) {
    let formData = new FormData(form);

    fetch(form.action, {
        method: form.method,
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: data.message,
            }).then(() => {
                location.reload(); // Reload page or update table
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message,
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Something went wrong. Please try again.',
        });
    });
}

document.querySelector('#resignationForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent form submission
    save(this);
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