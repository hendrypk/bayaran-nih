<div class="modal fade" id="addSales" tabindex="-1" aria-labelledby="modalSales" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSales">Add Sales Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('sales.create') }}" method="POST">
                    @csrf   
                    <div class="mb-3">
                        <label for="inputName" class="form-label fw-bold">Month</label>
                        <select class="form-select" name="month" aria-label="Default select example">
                            @foreach(range(1, 12) as $month)
                            <option value="{{ DateTime::createFromFormat('!m', $month)->format('F') }}">{{ DateTime::createFromFormat('!m', $month)->format('F') }}</option>
                            @endforeach
                        </select>
                    </div>   
                    <div class="mb-3">
                        <label for="inputName" class="form-label fw-bold">Year</label>
                        <select class="form-select" name="year" aria-label="Default select example">
                            @foreach(range(date('Y') - 1, date('Y') + 5) as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="salesContainer">
                        <div class="sales-group mb-3">
                            <div class="row mb-3">
                            <div class="col-md-7">
                                    <label for="inputName" class="form-label fw-bold">Sales Person</label>
                                    <select class="form-select" name="sales[0][employee_id]" aria-label="Default select example">
                                        <option selected>Select Employeee</option>
                                        @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="inputQty" class="form-label fw-bold">Qty</label>
                                    <input type="number" id="qty" class="form-control" name="sales[0][qty]" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-8">
                            <button type="button" id="addSalesBtn" class="btn btn-untosca">Add Sales Person</button>
                        </div>
                        <!-- <div class="col-md-4">
                            <input type="text" class="form-control fw-bold" id="totalQty" value="0" readonly>
                        </div>
                        <div class="col-md-1">
                            
                        </div> -->
                    </div>
                    
                    <div class="content-align-end">
                        <button type="submit" class="btn btn-tosca">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>