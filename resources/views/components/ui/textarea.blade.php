{{-- resources/views/components/ui/textarea.blade.php --}}
@props([
    'label' => null,
    'name' => null,
    'model' => null, // default wire:model
    'placeholder' => null,
    'rows' => 3,
])

@if($label)
    <label for="{{ $name }}" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
        {{ $label }}
    </label>
@endif

<textarea id="{{ $name }}"
          rows="{{ $rows }}"
          {{ $attributes->merge([
              'class' => 'block w-full rounded-md border-slate-300 shadow-sm px-3 py-2
                          focus:border-tosca-500 focus:ring focus:ring-tosca-200
                          dark:bg-slate-700 dark:border-slate-600 dark:text-slate-100'
          ]) }}
          @if($model) wire:model="{{ $model }}" @endif
          placeholder="{{ $placeholder }}"></textarea>
