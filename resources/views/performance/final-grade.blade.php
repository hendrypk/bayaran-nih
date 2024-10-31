@extends('_layout.main')
@section('title', 'Employee Grade')
@section('content')

<div class="row">

<x-month-year-picker :action="route('performance.grade')" :selectedMonth="$selectedMonth" :selectedYear="$selectedYear" />

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
                                <td>{{optional($employee->GradeKpis->first())->final_kpi ?? '0.00' }}</td>
                                <td>{{ optional($employee->GradePas->first())->final_pa ?? '0.00' }}</td>
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