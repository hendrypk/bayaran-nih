@props([
    'name' => 'date',
    'label' => null,
    'placeholder' => 'Pilih tanggal',
    'range' => false // Penentu mode: true untuk range, false untuk single
])

<div class="group relative w-full"
     x-data="{ 
        instance: null, 
        value: @entangle($attributes->wire('model')),
        isRange: {{ $range ? 'true' : 'false' }}
     }"
     x-init="
        instance = flatpickr($refs.dateInput, {
            mode: isRange ? 'range' : 'single',
            disableMobile: true,
            dateFormat: 'Y-m-d',
            altInput: true,
            altInputClass: 'form-input-puffy dark:bg-slate-950 dark:text-white pl-10',
            altFormat: isRange ? 'j M Y' : 'l, j F Y',
            static: true,
            defaultDate: value,
            onChange: (selectedDates, dateStr) => {
                // Untuk range, hanya update jika sudah pilih 2 tanggal (start & end)
                if (isRange) {
                    if (selectedDates.length === 2) {
                        value = dateStr;
                        $dispatch('change');
                    }
                } else {
                    value = dateStr;
                    $dispatch('change');
                }
            }
        });

        $watch('value', newVal => {
            if (instance) {
                if (newVal) {
                    // Jika range, pecah string 'to' agar flatpickr bisa render visualnya
                    const dateToSet = isRange && typeof newVal === 'string' ? newVal.split(' to ') : newVal;
                    instance.setDate(dateToSet, false);
                } else {
                    instance.clear();
                }
            }
        });
     ">
    
    @if($label)
        <label class="form-label-puffy block mb-1">{{ $label }}</label>
    @endif

    <div class="relative flex items-center">

        <input x-ref="dateInput" 
               type="text" 
               name="{{ $name }}" 
               readonly
               {{ $attributes->whereStartsWith('data-step') }}
               {{ $attributes->has('required') ? 'required' : '' }}
               placeholder="{{ $placeholder }}" 
               class="form-input-puffy w-full">
    </div>
</div>