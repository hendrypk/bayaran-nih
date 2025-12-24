<x-layouts.app>
    <x-slot:title>
        @lang('sidebar.label.user')
    </x-slot>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <div class="bg-white dark:bg-slate-900 shadow-sm rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                <h5 class="text-lg font-bold text-slate-800 dark:text-white">
                    {{ __('performance.label.kpi_long') }}
                </h5>
                @can('create pm')
                    <x-modal-trigger
                        modal="kpi-modal"
                        title="{{ __('performance.label.add_indicator') }}"
                        size="max-w-7xl">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3c7.2 0 9 1.8 9 9s-1.8 9-9 9s-9-1.8-9-9s1.8-9 9-9m3 9H9m3-3v6"/></svg>
                    </x-modal-trigger>
                @endcan
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-slate-700 uppercase bg-slate-50 dark:bg-slate-800/50 dark:text-slate-300">
                        <tr>
                            <th class="px-6 py-4 font-semibold w-16">#</th>
                            <th class="px-6 py-4 font-semibold">{{ __('general.label.name') }}</th>
                            <th class="px-6 py-4 font-semibold text-center w-24">{{ __('general.label.view') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                        @foreach($kpi_id as $no => $indicator)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">{{ $no+1 }}</td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-400 font-medium">{{ $indicator->name }}</td>
                            <td class="px-6 py-4 text-center">
                                @can('update pm')
                                    <x-modal-trigger
                                        class="inline-flex items-center p-2 bg-emerald-100 text-emerald-600 hover:bg-emerald-600 hover:text-white dark:bg-emerald-900/30 dark:text-emerald-400 dark:hover:bg-emerald-600 dark:hover:text-white rounded-lg transition-all"
                                        modal="kpi-modal"
                                        title="Edit KPI"
                                        size="max-w-7xl"
                                        :args="['id' => $indicator->id]">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m12 15l8.385-8.415a2.1 2.1 0 0 0-2.97-2.97L9 12v3zm4-10l3 3"/><path d="M9 7.07A7 7 0 0 0 10 21a7 7 0 0 0 6.929-6"/></g></svg>
                                    </x-modal-trigger>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 shadow-sm rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                <h5 class="text-lg font-bold text-slate-800 dark:text-white">
                    {{ __('performance.label.pa_long') }}
                </h5>
                @can('create pm')
                    <x-modal-trigger
                        modal="pa-modal"
                        title="{{ __('performance.label.add_appraisal') }}"
                        size="max-w-7xl">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3c7.2 0 9 1.8 9 9s-1.8 9-9 9s-9-1.8-9-9s1.8-9 9-9m3 9H9m3-3v6"/></svg>
                    </x-modal-trigger>
                @endcan
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-slate-700 uppercase bg-slate-50 dark:bg-slate-800/50 dark:text-slate-300">
                        <tr>
                            <th class="px-6 py-4 font-semibold w-16">#</th>
                            <th class="px-6 py-4 font-semibold">{{ __('general.label.name') }}</th>
                            <th class="px-6 py-4 font-semibold text-center w-24">{{ __('general.label.view') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                        @foreach($appraisal_id as $no => $appraisal)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">{{ $no+1 }}</td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-400 font-medium">{{ $appraisal->name }}</td>
                            <td class="px-6 py-4 text-center">
                                @can('update pm')
                                    <x-modal-trigger
                                        class="inline-flex items-center p-2 bg-emerald-100 text-emerald-600 hover:bg-emerald-600 hover:text-white dark:bg-emerald-900/30 dark:text-emerald-400 dark:hover:bg-emerald-600 dark:hover:text-white rounded-lg transition-all"
                                        modal="pa-modal"
                                        title="Edit PA"
                                        size="max-w-7xl"
                                        :args="['id' => $appraisal->id]">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m12 15l8.385-8.415a2.1 2.1 0 0 0-2.97-2.97L9 12v3zm4-10l3 3"/><path d="M9 7.07A7 7 0 0 0 10 21a7 7 0 0 0 6.929-6"/></g></svg>
                                    </x-modal-trigger>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <x-slot:scripts>
        <script>
            console.log('Halaman ini menggunakan component layout');
        </script>
    </x-slot>
</x-layouts.app>