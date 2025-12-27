@props(['name','label' => null,'placeholder' => 'Pilih tanggal'])

<div class="group relative"
     x-data="{ instance: null, value: @entangle($attributes->wire('model')) }"
     x-init="
        instance = flatpickr($refs.dateInput, {
            disableMobile: true,
            dateFormat: 'Y-m-d',
            altInput: true,
            altInputClass: 'form-input-puffy dark:bg-slate-950 dark:text-white',
            altFormat: 'l, j F Y',
            static: true,
            defaultDate: value,
            onChange: (selectedDates, dateStr) => {
                value = dateStr;
                // Kirim event change ke window agar 'version++' tertrigger
                $dispatch('change'); 
            }
        });
        $watch('value', newVal => {
            if (instance && newVal) instance.setDate(newVal, false);
            else if (instance) instance.clear();
        });
     ">
    @if($label)
        <label class="form-label-puffy">{{ $label }}</label>
    @endif
    <input x-ref="dateInput" 
           type="text" 
           name="{{ $name }}" 
           {{ $attributes->whereStartsWith('data-step') }}
           {{ $attributes->has('required') ? 'required' : '' }}
           placeholder="{{ $placeholder }}" 
           class="form-input-puffy">
</div>