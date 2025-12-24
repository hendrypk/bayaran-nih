{{-- resources/views/components/ui/label.blade.php --}}
@props([
    'label' => null,
    'name' => null,
])

<label for="{{ $name }}" 
       class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
    {{ $label }}
</label>
