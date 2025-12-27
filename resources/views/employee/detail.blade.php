<x-layouts.app>
    <x-slot:title>Detail Karyawan</x-slot:title>
    <x-page-header>Detail Karyawan</x-page-header>
    
    <div class="px-4 py-2 mx-4 mb-4">
        {{-- Mengirim ID ke mount() di EmployeeForm --}}
        @livewire('employee-form', ['id' => $id])
    </div>
</x-layouts.app>