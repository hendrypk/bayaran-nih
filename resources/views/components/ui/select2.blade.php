@props([
    'label' => null,
    'placeholder' => 'Pilih opsi',
    'options' => [],
    'multiple' => false,
])

<div class="group w-full"
     x-data="{ 
        value: @entangle($attributes->wire('model')), 
        instance: null 
     }"
     x-init="
        $nextTick(() => {
            instance = $($refs.selectInput).select2({
                width: '100%',
                placeholder: '{{ $placeholder }}',
                allowClear: true,
                selectionCssClass: 'form-input-puffy', // Memaksa container Select2 menggunakan class puffy
            });

            instance.val(value).trigger('change');

            instance.on('change', function () {
                value = $(this).val();
            });

            $watch('value', (newValue) => {
                instance.val(newValue).trigger('change.select2');
            });
        });
     ">
    @if($label)
        <label class="form-label-puffy">{{ $label }}</label>
    @endif

    <div wire:ignore class="w-full">
        <select x-ref="selectInput"
                {{ $multiple ? 'multiple' : '' }}
                {{ $attributes->merge(['class' => 'w-full']) }}>
            <option value=""></option>
            @foreach($options as $key => $text)
                <option value="{{ $key }}">{{ $text }}</option>
            @endforeach
        </select>
    </div>
</div>