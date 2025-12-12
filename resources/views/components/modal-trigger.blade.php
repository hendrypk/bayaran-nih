<button
        x-data
        x-on:click="$dispatch('open-x-ilz-modal', { 
            title: '{{ $title }}', 
            modal: '{{ $modal }}', 
            args: {{ json_encode($args) }}, 
            size: '{{ $size }}' 
        })"
        class="{{ $attributes->has('class') ? $attributes->get('class') : 'btn btn-primary' }}" data-toggle="modal"
>
    {{ $slot }}
</button>

{{-- <button
    x-data
    x-on:click="$dispatch('open-x-ilz-modal', { 
        title: '{{ $title }}', 
        modal: '{{ $modal }}', 
        args: {{ json_encode($args) }}, 
        size: '{{ $size }}' 
    })"
    class="{{ $class ?? 'btn btn-primary' }}" data-toggle="modal"
>
    {{ $slot }}
</button> --}}
