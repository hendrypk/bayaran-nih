<button {{ $attributes->merge(['type' => 'button']) }} 
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
    {{ $slot }}
</button>
{{-- @props(['title', 'text', 'callback' => null, 'id' => null, 'url' => null, 'method' => 'POST'])

<button {{ $attributes->merge(['type' => 'button']) }} 
        x-data
        x-on:click="
        Swal.fire({
            title: '{{ $title }}',
            text: '{{ $text }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'Cancel',
            buttonsStyling: false,
            customClass: {
                popup: 'bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800',
                title: 'text-xl font-bold text-slate-800 dark:text-white',
                htmlContainer: 'text-sm text-slate-600 dark:text-slate-400',
                actions: 'gap-3', 
                confirmButton: 'inline-flex items-center px-5 py-2.5 bg-rose-500 text-white hover:bg-rose-600 rounded-xl font-semibold transition-all active:scale-95',
                cancelButton: 'inline-flex items-center px-5 py-2.5 bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 rounded-xl font-semibold transition-all active:scale-95'
            }
        }).then((result) => {
            if(result.isConfirmed){
                let id = {{ $id ?? 'null' }};
                let url = '{{ $url }}';
                let methodName = '{{ $callback }}';
                let httpMethod = '{{ strtoupper($method) }}';

                // 1. Opsi Livewire
                let lw = $el.closest('[wire\\:id]')?.__livewire;
                if (lw && methodName) {
                    lw.call(methodName, id);
                    return;
                }

                // 2. Opsi POST/DELETE via Dynamic Form
                if (url && httpMethod !== 'GET') {
                    const form = document.createElement('form');
                    form.method = 'POST'; // Browser hanya dukung POST untuk submit form
                    form.action = url;

                    // CSRF Token
                    const csrfToken = document.querySelector('meta[name=\'csrf-token\']')?.getAttribute('content');
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken;
                    form.appendChild(csrfInput);

                    // Method Spoofing (untuk DELETE/PUT)
                    if (httpMethod !== 'POST') {
                        const methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = httpMethod;
                        form.appendChild(methodInput);
                    }

                    document.body.appendChild(form);
                    form.submit();
                } 
                // 3. Opsi GET Biasa
                else if (url) {
                    window.location.href = url;
                }
            }
        })">
    {{ $slot }}
</button> --}}