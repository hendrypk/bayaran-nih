@extends('_layout.main')
@section('title', 'Performance - KPI - Add New')
@section('content')

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Add New Employee KPI</h5>
                <form action="{{ route('kpi.create') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="row mb-3">
                        <div class="col-3 mb-5">
                            <label for="employee" class="form-label">Employee Name</label>
                            <select class="form-select" id="employee" name="employee" aria-label="Default select example">
                                <option value="" disabled selected>Select Employee</option>
                                @foreach ($employees as $employee)
                                {{-- <option value="{{ $employee->id }}" data-eid="{{ $employee->eid }}" data-position-id="{{ $employee->position_id }}" data-position="{{ $employee->position->name }}" >{{ $employee->name }}</option> --}}
                                <option value="{{ $employee->id }}" data-eid="{{ $employee->eid }}" data-kpi-id="{{ $employee->kpi_id }}" data-position="{{ $employee->position ? $employee->position->name : 'No Position' }}" >{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2 mb-5">
                            <label for="eid" class="form-label">EID</label>
                            <input class="form-control" name="eid" type="text" id="eid" aria-label="Disabled input example" disabled readonly>
                        </div>

                        <div class="col-3 mb-5">
                            <label for="position" class="form-label">Position</label>
                            <input class="form-control" name="position" type="text" id="position" aria-label="Disabled input example" disabled readonly>
                        </div>
                        <div class="col-2 mb-5">
                            <label for="inputEmail4" class="form-label">Month</label>
                            <select class="form-select" name="month" aria-label="Default select example">
                                @foreach(range(1, 12) as $month)
                                <option value="{{ DateTime::createFromFormat('!m', $month)->format('F') }}">{{ DateTime::createFromFormat('!m', $month)->format('F') }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2 mb-5">
                            <label for="inputEmail4" class="form-label">Year</label>
                            <select class="form-select" name="year" aria-label="Default select example">
                                @foreach(range(date('Y') - 0, date('Y') + 5) as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- <div class="">
                            <h5 class="title mb-0 py-3 fw-bold">Performance Indicator</h5>
                        </div> --}}

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold"> Aspect</div>
                        <div class="col-sm-2 fw-bold">Target</div>
                        <div class="col-sm-2 fw-bold">Bobot</div>
                        <div class="col fw-bold">Achievement</div>
                    </div>
                    
                    <div id="kpiIndicatorsContainer"></div>
                   
                    <div class="row mb-2 mt-3 justify-content-end">
                        <div class="d-grid gap-2 col-2">
                            <button type="" class="btn btn-untosca">Cancel</button>
                        </div>
                        <div class="d-grid gap-2 col-2">
                            <button type="submit" class="btn btn-tosca">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
document.getElementById('employee').addEventListener('change', function() {
    var selectedOption = this.options[this.selectedIndex];
    var kpiId = selectedOption.getAttribute('data-kpi-id');
    var position = selectedOption.getAttribute('data-position');
    var eid = selectedOption.getAttribute('data-eid');

    // Update the job title input with the selected employee's job title
    document.getElementById('position').value = position ? position : '';
    document.getElementById('eid').value = eid ? eid : '';

    if (kpiId) {
        fetchKpisByKpiId(kpiId);
    } else {
        console.error('KPI ID not found for the selected employee');
    }
});

function fetchKpisByKpiId(kpiId) {
    fetch(`/kpi/get-by-kpi-id/${kpiId}`)
        .then(response => response.json())
        .then(data => {
            updateKpiIndicators(data);
        })
        .catch(error => console.error('Error fetching KPIs:', error));
}

function updateKpiIndicators(indicators) {
    var indicatorContainer = document.getElementById('kpiIndicatorsContainer');
    indicatorContainer.innerHTML = ''; // Clear any existing content

    indicators.forEach(function(indicator) {
        var indicatorRow = `
            <div class="row mb-3">
                <label for="grade_${indicator.id}" class="col-md-4 form-label">${indicator.aspect}</label>
                <div class="col-sm-2">
                    <input type="number" class="form-control" value="${indicator.target}" disabled readonly>
                </div>
                <div class="col-sm-2">
                    <input type="number" class="form-control" value="${indicator.bobot}" disabled readonly>
                </div>
                <div class="col">
                    <input type="number" class="form-control" name="grades[${indicator.id}]" id="grade_${indicator.id}" step="0.01" min="0" required>
                </div>
            </div>
        `;
        indicatorContainer.insertAdjacentHTML('beforeend', indicatorRow);
    });
}

</script>

@endsection