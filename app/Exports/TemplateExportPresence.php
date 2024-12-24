<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class TemplateExportPresence implements FromCollection
{
    /**
     * Mengembalikan data template untuk file Excel
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect([
            // Header untuk file Excel
            ['eid', 'date', 'check_in', 'check_out', 'late_arrival', 'late_check_in', 'check_out_early'],
            // Baris contoh untuk template
            ['12345', '2024-12-01', '08:00:00', '17:00:00', 0, 0, 0],
            // Anda dapat menambahkan lebih banyak baris sesuai kebutuhan
        ]);
    }
}
