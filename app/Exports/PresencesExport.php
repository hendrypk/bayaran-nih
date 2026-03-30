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
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PresencesExport implements FromQuery, WithMapping, WithHeadings, WithStyles, WithColumnFormatting, ShouldAutoSize
{
    protected $start, $end, $status, $user, $search;
    protected mixed $employee_id;
    protected int $rowNumber = 1;

    public function __construct($start, $end, $status, $user, $search = null)
    {
        $this->start  = $start;
        $this->end    = $end;
        $this->status = $status;
        $this->user   = $user;
        $this->search = $search;
    }

    public function query()
    {
        return Presence::query()
            ->with(['employee.position'])
            ->where('status', $this->status)
            ->whereBetween('date', [$this->start, $this->end])
            ->whereHas('employee', function ($q) {
                // Apply your Tenant/Org filter
                $q->sameOrg($this->user)
                  // Apply search if present
                  ->when($this->search, function($sq) {
                      $sq->where('name', 'like', '%' . $this->search . '%');
                  });
            });
    }

    public function map($row): array
    {
        return [
            $this->rowNumber++,
            $row->employee ? $row->employee->eid : 'Unknown', 
            $row->employee ? $row->employee->name : 'Unknown', 
            $row->workDay ? $row->workDay->name : 'Unknown',
            // \PhpOffice\PhpSpreadsheet\Shared\Date::dateTimeToExcel(new \DateTime($row->date)), // Pastikan date dikonversi menjadi objek DateTime
            // $row->check_in ? \PhpOffice\PhpSpreadsheet\Shared\Date::dateTimeToExcel(new \DateTime($row->check_in)) : '', // Check-in dikonversi jadi DateTime
            // $row->check_out ? \PhpOffice\PhpSpreadsheet\Shared\Date::dateTimeToExcel(new \DateTime($row->check_out)) : '', // Check-out dikonversi jadi DateTime
            $row->date->format('d F Y'),
            $row->status,
            $row->check_in,
            $row->check_out,
            $row->late_arrival == 1 ? 'late' : 'ontime', 
            $row->late_check_in,
            $row->check_out_early,
            $row->leave,
            $row->leave_note,
            $row->leave_status === null ? '' : ($row->leave_status == 1 ? 'accept' : 'reject')

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
                __('status'),
                __('check_in'),
                __('check_out'),
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
        $sheet->mergeCells('A1:O1')->getStyle('A1:O1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A2:B2')->getStyle('A2:B2')->getAlignment()->setHorizontal('left');
        $sheet->mergeCells('C2:D2')->getStyle('C2:D2')->getAlignment()->setHorizontal('left');
        

        $sheet->getStyle('A3:I3')->getAlignment()->setHorizontal('center');
        return [
            'A:O' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
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
            'E' => 'd mmm yyyy',
            'F' => 'hh:mm',
            'G' => 'hh:mm',
            'H' => '#,##0',
            'I' => '#,##0',
            'J' => '#,##0',
            'K' => '#,##0',
            'L' => '#,##0',
        ];
    }
}
