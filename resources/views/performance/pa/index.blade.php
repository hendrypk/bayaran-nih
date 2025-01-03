@extends('_layout.main')
@section('title', 'Performance - PA')
@section('content')

{{ Breadcrumbs::render('pa') }}
<div class="row">
<x-month-year-picker :action="route('pa.list')" :selectedMonth="$selectedMonth" :selectedYear="$selectedYear" />

    <div class="col-md">
        <div class="card">
            <div class="card-body">
                <div class="card-header d-flex align-items-center py-0">
                    <h5 class="card-title mb-0 py-3">Employee Appraisal</h5>
                    @can('create pa')
                        <div class="ms-auto my-auto">
                            <button type="button" class="btn btn-tosca" data-bs-toggle="modal" data-bs-target="#addPa">
                                <i class="ri-add-circle-line"></i></button>
                        </div>
                    @endcan
                </div>
        
                <!-- Table with hoverable rows -->
                    <table class="table datatable table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th class="text-center">Month</th>
                                <th class="text-center">Year</th>
                                <th class="text-center">EID</th>
                                <th class="text-center">Employee Name</th>
                                <th class="text-center">Grade</th>
                                <th class="text-center">Detail</th>
                                <th class="text-center">Edit</th>
                                <th class="text-center">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @foreach($averageGrades as $no=> $grade)
                                    @php
                                        $employee = $employees->firstWhere('id', $grade->employee_id);
                                    @endphp
                                <th scope="row">{{ $no+1 }}</th>
                                <td class="text-center">{{ $selectedMonth }}</td>
                                <td class="text-center">{{ $selectedYear }}</td>
                                <td class="text-center">{{ $employee->eid }}</td>
                                <td class="text-center">{{ $employee->name }}</td>  
                                <td class="text-center">{{ number_format($grade->average_grade, 2) }}</td>                               
                                <td class="text-center">
                                    <a href="{{ route('pa.detail', [
                                    'employee_id' => $employee->id,
                                    'month' => $selectedMonth,
                                    'year' => $selectedYear]) }}"
                                    class="btn btn-outline-primary">
                                    <i class="ri-eye-fill"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    @can('update pa')
                                        <a href="{{ route('pa.edit', [
                                            'employee_id' => $employee->id,
                                            'month' => $selectedMonth,
                                            'year' => $selectedYear]) }}"
                                            class="btn btn-outline-success">
                                            <i class="ri-edit-line"></i>
                                        </a>
                                    @endcan
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-danger" 
                                        onclick="confirmDelete({{ $grade->employee_id }}, '{{ $selectedMonth }}', '{{ $selectedYear }}', '{{ $grade->employees->name }}', 'KPI')">
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
@foreach ($averageGrades as $grade)
            @php
                $employee = $employees->firstWhere('id', $grade->employee_id);
            @endphp
            <tr>
                <td>{{ $employee->id ?? 'N/A' }}</td>
                <td>{{ $employee->name ?? 'N/A' }}</td>
                <td>{{ $selectedMonth }}</td>
                <td>{{ $selectedYear }}</td>
                <td>{{ number_format($grade->average_grade, 2) }}</td>
            </tr>
        @endforeach

@section('script')

<script>
document.getElementById('employee').addEventListener('change', function() {
    var selectedOption = this.options[this.selectedIndex];
    var paId = selectedOption.getAttribute('data-pa-id');

    if (paId) {
        fetchPasBypaId(paId);
    } else {
        console.error('KPI ID not found for the selected employee');
    }
});

function fetchPasBypaId(paId) {
    fetch(`/appraisal/get-by-pa-id/${paId}`)
        .then(response => response.json())
        .then(data => {
            updatePa(data);
        })
        .catch(error => console.error('Error fetching Pas:', error));
}

function updatePa(appraisals) {
    var appraisalContainer = document.getElementById('appraisalContainer');
    appraisalContainer.innerHTML = ''; // Clear any existing content

    var table = `
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center" style="width: 5%;">No.</th>
                    <th class="text-center" style="width: 60%;">Aspect</th>
                    <th class="text-center" style="width: 35%;">Grade</th>
                </tr>
            </thead>
            <tbody>
    `;
    
    let index = 1; // Inisialisasi nomor urut
    
    appraisals.forEach(function(appraisal) {
        table += `
            <tr>
                <td class="text-center">${index}</td> <!-- Nomor urut -->
                <td>${appraisal.aspect}</td>
                <td>
                    <input type="text" class="form-control numeric-input" name="grades[${appraisal.id}]" id="grade_${appraisal.id}" step="0.01" min="0" max="100" required>
                </td>
            </tr>
        `;
        index++; // Increment nomor urut
    });

    table += `
            </tbody>
        </table>
    `;

    // Masukkan tabel ke dalam container
    appraisalContainer.insertAdjacentHTML('beforeend', table);
}


//Script for Delete Modal
function confirmDelete(id, month, year, name, entity) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You are about to delete the " + entity + " " + name + " on " + month + " " + year,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '',
        cancelButtonColor: '',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/appraisal/${id}/${month}/${year}/delete`, { 
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token for Laravel
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

@include('performance.pa.add')
@include('modal.delete')
@endsection