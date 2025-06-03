    @extends('_layout.main')
@section('title', 'Performance - KPI - Add New')
@section('content')

{{ Breadcrumbs::render('create_kpi') }}
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ __('performance.label.add_new_employee_kpi') }}</h5>
                <form action="{{ route('kpi.create') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="row mb-3">
                        <div class="col-3 mb-5">
                            <label for="employee" class="form-label">{{ __('general.label.name') }}</label>
                            <select class="select-form" id="employee" name="employee" aria-label="Default select example">
                                <option value="" disabled selected>Select Employee</option>
                                @foreach ($employees as $employee)
                                {{-- <option value="{{ $employee->id }}" data-eid="{{ $employee->eid }}" data-position-id="{{ $employee->position_id }}" data-position="{{ $employee->position->name }}" >{{ $employee->name }}</option> --}}
                                <option value="{{ $employee->id }}" data-eid="{{ $employee->eid }}" data-kpi-id="{{ $employee->kpi_id }}" data-position="{{ $employee->position ? $employee->position->name : '' }}" >{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2 mb-5">
                            <label for="eid" class="form-label">{{ __('employee.label.eid') }}</label>
                            <input class="input-form" name="eid" type="text" id="eid" aria-label="Disabled input example" disabled readonly>
                        </div>

                        <div class="col-3 mb-5">
                            <label for="position" class="form-label">{{ __('employee.label.position') }}</label>
                            <input class="input-form" name="position" type="text" id="position" aria-label="Disabled input example" disabled readonly>
                        </div>
                        <div class="col-2 mb-5">
                            <label for="inputEmail4" class="form-label">{{ __('general.label.month') }}</label>
                            <select class="select-form" name="month" aria-label="Default select example">
                                @foreach(range(1, 12) as $month)
                                <option value="{{ DateTime::createFromFormat('!m', $month)->format('F') }}">{{ DateTime::createFromFormat('!m', $month)->format('F') }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2 mb-5">
                            <label for="inputEmail4" class="form-label">{{ __('general.label.year') }}</label>
                            <select class="select-form" name="year" aria-label="Default select example">
                                @foreach(range(date('Y') - 1, date('Y') + 5) as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                    
                    <div id="kpiIndicatorsContainer"></div>
                   
                    <div class="row mb-2 mt-3 justify-content-end">
                        <div class="d-grid gap-2 col-2">
                            <a href="{{ url()->previous() }}" class="btn btn-red">{{ __('general.label.back') }}</a>
                        </div>
                        <div class="d-grid gap-2 col-2">
                            <button type="submit" class="btn btn-tosca">{{ __('general.label.save') }}</button>
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

    // Create table structure
    var table = `
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center" style="width: 5%;">No.</th>
                    <th class="text-center" style="width: 40%;">{{ __('performance.label.aspect') }}</th>
                    <th class="text-center" style="width: 20%;">{{ __('performance.label.target') }}</th>
                    <th class="text-center" style="width: 15%;">{{ __('performance.label.weight') }}</th>
                    <th class="text-center" style="width: 20%;">{{ __('performance.label.achievement') }}</th>
                </tr>
            </thead>
            <tbody>
    `;

    var index = 1;

    // Loop through each indicator to add a row in the table
    indicators.forEach(function(indicator) {
        table += `
            <tr>
                <td class="text-center">${index}</td>
                <td>${indicator.aspect}</td>
                <td class="text-end">
                    <input type="number" class="input-form text-end" value="${indicator.target}" disabled readonly>
                </td>
                <td class="text-end">
                    <input type="number" class="input-form text-end" value="${indicator.bobot}" disabled readonly>
                </td>
                <td>
                    <input type="text" class="input-form numeric-input text-end" name="grades[${indicator.id}]" id="grade_${indicator.id}" step="0.01" min="0" required>
                </td>
            </tr>
        `;
        index++;
    });

    // Close the table tags
    table += `
            </tbody>
        </table>
    `;

    // Insert the table into the container
    indicatorContainer.insertAdjacentHTML('beforeend', table);

    // Re-initialize numeric input formatting
    initializeNumericInput();
}


// function updateKpiIndicators(indicators) {
//     var indicatorContainer = document.getElementById('kpiIndicatorsContainer');
//     indicatorContainer.innerHTML = ''; // Clear any existing content

//     indicators.forEach(function(indicator) {
//         var indicatorRow = `
//             <div class="row mb-3">
//                 <label for="grade_${indicator.id}" class="col-md-4 form-label">${indicator.aspect}</label>
//                 <div class="col-sm-2">
//                     <input type="number" class="input-form" value="${indicator.target}" disabled readonly>
//                 </div>
//                 <div class="col-sm-2">
//                     <input type="number" class="input-form" value="${indicator.bobot}" disabled readonly>
//                 </div>
//                 <div class="col">
//                     <input type="text" class="input-form numeric-input" name="grades[${indicator.id}]" id="grade_${indicator.id}" step="0.01" min="0" required>
//                 </div>
//             </div>
//         `;
//         indicatorContainer.insertAdjacentHTML('beforeend', indicatorRow);
//     });

//     // Re-initialize numeric input formatting
//     initializeNumericInput();
// }

function initializeNumericInput() {
    const inputs = document.querySelectorAll('.numeric-input');
    inputs.forEach(function(input) {
        // Format on load
        formatInputValue(input);

        // Add event listener for user input
        input.addEventListener('input', function(e) {
            let value = e.target.value;
            value = value.replace(/[^0-9.]/g, ''); // Remove non-numeric chars
            let parts = value.split('.');
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            e.target.value = parts.join('.');
        });
    });

    function formatInputValue(input) {
        input.value = input.value.replace(/[^0-9.]/g, '') // Remove invalid chars
                                 .replace(/\B(?=(\d{3})+(?!\d))/g, ',') // Add thousands separators
                                 .replace(/(\..*)\./g, '$1'); // Handle multiple dots
    }
}


</script>

@endsection