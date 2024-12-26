<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

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

    public function headings(): array
    {
        return ['eid', 'date', 'check_in', 'check_out', 'late_arrival', 'late_check_in', 'check_out_early'];
    }

    public function columnFormats(): array
    {
        return [
            'B' => 'yyyy-mm-dd', // Format tanggal di kolom B (date)
            'C' => 'hh:mm:ss', // Format waktu di kolom C (check_in)
            'D' => 'hh:mm:ss', // Format waktu di kolom D (check_out)
        ];
    }
}
