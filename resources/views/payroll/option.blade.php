@extends('_layout.main')
@section('title', 'Pay Slip Item Options')
@section('content')

<div class="row">

<!-- Position -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="card-header d-flex align-items-center py-0">
                    <h5 class="card-title mb-0 py-3">Earnings</h5>
                    <div class="ms-auto my-auto">
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addEarning">Add Earning</button>
                    </div>
                </div>
        
                <!-- Table with hoverable rows -->
                    <table class="table datatable table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Calculate</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($options as $option)
                            <tr>
                                <td scope="row">{{ $option->name }}</td>
                                <td scope="row">1</td>
                                <td scope="row">1</td>
                                <td scope="row">1</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                <!-- End Table with hoverable rows -->
            </div>
        </div>
    </div>

</div>

@include('modal.delete')
@endsection