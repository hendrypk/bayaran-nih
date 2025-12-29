@props([
    'name' => 'date_picker_' . uniqid(),
    'label' => null,
    'range' => false
])

{{-- wire:ignore mencegah Livewire merusak instance Flatpickr saat update tabel --}}
<div class="group relative w-full" wire:ignore
     x-data="{ 
        value: @entangle($attributes->wire('model')),
        instance: null,
        isRange: {{ $range ? 'true' : 'false' }}
     }"
     x-init="
        instance = flatpickr($refs.dateInput, {
            mode: isRange ? 'range' : 'single',
            disableMobile: true,
            dateFormat: 'Y-m-d',
            altInput: true,
            altInputClass: 'form-input-puffy dark:bg-slate-950 dark:text-white pl-10 cursor-pointer',
            altFormat: isRange ? 'j M Y' : 'l, j F Y',
            static: true,
            {{-- Mengambil data awal dari variabel value --}}
            defaultDate: value ? (isRange && value.includes(' to ') ? value.split(' to ') : value) : null,
            onChange: (selectedDates, dateStr) => {
                if (isRange) {
                    if (selectedDates.length === 2) {
                        value = dateStr;
                    }
                } else {
                    value = dateStr;
                }
            }
        });

        {{-- Menjaga visual kalender sinkron jika data berubah dari server --}}
        $watch('value', newVal => {
            if (instance) {
                if (!newVal) {
                    instance.clear();
                    return;
                }
                const dates = isRange && newVal.includes(' to ') ? newVal.split(' to ') : newVal;
                instance.setDate(dates, false);
            }
        });
     ">
    
    @if($label)
        <label class="text-[10px] font-bold text-slate-400 uppercase ml-1 block mb-1">{{ $label }}</label>
    @endif

    <div class="relative flex items-center">
        <span class="absolute left-3 text-slate-400 z-10 pointer-events-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </span>

        <input x-ref="dateInput" 
               type="text" 
               readonly
               class="form-input-puffy w-full">
    </div>
</div>