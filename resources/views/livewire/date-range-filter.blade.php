<div class="{{ $class }}">
@php
    // Display untuk input
    $displayStart = $startDate && $startDate != '' 
        ? formatDate($startDate) 
        : formatDate(now()->startOfMonth());

    $displayEnd = $endDate && $endDate != '' 
        ? formatDate($endDate) 
        : formatDate(now());

    // Untuk JS (daterangepicker)
    $defaultStart = $startDate && $startDate != '' 
        ? \Carbon\Carbon::parse($startDate)->format('Y-m-d') 
        : now()->startOfMonth()->format('Y-m-d');

    $defaultEnd = $endDate && $endDate != '' 
        ? \Carbon\Carbon::parse($endDate)->format('Y-m-d') 
        : now()->format('Y-m-d');
@endphp

<input
    type="text"
    id="dateRangeInput"
    class="form-control d-inline-block text-center"
    style="max-width: 250px;"
    readonly
    placeholder="Pilih rentang tanggal"
    value="{{ $displayStart && $displayEnd ? $displayStart . ' - ' . $displayEnd : '' }}"
/>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const input = $('#dateRangeInput');

    if (!input.data('daterangepicker')) {
        input.daterangepicker({
            autoUpdateInput: false,
            locale: { cancelLabel: 'Clear', format: 'YYYY-MM-DD' },
            startDate: "{{ $defaultStart }}",
            endDate: "{{ $defaultEnd }}"
        });

        function formatIndo(dateStr) {
            const bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
            let d = new Date(dateStr);
            let tgl = ('0' + d.getDate()).slice(-2);
            return `${tgl} ${bulan[d.getMonth()]} ${d.getFullYear()}`;
        }

        function updatePreview(start, end) {
            input.val(formatIndo(start) + ' - ' + formatIndo(end));
            $('.daterangepicker .drp-selected').text(formatIndo(start) + ' - ' + formatIndo(end));
        }

        function updateURL(start, end) {
            const params = new URLSearchParams(window.location.search);
            params.set('start_date', start);
            params.set('end_date', end);
            const newUrl = `${window.location.pathname}?${params.toString()}`;
            window.history.replaceState({}, '', newUrl);
        }

        // Set initial preview
        updatePreview("{{ $defaultStart }}", "{{ $defaultEnd }}");

        input.on('apply.daterangepicker', function(ev, picker) {
            const start = picker.startDate.format('YYYY-MM-DD');
            const end = picker.endDate.format('YYYY-MM-DD');

            // Update Livewire
            @this.set('startDate', start);
            @this.set('endDate', end);
            @this.call('onDateRangeChanged', start, end);

            // Update input preview
            updatePreview(start, end);

            // Update URL query string
            updateURL(start, end);
        });

        input.on('cancel.daterangepicker', function() {
            input.val('');
            $('.daterangepicker .drp-selected').text('');

            // Reset Livewire
            @this.set('startDate', '');
            @this.set('endDate', '');
            @this.call('onDateRangeChanged', '', '');

            // Remove from URL
            const params = new URLSearchParams(window.location.search);
            params.delete('start_date');
            params.delete('end_date');
            const newUrl = `${window.location.pathname}?${params.toString()}`;
            window.history.replaceState({}, '', newUrl);
        });
    }
});
</script>
@endpush
