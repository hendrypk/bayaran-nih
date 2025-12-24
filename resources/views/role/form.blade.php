<x-layouts.app>
    <x-slot:title>
        @lang('sidebar.label.role')
    </x-slot>

    <div class="px-4 py-2 m-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
        <h5 class="text-lg font-bold text-slate-800 dark:text-white">
            {{ __('role.label.add_role') }}
        </h5>
        
    </div>
    
    <div class="px-4 py-6 max-w-fit">
            <div class="p-6">
                @livewire('role-form')
            </div>
    </div>
</x-layouts.app>
