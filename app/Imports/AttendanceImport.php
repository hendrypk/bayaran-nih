<?php
namespace App\Imports;

use App\Models\Presence;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;

class AttendanceImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

    /**
     * Mengonversi baris data menjadi model
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Presence([
            'eid' => $row['eid'],
            'date' => \Carbon\Carbon::parse($row['date'])->format('Y-m-d'),
            'check_in' => \Carbon\Carbon::parse($row['check_in'])->format('H:i:s'),
            'check_out' => \Carbon\Carbon::parse($row['check_out'])->format('H:i:s'),
            'late_arrival' => $row['late_arrival'],
            'late_check_in' => $row['late_check_in'],
            'check_out_early' => $row['check_out_early'],
        ]);
    }

    /**
     * Validasi data saat impor
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'eid' => 'required|integer',
            'date' => 'required|date_format:Y-m-d',
            'check_in' => 'required|date_format:H:i:s',
            'check_out' => 'required|date_format:H:i:s',
            'late_arrival' => 'required|integer',
            'late_check_in' => 'required|integer',
            'check_out_early' => 'required|integer',
        ];
    }
}
