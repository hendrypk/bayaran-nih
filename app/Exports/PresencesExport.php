<?php

namespace App\Exports;

use App\Models\Presence;
use App\Repositories\Interfaces\PresenceRepositoryInterface;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PresencesExport implements FromQuery, WithMapping, WithHeadings, WithStyles, WithColumnFormatting, ShouldAutoSize
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
        return Presence::query()
            ->with('employee', 'workDay')
            ->whereBetween('date', [$this->start, $this->end])
            ->when($this->employee_id, function ($query) {
                $query->where('employee_id', $this->employee_id);
            });
    }

    public function map($row): array
    {
        return [
            $this->rowNumber++,
            $row->eid,
            $row->employee ? $row->employee->name : 'Unknown', 
            $row->workDay ? $row->workDay->name : 'Unknown',
            \PhpOffice\PhpSpreadsheet\Shared\Date::dateTimeToExcel(new \DateTime($row->date)), // Pastikan date dikonversi menjadi objek DateTime
            $row->check_in ? \PhpOffice\PhpSpreadsheet\Shared\Date::dateTimeToExcel(new \DateTime($row->check_in)) : '', // Check-in dikonversi jadi DateTime
            $row->check_out ? \PhpOffice\PhpSpreadsheet\Shared\Date::dateTimeToExcel(new \DateTime($row->check_out)) : '', // Check-out dikonversi jadi DateTime
            $row->note_in,
            $row->note_out,
            $row->late_arrival == 1 ? 'late' : 'ontime', 
            $row->late_check_in,
            $row->check_out_early,
            $row->leave,
            $row->leave_note,
            $row->leave_status == 1 ? 'accept' : 'reject',
        ];
    }
    

    public function headings(): array
    {
        return [
            [
                __('presence_report')
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
                __('work_day'),
                __('date'),
                __('check_in'),
                __('check_out'),
                __('note_in'),
                __('note_out'),
                __('late_arrival'),
                __('late_check_in'),
                __('check_out_early'),
                __('leave'),
                __('leave_note'),
                __('leave_status'),
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:K1')->getStyle('A1:K1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A2:B2')->getStyle('A2:B2')->getAlignment()->setHorizontal('left');
        $sheet->mergeCells('C2:G2');

        $sheet->getStyle('A3:I3')->getAlignment()->setHorizontal('center');
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
            'H' => '#,##0',
            'I' => '#,##0',
            'j' => '#,##0',
            'K' => '#,##0',
        ];
    }
}
