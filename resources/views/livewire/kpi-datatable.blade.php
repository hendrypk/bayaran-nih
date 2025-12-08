<div>
    <table class="table datatable table-hover">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>@lang('employee.label.employee_name')</th>
                <th>@lang('general.label.month')</th>
                <th>@lang('general.label.year')</th>
                <th>@lang('performance.label.grade')</th>
            </tr>
        </thead>
        <tbody>
            @forelse($gradeKpi as $item)
                <tr onclick="window.open('{{ route('kpi.detail', $item->id) }}', '_blank')" style="cursor: pointer;">
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->employees->name }}</td>
                    <td>{{ DateTime::createFromFormat('!m', $item->month)->format('F') }}</td>
                    <td>{{ $item->year }}</td>
                    <td>{{ number_format($item->grade, 2) }}</td>
                </tr>


            @empty
                <tr>
                    <td colspan="4" class="text-center">No data found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $gradeKpi->links() }}
</div>
