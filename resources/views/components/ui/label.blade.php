{{-- resources/views/components/ui/label.blade.php --}}
@props([
    'required' => false,
    'icon' => null,
    'label' => null,
    'for' => null, 
])

<label for="{{ $for }}" {{ $attributes->merge(['class' => 'form-label-puffy']) }}>
    @if($icon)
        <iconify-icon icon="{{ $icon }}" class="text-slate-400 mr-1"></iconify-icon>
    @endif

    {{ $slot->isEmpty() ? $label : $slot }}

    @if($required)
        <span class="text-red-500 font-bold ml-1">*</span>
    @endif
</label>