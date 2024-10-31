@extends('_layout.main')
@section('title', 'Sales Summary')
@section('content')

<div class="col-lg-8">
    <div class="card px-1">
        <div class="card-body pt-2">
            <div class="row mb-4 mt-2 px-2">
                <div class="col-md-10">
                    <h5 class="card-title mb-0 py-2">Sales Detail for {{ $month }} {{ $year }}</h5>
                </div>
            </div>  
            <div class="row px-4">
                <table class="table-bordered">
                    <thead>
                        <th>Sales Person</th>
                        <th>Qty</th>
                    </thead>
                    <tbody>
                        @foreach($sales as $sale)
                        <tr>
                            <td>{{ $sale->employees->name }}</td>
                            <td>{{ $sale->qty }}</td>
                        </tr>

                        @endforeach
                    </tbody>
                    <tfoot>
                        <th>Total</th>
                        <th>{{ $total }}</th>
                    </tfoot>
                </table>
            </div>           
        </div>
    </div>
</div>

@endsection

