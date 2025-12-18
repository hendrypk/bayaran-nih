<?php

namespace App\Exports;

use App\Traits\FinalGradeTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FinalGradeExport implements FromCollection, WithHeadings, WithStyles
{
    use FinalGradeTrait;

    protected $selectedMonth, $selectedYear, $rowNumber = 1;

    public function __construct($selectedMonth, $selectedYear)
    {
        $this->selectedMonth = $selectedMonth;
        $this->selectedYear = $selectedYear;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $employees = $this->getEmployeesWithFinalGrade($this->selectedMonth, $this->selectedYear);

        return $employees->map(function ($employee) {
            return [
                $this->rowNumber++,
                $employee->eid, // EID
                $employee->name, // Name
                $this->selectedMonth, // Month
                $this->selectedYear, // Year
                $employee->kpiResults->isNotEmpty() ? $employee->kpiResults->first()->final_kpi : 0, // KPI
                $employee->paResults->isNotEmpty() ? $employee->paResults->first()->final_pa : 0, // PA
                $employee->finalGrade, // Final Grade
            ];
        });
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            // First heading row with merged cells
            [__('performance_management_report')],
            [__('period'), '', $this->selectedMonth . ' ' . $this->selectedYear],
            // Column headers for the table
            [
                __('number'),
                __('eid'),
                __('employee_name'),
                __('month'),
                __('year'),
                __('kpi'),
                __('pa'),
                __('final_grade'),
            ]
        ];
    }

    /**
     * Apply styles to the sheet
     *
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        // Merging cells for the title and period rows
        $sheet->mergeCells('A1:H1')->getStyle('A1:H1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A2:H2')->getStyle('A2:H2')->getAlignment()->setHorizontal('center');

        // Center align for the header row
        $sheet->getStyle('A3:H3')->getAlignment()->setHorizontal('center');

        // Set column widths to auto-size based on content
        foreach (range('A', 'H') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        
        // Applying styles
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
                        'rgb' => 'D9D9D9' // Gray background for the header row
                    ]
                ],
            ],
            'A3:H3' => [
                'font' => [
                    'bold' => true,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => 'D9D9D9' // Gray background for the header row
                    ]
                ],
            ]
        ];
    }
}
