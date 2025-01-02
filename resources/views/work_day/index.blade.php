@extends('_layout.main')
@section('title', 'Performance - KKPI')
@section('content')

{{ Breadcrumbs::render('work_day') }}
<div class="row">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <h5 class="card-title">Work Day</h5>
                </div>

                @can('create work pattern')
                    <div class="col-md align-content-center">
                        <button type="button" 
                            class="btn btn-untosca content-align-center" 
                            data-bs-toggle="modal" 
                            data-bs-target="#addWorkDay">
                            <i class="ri-add-circle-line"></i>
                        </button>
                    </div>
                @endcan

            </div>
            <table class="table datatable table-hover">
                <thead>
                    <th>#</th>
                    <th>Work Day Name</th>
                    <th>View</th>
                    <th>Delete</th>
                </thead>
                <tbody>
                    @foreach($workDays as $no=>$workDay)
                    <tr>
                        <td>{{ $no+1 }}</td>
                        <td>{{ $workDay->name }}</td>
                        {{-- <td>
                            <a href="{{ route('workDay.detail', ['name' => $workDay->name]) }}" class="btn btn-outline-primary">
                                <i class="ri-eye-fill"></i>
                            </a>
                        </td> --}}
                        <td>
                            @can('update work pattern')
                                <a href="{{ route('workDay.edit', ['name' => $workDay->name]) }}" class="btn btn-tosca">
                                    <i class="ri-edit-fill"></i>
                                </a>
                            @endcan
                        </td>
                        <td>
                            @can('delete work pattern')
                                {{-- <a href="" class="btn btn-outline-danger"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteModal" 
                                    data-entity="work-day"  
                                    data-id="{{ $workDays->first()->id }}" 
                                    data-name="{{ $workDays->first()->name }}" >
                                    <i class="ri-delete-bin-fill"></i>
                                </a> --}}
                                
                                <button type="button" class="btn btn-untosca" 
                                    onclick="confirmDelete('{{ $workDay->name }}', 'work-pattern')">
                                    <i class="ri-delete-bin-fill"></i>
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

@section('script') 
<script>
        $(document).ready(function() {
            // Disable time inputs if the holiday checkbox is checked
            $('input[type=checkbox]').on('change', function() {
                var day = $(this).attr('id').split('-')[0];
                var isHoliday = $(this).is(':checked');
                $('#' + day + '-start').prop('disabled', isHoliday);
                $('#' + day + '-end').prop('disabled', isHoliday);
            });
        });

//Delete Modal
    document.addEventListener('DOMContentLoaded', function () {
    const deleteModal = document.getElementById('deleteModal');

    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const name = button.getAttribute('data-name'); // WorkDay Name
        
        // Set form action dynamically
        const form = document.getElementById('deleteForm');
        form.action = `/work-day/${name}/delete`;
        
        // Optionally update the modal text
        const entityNameElement = document.getElementById('entityName');
        entityNameElement.textContent = name;
    });
});

    function confirmDelete(name, entity) {
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
                fetch(`/${entity}/${name}/delete`, { 
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

//Disabled if Day-Off
document.addEventListener('DOMContentLoaded', function () {
    // Define the toggleTimeInputs function
    function toggleTimeInputs(day) {
        const isDayOff = document.querySelector(`input[id="dayOff[${day}]"]`).checked;
        const isBreak = document.querySelector(`input[id="break[${day}]"]`).checked;

        // Disable all time inputs if day-off is checked
        if (isDayOff) {
            document.querySelector(`input[id="arrival[${day}]"]`).disabled = true;
            document.querySelector(`input[id="checkIn[${day}]"]`).disabled = true;
            document.querySelector(`input[id="checkOut[${day}]"]`).disabled = true;
            document.querySelector(`input[id="breakIn[${day}]"]`).disabled = true;
            document.querySelector(`input[id="breakOut[${day}]"]`).disabled = true;
            document.querySelector(`input[id="break[${day}]"]`).disabled = true;
        } else {
            document.querySelector(`input[id="arrival[${day}]"]`).disabled = false;
            document.querySelector(`input[id="checkIn[${day}]"]`).disabled = false;
            document.querySelector(`input[id="checkOut[${day}]"]`).disabled = false;
            document.querySelector(`input[id="breakIn[${day}]"]`).disabled = false;
            document.querySelector(`input[id="breakOut[${day}]"]`).disabled = false;
            document.querySelector(`input[id="break[${day}]"]`).disabled = false;
        }
    }

    // Trigger the function when the checkbox changes
    document.querySelectorAll('input[type=checkbox]').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const day = this.id.match(/\[([^\]]+)\]/)[1]; // Extract the day from the checkbox ID
            toggleTimeInputs(day); // Call the function on checkbox change
        });

        // Trigger change event on page load to set the initial state
        checkbox.dispatchEvent(new Event('change'));
    });
});

</script>
@endsection
@endsection

@include('work_day.add')
@include('modal.delete')
