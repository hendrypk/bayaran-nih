<x-layouts.app>
    <x-slot:title>
        @lang('sidebar.label.role')
    </x-slot>

    <div class="px-4 py-2 m-2 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
        <h5 class="text-lg font-bold text-slate-800 dark:text-white">
            {{ __('role.label.role_detail') }}
        </h5>
    </div>
    <div class="px-4 py-2 max-w-fit">
        <div class="bg-white dark:bg-slate-900 shadow-lg rounded-xl border border-slate-200 dark:border-slate-800">
            <div class="p-6">
                <livewire:role-form :id="$role->id"/>
            </div>
        </div>
    </div>
</x-layouts.app>
