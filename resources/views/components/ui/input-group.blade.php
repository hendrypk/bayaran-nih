{{-- EXAMPLE 

<x-ui.input-group
prefix="mdi:magnify"
wire:model.live.debounce.500ms="search"
type="text"
placeholder="Cari sesuatu di sini..."
/>
--}}

@props([
    'type' => 'text',
    'label' => null,
    'name' => null,
    'placeholder' => null,
    'prefix' => null,
    'suffix' => null,
])

<div class="{{ $attributes->get('class') }}">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
            {{ $label }}
        </label>
    @endif

    <div class="relative flex items-center">
        @if($prefix)
            <div class="absolute left-4 flex items-center pointer-events-none text-slate-400">
                <iconify-icon icon="{{ $prefix }}" width="20"></iconify-icon>
            </div>
        @endif

        <input 
            type="{{ $type }}"
            id="{{ $name }}"
            {{ $attributes->whereDoesntStartWith('class') }}
            placeholder="{{ $placeholder }}"
            class="form-input-puffy w-full {{ $prefix ? 'pl-11' : '' }} {{ $suffix ? 'pr-11' : '' }}"
        >

        @if($suffix)
            <div class="absolute right-4 flex items-center pointer-events-none text-slate-400">
                <iconify-icon icon="{{ $suffix }}" width="20"></iconify-icon>
            </div>
        @endif
    </div>
</div>