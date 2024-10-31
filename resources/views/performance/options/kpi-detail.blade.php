@extends('_layout.main')
@section('title', 'Performance - PA')
@section('content')

<div class="col-lg-8">
    <div class="card">
        <div class="card-body">
            <div class="card-header d-flex align-items-center py-0">
                <div class="col-md-8">
                    <h5 class="card-title">KPI Detail for {{ $indicators->FIRST()->name }}</h5>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-danger" 
                        onclick="confirmDelete({{ $kpi_id->first()->id }}, '{{ $kpi_id->first()->name }}', 'indicator')">
                        <i class="ri-delete-bin-fill"></i>
                    </button>
                </div>
                <div class="col-md-2">
                    
                </div>
            </div>
            {{-- <form action="{{ route('indicator.add') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-7">
                    <label for="inputPosition" class="form-label fw-bold">Name</label>
                    <input type="text" name="name" class="form-control" required>

                    </div>
                </div>
                <div id="indicatorsContainer">
                    <div class="indicator-group mb-3">
                        <div class="row mb-3">
                            <div class="col-7">
                                <label for="inputAspect" class="form-label fw-bold">Indicator</label>
                            </div>
                            <div class="col-2">
                                <label for="inputAspect" class="form-label fw-bold">Target</label>
                            </div>
                            <div class="col-2">
                                <label for="inputAspect" class="form-label fw-bold">Bobot (%)</label>
                            </div>

                        </div>

                        @foreach ($indicators as $indicator)
                        <div class="row mb-3">
                            <div class="col-7">
                                <input type="text" class="form-control" name="indicators[0][aspect]" value="{{ $indicator->aspect }}" required>
                            </div>
                            <div class="col-2">
                                <input type="number" class="form-control" name="indicators[0][target]" value="{{ $indicator->target }}" required>
                            </div>
                            <div class="col-2">
                                <input type="number" class="form-control bobot-input" name="indicators[0][bobot]" value="{{ $indicator->bobot }}" required>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-9">
                        <button type="button" id="addIndicatorBtn" class="btn btn-secondary">Add Indicator</button>
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control fw-bold" id="totalBobot" value="0" readonly>
                    </div>
                </div>
                <button type="submit" class="btn btn-tosca">Submit</button>
            </form> --}}

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Indicator</th>
                        <th>Target</th>
                        <th>Bobot</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($indicators as $no=>$indicator)
                    <tr>
                        <td>{{ $no+1 }}</td>
                        <td>{{ $indicator->aspect }}</td>
                        <td>{{ $indicator->target }}</td>
                        <td>{{ $indicator->bobot }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total Bobot</th>
                        <th></th>
                        <th></th>
                        <th>{{ $totalBobot }}</th>
                    </tr>
                </tfoot>
            </table>
            <div class="row d-f"></div>

        </div>
    </div>
</div>

@include('modal.delete')
@include('options.edit')

@section('script')

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      const entity = button.getAttribute('data-entity'); // e.g., 'position', 'department', etc.
      const id = button.getAttribute('data-id'); // Entity ID
      const name = button.getAttribute('data-name'); // Entity name (optional)
      
      // Update modal title and body text
      const entityNameElement = document.getElementById('entityName');
      entityNameElement.textContent = entity;
      
      // Update form action URL
      const form = document.getElementById('deleteForm');
      form.action = `/options/${entity}/${id}/delete`;

      // Optionally update the modal title to include the entity's name
      const modalTitle = document.getElementById('deleteModalLabel');
      modalTitle.textContent = `Delete ${entity.charAt(0).toUpperCase() + entity.slice(1)}: ${name}`;
    });
  });

  //Add Field on Edit Inicators for KPI
document.addEventListener('DOMContentLoaded', function() {
    let index = 1;
    const editIndicatorsContainer = document.getElementById('editIndicatorsContainer');
    const totalBobotInput = document.getElementById('totalBobot');
    const submitBtn = document.getElementById('submitBtn');

    document.getElementById('addEditIndicatorBtn').addEventListener('click', function() {
        console.log('Add Indicator button clicked');
        const container = document.getElementById('editIndicatorsContainer');
        const newIndicatorGroup = document.createElement('div');
        newIndicatorGroup.classList.add('edit-indicator-group', 'mb-3');
        newIndicatorGroup.innerHTML = `
            <div class="row">
                <div class="col-7">
                    <input type="text" class="form-control" name="indicators[${index}][name]" required>
                </div>
                <div class="col-2">
                    <input type="number" class="form-control" name="indicators[${index}][target]" required>
                </div>
                <div class="col-2">
                    <input type="number" class="form-control bobot-input" name="indicators[${index}][bobot]" required>
                </div>
                <div class="col-1">
                    <button type="button" class="btn btn-danger removeIndicatorBtn">
                        <i class="ri-delete-bin-fill"></i>
                    </button>
                </div>
            </div>
            `;
        container.appendChild(newIndicatorGroup);
        index++;
    });
// Remove indicator group
    document.addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('removeIndicatorBtn')) {
        const indicatorGroup = event.target.closest('.edit-indicator-group');
        indicatorGroup.remove();
        }
    });
 // Update total bobot whenever bobot fields change
 document.addEventListener('input', function(event) {
        if (event.target && event.target.classList.contains('bobot-input')) {
            updateTotalBobot();
        }
    });

    function updateTotalBobot() {
        let totalBobot = 0;
        const bobotInputs = document.querySelectorAll('.bobot-input');

        bobotInputs.forEach(input => {
            totalBobot += parseFloat(input.value) || 0;
        });

        totalBobotInput.value = totalBobot;

        // Enable or disable the submit button based on total bobot
        if (totalBobot === 100) {
            submitBtn.disabled = false;
        } else {
            submitBtn.disabled = true;
        }
    }
});


//Delete Modal
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
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token
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
                            text: data.message, // Use message from the server
                            icon: 'success'
                        }).then(() => {
                            // Reload the page or redirect to another route
                            window.location.href = data.redirect; // Redirect to the desired route
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