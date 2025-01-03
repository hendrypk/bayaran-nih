@extends('_layout.main')
@section('title', 'Employee Grade')
@section('content')

{{ Breadcrumbs::render('employee_grade') }}
<div class="row align-items-center">
    <div class="col-md-9">
        <x-month-year-picker :action="route('performance.grade')" :selectedMonth="$selectedMonth" :selectedYear="$selectedYear" />
    </div>
    <div class="col-md-3 d-flex justify-content-end">
        <a href="{{ route('performance.export', ['month' => $selectedMonth, 'year' => $selectedYear]) }}" class="btn btn-tosca">
            <i class="ri-download-cloud-2-fill"></i>
        </a>
    </div>
</div>

<div class="row">
{{-- <x-month-year-picker :action="route('performance.grade')" :selectedMonth="$selectedMonth" :selectedYear="$selectedYear" />
<a href="{{ route('performance.export', ['month' => $selectedMonth, 'year' => $selectedYear]) }}" class="btn btn-success">
    Export to Excel
</a> --}}


    <div class="col-lg">
        <div class="card">
            <div class="card-body">
                <div class="card-header d-flex align-items-center py-0">
                    <h5 class="card-title mb-0 py-3">Employee Grade for {{$selectedMonth}} {{$selectedYear}}</h5>
                </div>
        
                <!-- Table with hoverable rows -->
                    <table class="table datatable table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">EID</th>
                                <th scope="col">Employee Name</th>
                                <th scope="col">KPI</th>
                                <th scope="col">PA</th>
                                <th scope="col">Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach($employees as $employee)
                            <tr>
                                <th scope="row">1</th>
                                <td>{{ $employee->eid }}</td>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->final_kpi }}</td>
                                <td>{{ $employee->final_pa }}</td>
                                <td>{{ $employee->finalGrade }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                <!-- End Table with hoverable rows -->
            </div>
        </div>
    </div>
</div>

@endsection
@include('sales.add')