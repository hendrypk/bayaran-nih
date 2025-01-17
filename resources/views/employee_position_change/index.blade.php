@extends('_layout.main')
@section('title', 'Employee Position Change')
@section('content')

{{ Breadcrumbs::render('employee_position_change') }}
<div class="row">
    <div class="col-lg">
      <div class="card">
        <div class="card-body">
          <div class="card-header d-flex align-items-center py-0">
            <h5 class="card-title mb-0 py-3">Employee Position Change</h5>
            @can('create position change')
              <div class="ms-auto my-auto">
                  <button type="button"
                  class="btn btn-tosca" onclick="openModal('add')">
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
                <th scope="col">EID</th>
                <th scope="col">Name</th>
                <th scope="col">Category</th>
                <th scope="col">Old Position</th>
                <th scope="col">New Position</th>
                <th scope="col">Effective Date</th>
                <th scope="col">Note</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($positionChange as $no=>$data)
              <tr class="@if($data->effective_date != $latestPositionChanges[$data->employees->id]->effective_date) bg-tosca @endif" title="Only the most recent effective date can be changed.">

                <th scope="row">{{ $no+1 }}</th>
                <td>{{ $data->employees->eid }}</td>
                <td>{{ $data->employees->name }}</td>
                <td>{{ ucwords($data->category) }}</td>
                <td>{{ $data->oldPosition->name ?? '-' }}</td>
                <td>{{ $data->position->name ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($data->effective_date ?? '-')->format('d F Y') }}</td>
                <td>{{ $data->reason ?? '-' }}</td>
                <td>
                    @can('update position change')
                    <button type="button"
                      class="btn btn-use btn-tosca btn-sm" 
                      @if($data->effective_date != $latestPositionChanges[$data->employees->id]->effective_date)
                        onclick="showErrorAlert('Only the most recent effective date can be changed.');"
                      @else
                        onclick="openModal('edit', {
                          id: '{{ $data->id }}',
                          employee_id: '{{ $data->employees->id }}',
                          name: '{{ $data->employees->name }}',
                          eid: '{{ $data->employees->eid }}',
                          category: '{{ $data->category }}',
                          old_position: '{{ $data->old_position }}',
                          old_position_name: '{{ $data->oldPosition->name ?? '-' }}',
                          new_position: '{{ $data->new_position }}',
                          effective_date: '{{ $data->effective_date }}',
                          note: '{{ $data->reason }}',
                        })"
                      @endif>
                      <i class="ri-edit-box-fill"></i>
                    </button>
                  @endcan
{{--                   
                  @can('delete resignation')
                    <button type="button" 
                      class="btn btn-outline-danger" 
                      @if($data->effective_date != $latestPositionChanges[$data->employees->id]->effective_date)
                        onclick="showErrorAlert('Only the most recent effective date can be deleted.');"
                      @else
                        onclick="confirmDelete({{ $data->id }}, '{{ $data->name }}', 'position-change')"
                      @endif>
                      <i class="ri-delete-bin-fill"></i>
                    </button>
                  @endcan --}}
                  
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
function openModal(action, data = {}) {
    if (action === 'add') {
        $('#positionChangeForm').attr('action', "{{ route('position.change.store') }}");    
        $('#positionChangeTitle').text('Add Position Change');
        $('#name').val(''); 
        $('#category').val('');
        $('#oldPosition').val(''); 
        $('#newPosition').val('');
        $('#date').val(''); 
        $('#note').val('');
        $('#name').prop('disabled', false); 
    } else if (action === 'edit') {
        $('#positionChangeForm').attr('action', "{{ route('position.change.store') }}");
        $('#positionChangeTitle').text('Edit Position Change');
        $('#id').val(data.id); 
        $('#name').val(data.employee_id); 
        $('#category').val(data.category);
        $('#oldPosition').val(data.old_position_name);
        $('#hiddenPositionId').val(data.old_position);
        $('#hiddenEmployeeId').val(data.name);
        $('#newPosition').val(data.new_position);
        $('#date').val(data.effective_date);
        $('#note').val(data.note);
        $('#name').prop('disabled', false); 
    }

    $('#positionChange').modal('show');

    const deleteButton = document.getElementById('deleteButton');
    if (action === 'edit') {
        deleteButton.style.display = 'inline-block'; // Tampilkan tombol hapus
        deleteButton.setAttribute('onclick', `confirmDelete(${data.id}, '${data.name}', 'position-change')`);
    } else {
        deleteButton.style.display = 'none'; // Sembunyikan tombol hapus untuk mode tambah
    }
}

$('#name').change(function() {
    const oldPositionName = $('#name option:selected').data('old-position');
    const oldPositionId = $('#name').data('old-position-id'); 

    $('#oldPosition').val(oldPositionName);
});

function enableDisableButtons() {
    let lastEmployeeId = null; 
    let lastEffectiveDate = null; 

    // Loop through the positionChange table rows
    $('.position-change-row').each(function() {
        const employeeId = $(this).data('eid');
        const effectiveDate = $(this).data('effective-date');

        if (employeeId === lastEmployeeId) {
            const isMoreRecent = new Date(effectiveDate) > new Date(lastEffectiveDate);

            if (!isMoreRecent) {
                $(this).find('.btn-use').prop('disabled', true).attr('data-bs-toggle', 'tooltip').attr('data-bs-placement', 'top').attr('title', 'Only the most recent entry can be selected');
            } else {
                $(this).find('.btn-use').prop('disabled', false).removeAttr('data-bs-toggle').removeAttr('data-bs-placement').removeAttr('title');
            }
        } else {
            $(this).find('.btn-use').prop('disabled', false).removeAttr('data-bs-toggle').removeAttr('data-bs-placement').removeAttr('title');
        }

        lastEmployeeId = employeeId; 
        lastEffectiveDate = effectiveDate; 
    });

    $('[data-bs-toggle="tooltip"]').tooltip();
}

//Handle Alert
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function showErrorAlert(message) {
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: message,
    });
  }

$('#positionChangeForm').submit(function(e) {
    e.preventDefault();

    var form = $(this);
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        success: function(response) {
            if (!response.success) {  
                Swal.fire({
                    title: 'Error!',
                    text: response.message,  
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    title: 'Success!',
                    text: response.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = "{{ route('position.change.index') }}";  
                });
            }
        },
        error: function(xhr) {
            // Handle AJAX error
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
@include('employee_position_change.modal')