@props([
    'title' => 'Are you sure?',
    'text' => 'You won\'t be able to revert this!',
    'callback' => '',
    'id' => null,
    'type' => 'delete'
])

@php
    $defaultClass = "inline-flex items-center p-2 bg-rose-100 text-rose-600 hover:bg-rose-600 hover:text-white dark:bg-rose-900/30 dark:text-rose-400 dark:hover:bg-rose-600 dark:hover:text-white rounded-lg transition-all shadow-sm";
@endphp

<button {{ $attributes->merge(['type' => 'button'])->class([$defaultClass]) }} 
        x-data
        x-on:click="
        Swal.fire({
            title: '{{ $title }}',
            text: '{{ $text }}',
            icon: 'warning',
            allowOutsideClick: false,
            allowEscapeKey: false,
            stopKeydownPropagation: false,
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'Cancel',
            customClass: {
                popup: 'bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800',
                title: 'text-xl font-bold text-slate-800 dark:text-white',
                htmlContainer: 'text-sm text-slate-600 dark:text-slate-400',
                
                // Menambahkan jarak antar tombol
                actions: 'gap-3', 
                
                confirmButton: 'inline-flex items-center px-5 py-2.5 bg-rose-500 text-white hover:bg-rose-600 dark:bg-rose-600 dark:hover:bg-rose-700 rounded-xl font-semibold transition-all shadow-sm active:scale-95',
                
                // Reverse Color: Background Slate-100, Text Slate-600
                cancelButton: 'inline-flex items-center px-5 py-2.5 bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700 rounded-xl font-semibold transition-all active:scale-95'
            },
            buttonsStyling: false // WAJIB agar class Tailwind di atas tidak ditimpa style bawaan Swal
        }).then((result) => {
            if(result.isConfirmed){
                @this.call('{{ $callback }}', {{ $id ?? 'null' }})
            }
        })">
    
    @if ($slot->isNotEmpty())
        {{ $slot }}
    @else
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3m-5 5l4 4m0-4l-4 4"/>
        </svg>
    @endif
</button>
