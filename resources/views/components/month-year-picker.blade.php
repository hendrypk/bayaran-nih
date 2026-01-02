{{-- <form action="{{ $action }}" method="GET" class="mb-3">
    <div class="row d-flex align-items-end">
        <div class="col-md-2">
            <label for="month" class="form-label">{{ __('general.label.select_month') }}</label>
            <select class="form-select" name="month">
                @foreach (range(1, 12) as $m)
                    @php
                        $monthName = DateTime::createFromFormat('!m', $m)->format('F');
                    @endphp
                    <option value="{{ $m }}" {{ $selectedMonth == $m ? 'selected' : '' }}>
                        {{ $monthName }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label for="year" class="form-label">{{ __('general.label.select_year') }}</label>
            <select class="form-select" name="year">
                @foreach (range(date('Y') - 1, date('Y') + 5) as $y)
                    <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3 align-self-end">
            <button type="submit" class="btn btn-tosca btn-sm">Filter</button>
        </div>
    </div>
</form> --}}
@props([
    'showMonth' => true,
    'showYear' => true,
    'selectedMonth' => date('n'),
    'selectedYear' => date('Y'),
])

<div class="flex flex-wrap items-center gap-4">
    {{-- Dropdown Bulan --}}
    @if($showMonth)
    <div class="w-full md:w-52 group" wire:ignore>
        {{-- <label class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase ml-1 mb-1.5 block tracking-[0.15em] group-hover:text-tosca-500 transition-colors">
            {{ __('Bulan') }}
        </label> --}}
        <select id="picker-month" class="select2-month-year w-full">
            @foreach (range(1, 12) as $m)
                <option value="{{ $m }}" {{ $selectedMonth == $m ? 'selected' : '' }}>
                    {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                </option>
            @endforeach
        </select>
    </div>
    @endif

    {{-- Dropdown Tahun --}}
    @if($showYear)
    <div class="w-full md:w-36 group" wire:ignore>
        {{-- <label class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase ml-1 mb-1.5 block tracking-[0.15em] group-hover:text-tosca-500 transition-colors">
            {{ __('Tahun') }}
        </label> --}}
        <select id="picker-year" class="select2-month-year w-full">
            @foreach (range(date('Y') - 5, date('Y') + 2) as $y)
                <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>
                    {{ $y }}
                </option>
            @endforeach
        </select>
    </div>
    @endif
</div>

@once
@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        const initSelect2 = () => {
            const config = {
                minimumResultsForSearch: Infinity,
                width: '100%',
                dropdownAutoWidth: true,
            };

            // Setup Select2 untuk Bulan
            if ($('#picker-month').length) {
                $('#picker-month').select2(config).on('change', function (e) {
                    @this.set('selectedMonth', e.target.value);
                });
            }

            // Setup Select2 untuk Tahun
            if ($('#picker-year').length) {
                $('#picker-year').select2(config).on('change', function (e) {
                    @this.set('selectedYear', e.target.value);
                });
            }

            // Styling Tailwind agar konsisten dengan tema
            // $('.select2-container--default .select2-selection--single').addClass('!h-[42px] !rounded-2xl !border-slate-200 dark:!border-slate-800 !flex !items-center !bg-white dark:!bg-slate-900 !transition-all');
            // $('.select2-container--default .select2-selection__rendered').addClass('!text-sm !font-bold !text-slate-700 dark:!text-slate-200 !pl-4');
            // $('.select2-container--default .select2-selection__arrow').addClass('!top-2 !right-2');
        }

        initSelect2();

        // Penting: Inisialisasi ulang jika Livewire melakukan update DOM
        Livewire.on('reinit-picker', () => {
            initSelect2();
        });
    });
</script>


@endpush
@endonce