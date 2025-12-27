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
           class="form-label-puffy">
        {{ $label }}
    </label>
@endif

@if($type === 'checkbox')
    <input type="checkbox"
           @if($name) id="{{ $name }}" @endif
           {{ $attributes->merge([
               'class' => 'form-input-puffy'
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
