<button {{ $attributes->merge(['type' => 'button']) }} 
        x-data
        x-on:click="
        Swal.fire({
            title: '{{ $title }}',
            text: '{{ $text }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if(result.isConfirmed){
                @this.call('{{ $callback }}', {{ $id ?? 'null' }})
            }
        })">
    {{ $slot }}
</button>
