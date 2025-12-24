{{-- resources/views/components/ui/input.blade.php --}}
@props([
    'type' => 'text',
    'label' => null,
    'name' => null,
    'model' => null,
    'placeholder' => null,
])

@if($label)
    <label for="{{ $name ?? $attributes->get('id') }}" 
           class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
        {{ $label }}
    </label>
@endif

@if($type === 'checkbox')
    <input type="checkbox"
           @if($name) id="{{ $name }}" @endif
           {{ $attributes->merge([
               'class' => 'w-6 h-6 rounded border-slate-300 text-tosca-600 focus:ring-tosca-500'
           ]) }}
           @if($model) wire:model="{{ $model }}" @endif
           placeholder="{{ $placeholder }}">
@else
    <input type="{{ $type }}"
           @if($name) id="{{ $name }}" @endif
           {{ $attributes->merge([
               'class' => 'block w-full rounded-md shadow-sm px-3 py-2
                           focus:border-tosca-500 focus:ring focus:ring-tosca-200
                           dark:bg-slate-700 dark:border-slate-600 dark:text-slate-100'
           ]) }}
           @if($model) wire:model="{{ $model }}" @endif
           placeholder="{{ $placeholder }}">
@endif
