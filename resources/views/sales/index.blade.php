@extends('_layout.main')
@section('title', 'Sales Summary')
@section('content')

<div class="row">
    <div class="col-md">
        <div class="card">
            <div class="card-body">
                <div class="card-header d-flex align-items-center py-0">
                    <h5 class="card-title mb-0 py-3">Sales Chart</h5>
                </div>
                <!-- <x-month-year-picker :action="route('sales.list')" :selectedYear="$selectedYear" /> -->
                <div id="salesChart"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md">
        <div class="card">
            <div class="card-body">
                <div class="card-header d-flex align-items-center py-0">
                    <h5 class="card-title mb-0 py-3">Sales List</h5>
                    @can('create sales')
                        <div class="ms-auto my-auto">
                            <button type="button" class="btn btn-tosca" data-bs-toggle="modal" data-bs-target="#addSales">Add Sales Report</button>
                        </div>
                    @endcan
                </div>
        
                <table class="table datatable table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Month</th>
                            <th scope="col">Year</th>
                            <th scope="col">Qty</th>
                            <th scope="col">View</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales as $no=>$sale)
                        <tr>
                            <th scope="row">{{ $no+1 }}</th>
                            <td>{{ $sale->month }}</td>
                            <td>{{ $sale->year }}</td>
                            <td> {{ $sale->Qty }}</td>
                            <td>
                                <a href="{{ route('sales.detail', [
                                'month' => $sale->month,
                                'year' => $sale->year]) }}"
                                class="btn btn-outline-primary">
                                <i class="ri-eye-fill"></i>
                                </a>
                            </td>
                            <td>
                                @can('update sales')
                                    <a href="{{ route('sales.edit', [
                                        'month' => $sale->month,
                                        'year' => $sale->year]) }}"
                                        class="btn btn-outline-success">
                                        <i class="ri-edit-fill"></i>
                                    </a>
                                @endcan
                            </td>
                            <td>
                                @can('delete sales')
                                    <button type="button" class="btn btn-outline-danger"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal" 
                                        data-entity="sales" 
                                        data-month="{{ $sale->month }}" 
                                        data-year="{{ $sale->year }}" >
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
</div>

@section('script')
<script>
//Script Sales Chart
document.addEventListener("DOMContentLoaded", () => {
        // Data dari controller
        const months = @json($chartData['month']); // Ambil bulan dalam format string
        const quantities = @json($chartData['total_qty']); // Ambil total quantity

        // Render chart dengan data dari database
        new ApexCharts(document.querySelector("#salesChart"), {
            series: [{
                name: 'Sales',
                data: quantities // Gunakan data qty
            }],
            chart: {
                height: 350,
                type: 'area',
                toolbar: {
                    show: false
                },
            },
            markers: {
                size: 4
            },
            colors: ['#4154f1'],
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.3,
                    opacityTo: 0.4,
                    stops: [0, 90, 100]
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            xaxis: {
                type: 'category', // Kategori x-axis adalah tipe kategori
                categories: months // Data bulan dalam format string
            },
            tooltip: {
                x: {
                    format: 'MMMM' // Format tooltip untuk menampilkan bulan penuh
                },
            }
        }).render();
    });

//Script for Delete Modal
document.addEventListener('DOMContentLoaded', function () {
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const entity = button.getAttribute('data-entity');
        const month = button.getAttribute('data-month'); 
        const year = button.getAttribute('data-year'); 
        
        // Update modal title and body text
        const entityNameElement = document.getElementById('entityName');
        entityNameElement.textContent = entity;

        // Set form action URL
        const form = document.getElementById('deleteForm');
        form.action = `/${entity}/${month}/${year}/delete`;

        // Set hidden input for appraisal ID
        document.getElementById('id').value = id;

        // Optionally update the modal title to include the entity's name
        const modalTitle = document.getElementById('deleteModalLabel');
        modalTitle.textContent = `Delete ${entity.charAt(0).toUpperCase() + entity.slice(1)}: ${month}`;
    });
});

//Add Field on Add Sales Person
document.addEventListener('DOMContentLoaded', function() {
    let index = 1;
    const salesContainer = document.getElementById('salesContainer');
    const totalQtynput = document.getElementById('totalQty');
    const submitBtn = document.getElementById('submitBtn');

    document.getElementById('addSalesBtn').addEventListener('click', function() {
        console.log('Add Sales button clicked');
        const container = document.getElementById('salesContainer');
        const newSalesGroup = document.createElement('div');
        newSalesGroup.classList.add('sales-group', 'mb-3');
        newSalesGroup.innerHTML = `
                            <div class="row mb-3">
                                <div class="col-md-7">
                                    <select class="form-select" name="sales[${index}][employee_id]" aria-label="Default select example">
                                        <option selected>Select Employeee</option>
                                        @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" class="form-control" name="sales[${index}][qty]" required>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger removeSalesBtn">
                                    <i class="ri-delete-bin-fill"></i>
                                    </button>
                                </div>
                            </div>

            `;
        container.appendChild(newSalesGroup);
        index++;
    });
// Remove indicator group
    document.addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('removeSalesBtn')) {
        const salesGroup = event.target.closest('.sales-group');
        salesGroup.remove();
        }
    });
 // Update total bobot whenever bobot fields change
 document.addEventListener('input', function(event) {
        if (event.target && event.target.classList.contains('qty-input')) {
            updateTotalQty();
        }
    });

    function updateTotalQty() {
        let totalBobot = 0;
        const qtyInputs = document.querySelectorAll('.qty-input');

        qtyInputs.forEach(input => {
            totalQty += parseFloat(input.value) || 0;
        });

        totalQtyInput.value = totalQty;
    }
});
</script>
@endsection

@include('sales.add')
@include('modal.delete')
@endsection