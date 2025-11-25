@extends('_layout.main')
@section('title', isset($employee->id) ? __('employee.label.edit_employee') : __('sidebar.label.add_employee') )
@section('content')

@if(isset($employee->id))
    {{ Breadcrumbs::render('employee_form', 'edit', $employee) }}
@else
    {{ Breadcrumbs::render('employee_form', 'add') }}
@endif


<h5 class="card-title mt-3 text-center">
    {{ isset($employee->id) ? __('employee.label.edit_employee') : __('sidebar.label.add_employee') }}
</h5>
<div class="row justify-content-center">
    <div class="col-lg-8 col-md-6 col-sm-4">
        <div class="card">
            <div class="card-body">            
                <div class="container">
                    <form action="{{route('employee.submit')}}" method="POST" id="addEmployee">
                    @csrf
                        <div class="form-step card-employee">
                            @php
                                $biodata = [
                                    ['name' => 'name', 'required' => true, 'type' => 'text', 'label' => __('employee.label.full_name')],
                                    ['name' => 'place_birth', 'required' => true, 'type' => 'text', 'label' => __('employee.label.place_of_birth')],                                    
                                    ['name' => 'religion', 'required' => true, 'type' => 'select', 'label' => __('employee.label.religion'), 'options' => __('employee.options.religion'), 'placeholder' => __('employee.placeholders.select_religion')],
                                    ['name' => 'blood_type', 'type' => 'select', 'label' => __('employee.label.blood_type'), 'options' => $bloods, 'placeholder' => __('employee.placeholders.select_blood_type')],
                                    
                                    ['name' => 'gender', 'required' => true, 'type' => 'select', 'label' => __('employee.label.gender'), 'options' => __('employee.options.gender'), 'placeholder' => __('employee.placeholders.select_gender')],
                                    ['name' => 'date_birth','required' => true, 'type' => 'date', 'label' => __('employee.label.date_of_birth')],
                                    ['name' => 'marriage','required' => true, 'type' => 'select', 'label' => __('employee.label.marital_status'), 'options' => __('employee.options.marital_status'), 'placeholder' => __('employee.placeholders.select_marital_status')],
                                    ['name' => 'education','required' => true, 'type' => 'select', 'label' => __('employee.label.education'), 'options' => __('employee.options.education'), 'placeholder' => __('employee.placeholders.select_education')],
                                ];

                                $contact = [
                                    ['name' => 'city', 'required' => true, 'type' => 'textarea', 'label' => __('employee.label.identity_address')],
                                    ['name' => 'email', 'required' => true, 'type' => 'email', 'label' => __('employee.label.email')],
                                    ['name' => 'bank', 'required' => true, 'type' => 'select', 'label' => __('employee.label.bank'), 'options' => $banks, 'placeholder' => __('employee.placeholders.select_bank')],
                                    ['name' => 'domicile', 'required' => true, 'type' => 'textarea', 'label' => __('employee.label.current_address')],
                                    ['name' => 'whatsapp', 'required' => true, 'type' => 'number', 'label' => __('employee.label.whatsapp')],
                                    ['name' => 'bank_number', 'required' => true, 'type' => 'number', 'label' => __('employee.label.bank_number')],
                                ];

                                $staffing = [
                                    ['name' => 'joining_date', 'required' => true, 'type' => 'date', 'label' => __('employee.label.joining_date'), 'max' => \Carbon\Carbon::now()->format('Y-m-d')],
                                    ['name' => 'employee_status', 'required' => true, 'type' => 'select', 'label' => __('employee.label.employee_status'), 'options' => $status->pluck('name', 'id')->toArray(), 'placeholder' => __('employee.placeholders.select_status')],
                                    ['name' => 'annual_leave', 'type' => 'input', 'label' => __('attendance.label.annual_leave_total')],
                                    ['name' => 'officeLocations', 'required' => true, 'type' => 'checkbox_group', 'label' => __('employee.label.office_location'), 'options' => $officeLocations->pluck('name', 'id')->toArray()],

                                    ['name' => 'position_id', 'required' => true, 'type' => 'select', 'label' => __('employee.label.position'), 'options' => $position->pluck('name', 'id')->toArray(), 'placeholder' => __('employee.placeholders.select_position')],
                                    ['name' => 'sales_status', 'required' => true, 'type' => 'select', 'label' => __('employee.label.sales_status'), 'options' => [1 => 'Yes', 0 => 'No'], 'default' => 0, 'placeholder' => __('employee.placeholders.select_status')],
                                    ['name' => 'due_annual_leave', 'type' => 'date', 'label' => __('attendance.label.annual_leave_due')],
                                    ['name' => 'workDay', 'required' => true, 'type' => 'checkbox_group', 'label' => __('employee.label.work_schedule'), 'options' => $workScheduleGroups->pluck('name', 'id')->toArray()],
                                ];

                                $performance = [
                                    ['name' => 'kpi_id', 'type' => 'select', 'label' => __('employee.label.kpi'), 'options' => $kpi_id->pluck('name', 'id')->toArray(), 'placeholder' => __('employee.placeholders.select_kpi')],
                                    ['name' => 'pa_id', 'type' => 'select', 'label' => __('employee.label.appraisal'), 'options' => $pa_id->pluck('name', 'id')->toArray(), 'placeholder' => __('employee.placeholders.select_appraisal')],
                                    ['name' => 'bobot_kpi', 'type' => 'number', 'label' => __('employee.label.kpi_weight'), 'min' => 0, 'max' => 100],
                                ];
                            @endphp

                            <div class="container step mb-3">
                                <h5 class="card-title text-center">{{ __('employee.label.biodata') }}</h5>
                                <input type="hidden" name="id" value="{{ $employee->id ?? '' }}">
                                <input type="hidden" name="eid" value="{{ $employee->eid ?? '' }}">

                                <div class="row mt-3">
                                    @php
                                        $chunks = array_chunk($biodata, ceil(count($biodata) / 2));
                                    @endphp

                                    @foreach ($chunks as $column)
                                        <div class="col-md-6">
                                            @foreach($column as $field)
                                                <div class="mb-3">
                                                    <label for="{{ $field['name'] }}" class="form-label">{{ $field['label'] }}</label>

                                                    @php
                                                        $oldValue = old($field['name'], $employee->{$field['name']} ?? null);
                                                    @endphp

                                                    @if($field['type'] === 'textarea')
                                                        <textarea 
                                                            name="{{ $field['name'] }}" 
                                                            id="{{ $field['name'] }}" 
                                                            rows="3" 
                                                            class="form-control" 
                                                            {{ $field['required'] ?? false ? 'required' : '' }}
                                                        >{{ $oldValue }}</textarea>

                                                    @elseif($field['type'] === 'select')
                                                        <select 
                                                            name="{{ $field['name'] }}" 
                                                            id="{{ $field['name'] }}" 
                                                            class="form-select" 
                                                            {{ $field['required'] ?? false ? 'required' : '' }}
                                                        >
                                                            <option value="" disabled {{ $oldValue === null ? 'selected' : '' }}>
                                                                {{ $field['placeholder'] ?? 'Select' }}
                                                            </option>
                                                            @foreach($field['options'] as $key => $option)
                                                                {{-- Kalau options associative array (id => name) --}}
                                                                @php
                                                                    $optionValue = is_array($field['options']) && is_string($key) ? $key : $option;
                                                                    $optionLabel = is_array($field['options']) && is_string($key) ? $option : $option;
                                                                @endphp
                                                                <option value="{{ $optionValue }}" {{ (string)$oldValue === (string)$optionValue ? 'selected' : '' }}>
                                                                    {{ $optionLabel }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                    @elseif($field['name'] === 'date_birth' || $field['type'] === 'date')
                                                        <input 
                                                            type="date" 
                                                            name="{{ $field['name'] }}" 
                                                            id="{{ $field['name'] }}" 
                                                            class="form-control" 
                                                            value="{{ $oldValue ?? '' }}" 
                                                            {{ $field['required'] ?? false ? 'required' : '' }}
                                                            max="{{ \Carbon\Carbon::now()->toDateString() }}"
                                                        >

                                                    @elseif($field['type'] === 'checkbox_group')
                                                        @php
                                                            // Checkbox group old value bisa array atau null
                                                            $oldValues = old($field['name'], []);
                                                            if (!is_array($oldValues)) $oldValues = [];
                                                        @endphp
                                                        @foreach($field['options'] as $optionValue => $optionLabel)
                                                            <div class="form-check">
                                                                <input
                                                                    class="form-check-input"
                                                                    type="checkbox"
                                                                    name="{{ $field['name'] }}[]"
                                                                    id="{{ $field['name'] }}_{{ $optionValue }}"
                                                                    value="{{ $optionValue }}"
                                                                    {{ in_array($optionValue, $oldValues) ? 'checked' : '' }}
                                                                >
                                                                <label class="form-check-label" for="{{ $field['name'] }}_{{ $optionValue }}">
                                                                    {{ $optionLabel }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <input 
                                                            type="{{ $field['type'] }}" 
                                                            name="{{ $field['name'] }}" 
                                                            id="{{ $field['name'] }}" 
                                                            class="form-control" 
                                                            value="{{ $oldValue ?? '' }}" 
                                                            {{ $field['required'] ?? false ? 'required' : '' }}
                                                        >
                                                    @endif

                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="container step mb-3">
                                <h5 class="card-title text-center">{{ __('employee.label.contact') }}</h5>
                                <div class="row mt-3">
                                    @php
                                        $chunks = array_chunk($contact, ceil(count($contact) / 2));
                                    @endphp

                                    @foreach ($chunks as $column)
                                        <div class="col-md-6">
                                            @foreach($column as $field)
                                                <div class="mb-3">
                                                    <label for="{{ $field['name'] }}" class="form-label">{{ $field['label'] }}</label>
                                                    
                                                    @php
                                                        $oldValue = old($field['name'], $employee->{$field['name']} ?? null);
                                                    @endphp

                                                    @if($field['type'] === 'textarea')
                                                        <textarea name="{{ $field['name'] }}" id="{{ $field['name'] }}" rows="3" class="form-control" {{ $field['required'] ?? false ? 'required' : '' }}>{{ $oldValue }}</textarea>
                                                    @elseif($field['type'] === 'select')
                                                        <select name="{{ $field['name'] }}" id="{{ $field['name'] }}" class="form-select" {{ $field['required'] ?? false ? 'required' : '' }}>
                                                            <option value="" disabled {{ $oldValue === null ? 'selected' : '' }}>{{ $field['placeholder'] ?? 'Select' }}</option>
                                                            @foreach($field['options'] as $key => $option)
                                                                @php
                                                                    $optionValue = is_array($field['options']) && is_string($key) ? $key : $option;
                                                                    $optionLabel = is_array($field['options']) && is_string($key) ? $option : $option;
                                                                @endphp
                                                                <option value="{{ $optionValue }}" {{ (string)$oldValue === (string)$optionValue ? 'selected' : '' }}>{{ $optionLabel }}</option>
                                                            @endforeach
                                                        </select>
                                                    @else
                                                        <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" id="{{ $field['name'] }}" class="form-control" value="{{ $oldValue ?? '' }}" {{ $field['required'] ?? false ? 'required' : '' }}>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="container step mb-3">
                                <h5 class="card-title text-center">{{ __('employee.label.staffing') }}</h5>
                                <div class="row mt-3">
                                    @php
                                        $chunks = array_chunk($staffing, ceil(count($staffing) / 2));
                                    @endphp

                                    @foreach ($chunks as $column)
                                        <div class="col-md-6">
                                            @foreach($column as $field)
                                                <div class="mb-3">
                                                    <label for="{{ $field['name'] }}" class="form-label">{{ $field['label'] }}</label>

                                                    @php
                                                        $oldValue = old($field['name'], $employee->{$field['name']} ?? null);
                                                    @endphp

                                                    @if($field['type'] === 'textarea')
                                                        <textarea name="{{ $field['name'] }}" id="{{ $field['name'] }}" rows="3" class="form-control" {{ $field['required'] ?? false ? 'required' : '' }}>{{ $oldValue }}</textarea>
                                                    @elseif($field['type'] === 'select')
                                                        <select name="{{ $field['name'] }}" id="{{ $field['name'] }}" class="form-select" {{ $field['required'] ?? false ? 'required' : '' }}>
                                                            <option value="" disabled {{ $oldValue === null ? 'selected' : '' }}>{{ $field['placeholder'] ?? 'Select' }}</option>
                                                            @foreach($field['options'] as $id => $name)
                                                                <option value="{{ $id }}" {{ (string)$oldValue === (string)$id ? 'selected' : '' }}>{{ $name }}</option>
                                                            @endforeach
                                                        </select>
                                                    @elseif($field['type'] === 'checkbox_group')
                                                    @php
                                                        $oldValues = old($field['name'], $employee->{$field['name']}->pluck('id')->toArray() ?? []);
                                                        if (!is_array($oldValues)) $oldValues = json_decode($oldValues, true) ?? [];
                                                        $oldValues = array_map('strval', $oldValues); // make sure all values are strings
                                                    @endphp

                                                    @foreach($field['options'] as $optionValue => $optionLabel)
                                                        @php $optionValueStr = (string) $optionValue; @endphp
                                                        <div class="form-check">
                                                            <input
                                                                class="form-check-input"
                                                                type="checkbox"
                                                                name="{{ $field['name'] }}[]"
                                                                id="{{ $field['name'] }}_{{ $optionValueStr }}"
                                                                value="{{ $optionValueStr }}"
                                                                {{ in_array($optionValueStr, $oldValues) ? 'checked' : '' }}
                                                            >
                                                            <label class="form-check-label" for="{{ $field['name'] }}_{{ $optionValueStr }}">
                                                                {{ $optionLabel }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                    
                                                    @elseif($field['name'] === 'joining_date')
                                                        <input
                                                            type="date"
                                                            name="{{ $field['name'] }}"
                                                            id="{{ $field['name'] }}"
                                                            class="form-control" 
                                                            value="{{ $oldValue ?? '' }}"
                                                            max="{{ \Carbon\Carbon::now()->toDateString() }}"
                                                            {{ $field['required'] ?? false ? 'required' : '' }}
                                                        >
                                                    @elseif($field['name'] === 'leave_periode')
                                                        <input
                                                            type="date"
                                                            name="{{ $field['name'] }}"
                                                            id="{{ $field['name'] }}"
                                                            class="form-control" 
                                                            value="{{ $oldValue ?? '' }}"
                                                            min="{{ \Carbon\Carbon::now()->toDateString() }}"
                                                            {{ $field['required'] ?? false ? 'required' : '' }}
                                                        >
                                                    @else
                                                        <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" id="{{ $field['name'] }}" class="form-control" value="{{ $oldValue ?? '' }}" {{ $field['required'] ?? false ? 'required' : '' }}>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="container step mb-3">
                                <h5 class="card-title text-center">{{ __('sidebar.label.performance') }}</h5>
                                <div class="row mt-3">
                                    @php
                                        $chunks = array_chunk($performance, ceil(count($performance) / 2));
                                    @endphp

                                    @foreach ($chunks as $column)
                                        <div class="col-md-6">
                                            @foreach($column as $field)
                                                <div class="mb-3">
                                                    <label for="{{ $field['name'] }}" class="form-label">{{ $field['label'] }}</label>

                                                    @php $oldValue = old($field['name']). $employee->{$field['name']} ?? null; @endphp

                                                    @if($field['type'] === 'textarea')
                                                        <textarea name="{{ $field['name'] }}" id="{{ $field['name'] }}" rows="3" class="form-control" {{ $field['required'] ?? false ? 'required' : '' }}>{{ $oldValue }}</textarea>
                                                    @elseif($field['type'] === 'select')
                                                        <select name="{{ $field['name'] }}" id="{{ $field['name'] }}" class="form-select" {{ $field['required'] ?? false ? 'required' : '' }}>
                                                            <option value="" disabled {{ $oldValue === null ? 'selected' : '' }}>{{ $field['placeholder'] ?? 'Select' }}</option>
                                                            @foreach($field['options'] as $id => $name)
                                                                <option value="{{ $id }}" {{ (string)$oldValue === (string)$id ? 'selected' : '' }}>{{ $name }}</option>
                                                            @endforeach
                                                        </select>
                                                    @else
                                                        <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" id="{{ $field['name'] }}" class="form-control" value="{{ $oldValue ?? '' }}" {{ $field['required'] ?? false ? 'required' : '' }}>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="mt-3 d-flex justify-content-center">
                            <button type="button" class="btn btn-tosca me-2" id="prevBtn" onclick="nextPrev(-1)">Back</button>
                            <button type="button" class="btn btn-untosca me-2" id="nextBtn" onclick="nextPrev(1)" disabled>Next</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
    <script>
        let currentStep = 0;
        const steps = document.querySelectorAll('.step');
        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');

        showStep(currentStep);

        function showStep(index) {
            console.log('Current step:', index);
            steps.forEach((step, i) => {
                step.classList.remove('active', 'left', 'right');
                if (i < index) step.classList.add('left');
                else if (i > index) step.classList.add('right');
            });

            steps[index].classList.add('active');

            prevBtn.style.display = index === 0 ? 'none' : 'inline-block';
            // nextBtn.type = index === steps.length - 1 ? 'submit' : 'button';
            nextBtn.type = 'button';
            nextBtn.textContent = index === steps.length - 1 ? 'Submit' : 'Next';

            console.log('nextBtn.type:', nextBtn.type);
            console.log('nextBtn.text:', nextBtn.textContent);
            console.log('ste-.length', steps.length);
            checkInputs();
            attachInputListeners();
        }

        function nextPrev(n) {
            if (n === 1 && !validateForm()) return;

            if (currentStep === steps.length - 1 && n === 1) {
                $('#addEmployee').trigger('submit');
                return;
            }

            currentStep += n;
            if (currentStep >= steps.length) currentStep = steps.length - 1;
            if (currentStep < 0) currentStep = 0;
            showStep(currentStep);
        }

        function validateForm() {
            const inputs = steps[currentStep].querySelectorAll('input, select, textarea');
            let valid = true;

            inputs.forEach(input => {
                if (input.hasAttribute('required') && !input.value.trim()) {
                    input.classList.add('is-invalid');
                    valid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            return valid;
        }

        function checkInputs() {
            const inputs = steps[currentStep].querySelectorAll('input, select, textarea');
            let allFilled = true;

            inputs.forEach(input => {
                if (input.hasAttribute('required') && !input.value.trim()) {
                    allFilled = false;
                }
            });

            nextBtn.disabled = !allFilled;
        }

        function attachInputListeners() {
            const inputs = steps[currentStep].querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.addEventListener('input', checkInputs);
                input.addEventListener('change', checkInputs);
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            showStep(currentStep);
        });

    //Handle Submit
        $('#addEmployee').submit(function(e) {
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
                            window.location.href = response.route;
                        });
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        form.find('.is-invalid').removeClass('is-invalid');
                        form.find('.invalid-feedback').remove();

                        for (const field in errors) {
                            if (errors.hasOwnProperty(field)) {
                                const safeField = field.replace(/\./g, '\\.').replace(/\[\]/g, '');
                                const input = form.find(`[name="${field}"]`).length
                                    ? form.find(`[name="${field}"]`)
                                    : form.find(`[name="${safeField}[]"]`);

                                input.addClass('is-invalid');
                            }
                        }

                        const allErrors = Object.values(errors).flat().join('\n');

                        Swal.fire({
                            title: 'Validation Error!',
                            text: allErrors,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });

                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: xhr.responseJSON?.message || 'Something went wrong. Please contact administrator',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }

            });
        });
    </script>
@endsection
@endsection
