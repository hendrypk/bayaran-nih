{{-- resources/views/components/ui/textarea.blade.php --}}
@props([
    'label' => null,
    'name' => null,
    'placeholder' => null,
    'rows' => null,
])

@if($label)
    <label for="{{ $name }}" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
        {{ $label }}
    </label>
@endif

<textarea id="{{ $name }}"
          rows="{{ $rows }}"
          {{ $attributes->merge([
              'class' => 'form-input-puffy'
          ]) }}
          placeholder="{{ $placeholder }}"></textarea>
