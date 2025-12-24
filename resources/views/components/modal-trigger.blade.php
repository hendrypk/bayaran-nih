{{-- <button
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
</button> --}}
<button
    x-data
    x-on:click="$dispatch('open-x-ilz-modal', { 
        title: '{{ $title }}', 
        modal: '{{ $modal }}', 
        args: {{ json_encode($args) }}, 
        size: '{{ $size }}' 
    })"
    class="{{ $attributes->has('class') 
        ? $attributes->get('class') 
        : 'inline-flex items-center p-2 text-sm font-medium text-white bg-cyan-500 hover:bg-cyan-600 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-lg transition-all' }}">
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
