@extends('_layout.main')
@section('title', 'Sales Summary')
@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="container">
                    <h5 class="card-title">{{ __('sales.label.edit_sales_report') }} {{ $month }} {{ $year }} </h5>
                    <form action="{{ route('sales.update', ['month' => $month, 'year' => $year]) }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="mb-3">
                            <label for="inputName" class="form-label fw-bold">{{ __('general.label.month') }}</label>
                            <select class="select-form" name="month" aria-label="Default select example" disabled readonly>
                                
                                <option value="{{ $month }}">{{ $month }}</option>
                               
                            </select>
                        </div>   
                        <div class="mb-3">
                            <label for="inputName" class="form-label fw-bold">{{ __('general.label.year') }}</label>
                            <select class="select-form" name="year" aria-label="Default select example" disabled readonly>
                                <option value="{{ $year }}">{{ $year }}</option>
                            </select>
                        </div>

                        
                    <div class="row mb-3">
                        <div class="col-md-7 fw-bold">{{ __('sales.label.sales_person') }}</div>
                        <div class="col-md-3 fw-bold">{{ __('general.label.qty') }}</div>
                    </div>
<!-- 
                        <div id="salesContainer">
                        
                            <div class="sales-group mb-3">
                                <div class="row mb-3">
                                <div class="col-md-7">
                                    <select class="select-form" name="sales[0][employee_id]" aria-label="Default select example">
                                        @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                    @foreach($sales as $sale)
                                    <div class="col-md-3">
                                        <input type="number" value="{{$sale->qty}}" id="qty" class="input-form" name="sales[0][qty]" required>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div> -->
                        
                        <div id="salesContainer">
                            @foreach ($sales as $index => $sale)
                                <div class="sales-group mb-3">
                                    <div class="row mb-3">
                                        <div class="col-md-7">
                                            <select class="select-form" name="sales[{{ $index }}][employee_id]" aria-label="Default select example">
                                                @foreach($employees as $employee)
                                                    <option value="{{ $employee->id }}" {{ $employee->id == $sale->employee_id ? 'selected' : '' }}>
                                                        {{ $employee->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" class="input-form" name="sales[{{ $index }}][qty]" value="{{ $sale->qty }}" required>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-red removeSalesBtn">
                                                <i class="ri-delete-bin-fill"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <button type="button" id="addSalesBtn" class="btn btn-tosca">{{ __('sales.label.add_sales_person') }}</button>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end">

                            <a href="{{ url()->previous() }}" class="btn btn-red me-3">{{ __('general.label.back') }}</a>
                            <button type="submit" name="action" class="btn btn-tosca me-3">{{ __('general.label.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@section('script')
<script>
    //Add Field on Add Sales Person
    document.addEventListener('DOMContentLoaded', function() {
    let index = {{ count($sales) }}; // Start index from the number of existing sales
    const salesContainer = document.getElementById('salesContainer');

    document.getElementById('addSalesBtn').addEventListener('click', function() {
        const newSalesGroup = document.createElement('div');
        newSalesGroup.classList.add('sales-group', 'mb-3');
        newSalesGroup.innerHTML = `
            <div class="row mb-3">
                <div class="col-md-7">
                    <select class="select-form" name="sales[${index}][employee_id]" aria-label="Default select example">
                        <option selected disabled>- Select Employee -</option>
                        @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" class="input-form" name="sales[${index}][qty]" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-red removeSalesBtn">
                        <i class="ri-delete-bin-fill"></i>
                    </button>
                </div>
            </div>
        `;
        salesContainer.appendChild(newSalesGroup);
        index++;
    });


// document.addEventListener('DOMContentLoaded', function() {
//     let index = 1;
//     const salesContainer = document.getElementById('salesContainer');
//     const totalQtynput = document.getElementById('totalQty');
//     const submitBtn = document.getElementById('submitBtn');

//     document.getElementById('addSalesBtn').addEventListener('click', function() {
//         console.log('Add Sales button clicked');
//         const container = document.getElementById('salesContainer');
//         const newSalesGroup = document.createElement('div');
//         newSalesGroup.classList.add('sales-group', 'mb-3');
//         newSalesGroup.innerHTML = `
//                             <div class="row mb-3">
//                                 <div class="col-md-7">
//                                     <select class="select-form" name="sales[${index}][employee_id]" aria-label="Default select example">
//                                         <option selected disabled>- Select Employeee- </option>
//                                         @foreach($employees as $employee)
//                                         <option value="{{ $employee->id }}">{{ $employee->name }}</option>
//                                         @endforeach
//                                     </select>
//                                 </div>
//                                 <div class="col-md-3">
//                                     <input type="number" class="input-form" name="sales[${index}][qty]" required>
//                                 </div>
//                                 <div class="col-md-2">
//                                     <button type="button" class="btn btn-red removeSalesBtn">
//                                     <i class="ri-delete-bin-fill"></i>
//                                     </button>
//                                 </div>
//                             </div>

//             `;
//         container.appendChild(newSalesGroup);
//         index++;
//     });
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

@endsection