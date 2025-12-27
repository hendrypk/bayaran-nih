<x-layouts.app>
    <x-slot:title>{{ __('sidebar.label.employee') }}</x-slot:title>
    <x-page-header>@lang('sidebar.label.add_employee')</x-page-header>
    <div class="px-4 py-2 mx-4 mb-4 ">
        @livewire('employee-form')
    </div>
</x-layouts.app>