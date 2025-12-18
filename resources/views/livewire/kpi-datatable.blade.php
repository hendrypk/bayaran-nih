<div>
    <table class="table datatable table-hover">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>@lang('employee.label.employee_name')</th>
                <th>@lang('general.label.month')</th>
                <th>@lang('general.label.year')</th>
                <th>@lang('performance.label.grade')</th>
                <th>@lang('general.label.view')</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gradeKpi as $kpi)
                <tr>
                    <td>{{ $kpi->id }}</td>
                    <td>{{ $kpi->employees->name }}</td>
                    <td>{{ DateTime::createFromFormat('!m', $kpi->month)->format('F') }}</td>
                    <td>{{ $kpi->year }}</td>
                    <td>{{ number_format($kpi->grade, 2) }}</td>
                    <td>                        
                        <x-modal-trigger
                            class="btn btn-blue"
                            title="Edit KPI"
                            modal="kpi-form"
                            :args="['id' => $kpi->id]"
                            size="xl">
                            <i class="ri-eye-fill"></i>
                        </x-modal-trigger>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $gradeKpi->links() }}
</div>
