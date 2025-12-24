<x-layouts.app>
    <x-slot:title>
        @lang('sidebar.label.work_day')
    </x-slot>

    {{-- Header Section --}}
    <div class="px-4 py-2 m-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
        <h5 class="text-lg font-bold text-slate-800 dark:text-white">
            {{ __('option.label.work_day') }}
        </h5>
        
        @can('create work pattern')
        <x-modal-trigger
            modal="work-day-form"
            title="Tambah Pola Kerja"
            size="max-w-7xl">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3c7.2 0 9 1.8 9 9s-1.8 9-9 9s-9-1.8-9-9s1.8-9 9-9m3 9H9m3-3v6"/></svg>
        </x-modal-trigger>
        @endcan
    </div>

    {{-- Content Section --}}
    <div class="bg-white dark:bg-slate-900 shadow-sm rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden mx-4">
        <x-ui.datatable 
            id="workDayTable" 
            :headers="['#', __('general.label.name'), 'Status', 'Pengguna', 'Edit']">

            @foreach($workDays as $no => $workDay)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                    <td class="text-center">{{ $no + 1 }}</td>
                    <td class="font-medium text-slate-700 dark:text-slate-200">
                        {{ $workDay->name }}
                    </td>
                    <td>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-cyan-100 text-cyan-800 dark:bg-cyan-900/30 dark:text-cyan-300">
                            {{ $workDay->total_working_days ?? 0 }} Hari Kerja
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center gap-2">
                            <iconify-icon icon="lucide:users" class="text-slate-400"></iconify-icon>
                            <span class="text-sm font-semibold text-slate-600 dark:text-slate-400">
                                {{ $workDay->total_employees ?? 0 }} <span class="text-[10px] font-normal">Orang</span>
                            </span>
                        </div>
                    </td>
                    <td>
                        @can('update work pattern')
                        <x-modal-trigger
                            class="inline-flex items-center p-1.5 bg-emerald-100 text-emerald-600 hover:bg-emerald-600 hover:text-white dark:bg-emerald-900/30 dark:text-emerald-400 dark:hover:bg-emerald-600 dark:hover:text-white rounded-lg transition-all"
                            modal="work-day-form"
                            :args="['id' => $workDay->id]"
                            title="Edit Pola Kerja"
                            size="max-w-7xl">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m12 15l8.385-8.415a2.1 2.1 0 0 0-2.97-2.97L9 12v3zm4-10l3 3"/><path d="M9 7.07A7 7 0 0 0 10 21a7 7 0 0 0 6.929-6"/></g></svg>
                        </x-modal-trigger>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </x-ui.datatable>
    </div>
</x-layouts.app>