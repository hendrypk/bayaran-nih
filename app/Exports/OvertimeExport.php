<?php

namespace App\Exports;

use App\Models\Overtime;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OvertimeExport implements FromQuery, WithMapping, WithHeadings, WithStyles, WithColumnFormatting, ShouldAutoSize
{
    protected $start, $end;
    protected mixed $employee_id;
    protected int $rowNumber = 1;

    public function __construct($date_start, $date_end, $employee_id=null)
    {
        if (empty($date_start) || empty($date_end)) {
            throw new \InvalidArgumentException('Start and end dates are required. Please select date!');
        }
    
        $this->start = $date_start;
        $this->end = $date_end;
        $this->employee_id = $employee_id;
    }

    public function query()
    {
        return Overtime::query()
            ->with('employees')
            ->whereBetween('date', [$this->start, $this->end])
            ->where('status', true)
            ->when($this->employee_id, function ($query) {
                $query->where('employee_id', $this->employee_id);
            });
    }

    public function map($row): array
    {
        return [
            $this->rowNumber++,
            $row->employees->eid,
            $row->employees ? $row->employees->name : 'Unknown', // Nama karyawan
            \PhpOffice\PhpSpreadsheet\Shared\Date::dateTimeToExcel(new \DateTime($row->date)), // Pastikan date dikonversi menjadi objek DateTime
            $row->start_at ? \PhpOffice\PhpSpreadsheet\Shared\Date::dateTimeToExcel(new \DateTime($row->start_at)) : '', // Check-in dikonversi jadi DateTime
            $row->end_at ? \PhpOffice\PhpSpreadsheet\Shared\Date::dateTimeToExcel(new \DateTime($row->end_at)) : '', // Check-out dikonversi jadi DateTime
            $row->total, 
        ];
    }
    

    public function headings(): array
    {
        return [
            [
                __('overtime_report')
            ],
            [
                __('period'),
                '',
                \Carbon\Carbon::parse($this->start)->isoFormat('DD MMM YYYY').' - '.\Carbon\Carbon::parse($this->end)->isoFormat('DD MMM YYYY')
            ],
            [
                __('number'),
                __('eid'),
                __('employee_name'),
                __('date'),
                __('start_at'),
                __('end_at'),
                __('total'),
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:G1')->getStyle('A1:G1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A2:B2')->getStyle('A2:B2')->getAlignment()->setHorizontal('left');
        $sheet->mergeCells('C2:G2');

        $sheet->getStyle('A3:G3')->getAlignment()->setHorizontal('center');
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 16
                ]
            ],
            2 => [
                'font' => [
                    'bold' => true,
                    'size' => 12
                ],
            ],
            3 => [
                'font' => [
                    'bold' => true,
                    'size' => 12
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => 'd9d9d9'
                    ]
                ],
            ],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => 'd mmm yyyy',
            'E' => 'hh:mm',
            'F' => 'hh:mm',
            'G' => '#,##0',
        ];
    }
}
