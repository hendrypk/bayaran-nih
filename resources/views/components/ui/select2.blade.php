@props([
    'label' => null,
    'name' => null,
    'placeholder' => 'Pilih opsi',
    'options' => [],
    'multiple' => false,
])

<div class="group relative"
     x-data="{ 
        value: @entangle($attributes->wire('model')), 
        instance: null 
     }"
     x-init="
        $nextTick(() => {
            instance = $($refs.selectInput).select2({
                width: '100%',
                placeholder: '{{ $placeholder }}',
                allowClear: true
            });

            // Set nilai awal dari Livewire ke Select2
            instance.val(value).trigger('change');

            // Kirim nilai dari Select2 ke Livewire
            instance.on('change', function () {
                value = $(this).val();
            });

            // Monitor perubahan dari Livewire (luar) untuk update Select2
            $watch('value', (newValue) => {
                instance.val(newValue).trigger('change.select2');
            });
        });
     ">
    @if($label)
        <label class="form-label-puffy">{{ $label }}</label>
    @endif

    <select x-ref="selectInput"
            name="{{ $name }}"
            {{ $multiple ? 'multiple' : '' }}
            class="form-input-puffy w-full">
        @if(!$multiple)
            <option value=""></option>
        @endif
        @foreach($options as $key => $text)
            <option value="{{ $key }}">{{ $text }}</option>
        @endforeach
    </select>
</div>