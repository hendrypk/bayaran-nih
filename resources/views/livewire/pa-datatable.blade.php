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
            @foreach($gradePa as $pa)
                <tr>
                    <td>{{ $pa->id }}</td>
                    <td>{{ $pa->employees->name }}</td>
                    <td>{{ DateTime::createFromFormat('!m', $pa->month)->format('F') }}</td>
                    <td>{{ $pa->year }}</td>
                    <td>{{ number_format($pa->grade, 2) }}</td>
                    <td>
                        <x-modal-trigger
                            class="btn btn-blue"
                            title="Edit PA"
                            modal="pa-form"
                            :args="['paId' => $pa->id]"
                            size="xl">
                            <i class="ri-eye-fill"></i>
                        </x-modal-trigger>
                    </td>
                </tr>

            @endforeach
        </tbody>
    </table>

    {{ $gradePa->links() }}
</div>
