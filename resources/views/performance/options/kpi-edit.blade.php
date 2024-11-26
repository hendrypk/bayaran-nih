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

</script>

@endsection
@endsection