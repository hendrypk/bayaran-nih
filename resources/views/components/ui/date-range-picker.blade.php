@props([
    'startDate' => null,
    'endDate' => null,
    'placeholder' => 'Pilih Tanggal'
])

<input x-data x-init="flatpickr($el, { 
        mode: 'range', 
        altInput: true,
        altFormat: 'j M Y', 
        dateFormat: 'Y-m-d',
        defaultDate: ['{{ $startDate }}', '{{ $endDate }}'],
        onClose: (dates) => { 
            if(dates.length === 2) {
                $wire.setDateRange(
                    flatpickr.formatDate(dates[0], 'Y-m-d'), 
                    flatpickr.formatDate(dates[1], 'Y-m-d')
                ) 
            }
        }
    })" 

    {{ $attributes->whereDoesntStartWith('wire:model') }}
    readonly 
    class="form-input-puffy w-full text-center cursor-pointer"
    placeholder="{{ $placeholder }}"
>