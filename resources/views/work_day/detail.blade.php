@extends('_layout.main')
@section('title', 'Detail Work Day')
@section('content')

<div class="row">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <h5 class="card-title">Work Day Detail of {{ $workDays->first()->name }}</h5>
                </div>
                <div class="col-md-1 align-self-center">
                    <a href="{{ route('workDay.edit', ['name' => $workDays->first()->name]) }}" class="btn btn-tosca">Edit</a>
                </div>
                <div class="col-md-1 align-self-center">
                    <a href="#" class="btn btn-untosca"
                    data-bs-toggle="modal" 
                    data-bs-target="#deleteModal" 
                    data-entity="work-day"  
                    data-name="{{ $workDays->first()->name }}"
                    data-id="{{ $workDays->first()->id }}">
                    Delete
                    </a>
                </div>

                <!-- <div class="col-md-1 align-self-center">
                    <a href="{{ route('workDay.delete', ['name' => $workDays->first()->name]) }}" class="btn btn-danger">Delete</a>
                </div> -->
            </div>            
            <div class="row mb-3">
                <table class="table datatable table-hover">
                    <thead class="table-primary">
                        <th>Day</th>
                        <th>Day Off</th>
                        <th>Arrival</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Break In</th>
                        <th>Break Out</th>
                        <th>Exclude Break</th>
                    </thead>
                    <tbody>
                        @foreach($workDays as $workDay)
                        <tr>
                            <td>{{ ucfirst($workDay->day) }}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" {{ $workDay->day_off == 1 ? 'checked' : '' }} disabled>
                                </div>
                            </td>
                            <!-- <td>{{ $workDay->arrival }}</td>
                            <td>{{ $workDay->check_in }}</td>
                            <td>{{ $workDay->check_out }}</td> -->
                            <td>
                            @if($workDay->day_off == 1)
                                Off
                            @else
                                <input type="time" class="form-control" name="arrival[{{ $workDay->day }}]" value="{{ $workDay->arrival }}" disabled>
                            @endif
                            </td>
                            <td>
                            @if($workDay->day_off == 1)
                                Off
                            @else
                                <input type="time" class="form-control" name="checkIn[{{ $workDay->day }}]" value="{{ $workDay->check_in }}" disabled>
                            @endif
                            </td>
                            <td>
                            @if($workDay->day_off == 1)
                                Off
                            @else
                                <input type="time" class="form-control" name="checkOut[{{ $workDay->day }}]" value="{{ $workDay->check_out }}" disabled>
                            @endif
                            </td>
                            <td>
                            @if($workDay->day_off == 1)
                                Off
                            @else
                                <input type="time" class="form-control" name="checkOut[{{ $workDay->day }}]" value="{{ $workDay->break_in }}" disabled>
                            @endif
                            </td>
                            <td>
                            @if($workDay->day_off == 1)
                                Off
                            @else
                                <input type="time" class="form-control" name="checkOut[{{ $workDay->day }}]" value="{{ $workDay->break_out }}" disabled>
                            @endif
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" {{ $workDay->break == 1 ? 'checked' : '' }} disabled>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row mb-3">
                <div class="col-md-2">
                    <label for="tolerance" class="fw-bold">Tolerance</label>
                    <span>: </span>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" value="{{ $workDays->first()->tolerance }} Minutes" disabled>
                </div>
            </div>
        </div>
    </div>
</div>
@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const deleteModal = document.getElementById('deleteModal');
    
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const name = button.getAttribute('data-name'); // WorkDay name
        
        // Set form action dynamically
        const form = document.getElementById('deleteForm');
        form.action = `/work-day/${name}/delete`;
        
        // Optionally update the modal text
        const entityNameElement = document.getElementById('entityName');
        entityNameElement.textContent = name;
    });
});

</script>
@endsection

@endsection

@include('modal.delete')



