@props([
    'id' => 'datatable',
    'headers' => [],
])

<div class="overflow-x-auto">
    <table id="{{ $id }}" class="datatable min-w-full table-auto text-sm text-left border-collapse">
        <thead class="bg-slate-50 dark:bg-slate-800/50 text-slate-700 dark:text-slate-300">
            <tr class="border-b border-slate-200 dark:border-slate-700">
                @foreach($headers as $header)
                    <th class="px-6 py-3 font-semibold text-left">{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
            {{ $slot }}
        </tbody>
    </table>
</div>
