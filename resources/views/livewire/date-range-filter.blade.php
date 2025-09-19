
<div class="{{ $class }}">
@php
    // Untuk input (tampilan)
    $displayStart = $startDate && $startDate != '' 
        ? formatDate($startDate) 
        : formatDate(now()->startOfMonth());

    $displayEnd = $endDate && $endDate != '' 
        ? formatDate($endDate) 
        : formatDate(now()); // ⬅️ pakai hari ini

    // Untuk JS (daterangepicker)
    $defaultStart = $startDate && $startDate != '' 
        ? \Carbon\Carbon::parse($startDate)->format('Y-m-d') 
        : now()->startOfMonth()->format('Y-m-d');

    $defaultEnd = $endDate && $endDate != '' 
        ? \Carbon\Carbon::parse($endDate)->format('Y-m-d') 
        : now()->format('Y-m-d'); // ⬅️ pakai hari ini
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
    let input = $('#dateRangeInput');
    if (!input.data('daterangepicker')) {
        input.daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear',
                format: 'YYYY-MM-DD'
            },
            startDate: "{{ $defaultStart }}",
            endDate: "{{ $defaultEnd }}"
        });

        // Helper JS untuk format lokal (samakan dengan formatDate di PHP)
        function formatIndo(dateStr) {
            const bulan = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];
            let d = new Date(dateStr);
            let tgl = ('0' + d.getDate()).slice(-2);
            let bln = bulan[d.getMonth()];
            let thn = d.getFullYear();
            return `${tgl} ${bln} ${thn}`;
        }

        // Set value input dan preview saat pertama kali load (format lokal)
        input.val("{{ $displayStart }} - {{ $displayEnd }}");
        $('.daterangepicker .drp-selected').text("{{ $displayStart }} - {{ $displayEnd }}");

        // Update preview dan input setiap kali tanggal berubah
        input.on('show.daterangepicker apply.daterangepicker', function(ev, picker) {
            let start = picker.startDate.format('YYYY-MM-DD');
            let end = picker.endDate.format('YYYY-MM-DD');
            let preview = formatIndo(start) + ' - ' + formatIndo(end);
            $('.daterangepicker .drp-selected').text(preview);
        });

        input.on('apply.daterangepicker', function(ev, picker) {
            let start = picker.startDate.format('YYYY-MM-DD');
            let end = picker.endDate.format('YYYY-MM-DD');
            @this.set('startDate', start);
            @this.set('endDate', end);
            @this.call('onDateRangeChanged', start, end);
            // Set input dengan format lokal
            $(this).val(formatIndo(start) + ' - ' + formatIndo(end));
        });

        input.on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            @this.set('startDate', '');
            @this.set('endDate', '');
            @this.call('onDateRangeChanged', '', '');
            $('.daterangepicker .drp-selected').text('');
        });
    }
});
</script>
@endpush
