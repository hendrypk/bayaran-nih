{{-- resources/views/components/ui/label.blade.php --}}
@props([
    'required' => false,
    'icon' => null,
    'label' => null,
    'name' => null,
])

<label for="{{ $name }}" 
       class="form-label-puffy">
           @if($icon)
        <iconify-icon icon="{{ $icon }}" class="text-slate-400"></iconify-icon>
    @endif

    {{ $slot }}

    @if($required)
        <span class="text-red-500">*</span>
    @endif
</label>
