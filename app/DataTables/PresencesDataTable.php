<?php

namespace App\DataTables;

use App\Models\Presence;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PresencesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
    $query
        ->leftJoin('employees', 'presences.employee_id', '=', 'employees.id')
        ->select([
            'presences.*',
            'employees.name as name',
            'employees.eid as eid',
        ])
        ->when(
            request()->filled(['date_start', 'date_end']),
            fn ($q) => $q->whereBetween('presences.date', [
                request('date_start'),
                request('date_end'),
            ]),
            fn ($q) => $q->whereRaw('1 = 0') // force empty result jika tanggal belum dipilih
        )
        ->when(request('status'), function ($q, $status) {
            return match ($status) {
                'presence' => $q->where('status', 'presence'),
                'leave', 'sick', 'permit' => $q->where('status', $status),
                'absence' => $q->where('status', 'absence'),
                default => $q,
            };
        });

        return (new EloquentDataTable($query))
            ->filter(function ($query) {
                $search = request()->get('search')['value'] ?? null;
                if ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->orWhere('employees.name', 'like', '%'.$search.'%')
                          ->orWhere('employees.eid', 'like', '%'.$search.'%');
                    });
                }
            })

            ->addColumn('eid', function ($presence) {
                return '<a href="' 
                    . route('employee.detail', ['id' => $presence->employee_id]) 
                    . '"
                    . class="text-primary fw-normal text-decoration-none hover-underline">' 
                    . ($presence->eid ?? '-') 
                    . '</a>';

            })
            ->editColumn('name', function ($presence) {
                return '<a href="' 
                    . route('employee.detail', ['id' => $presence->employee_id]) 
                    . '"
                    . class="text-primary fw-normal text-decoration-none hover-underline">' 
                    . ($presence->employee->name ?? '-') 
                    . '</a>';
            })

            ->editColumn('date', function($presence) {
                return '<span class="">' . formatDate($presence->date) . '</span>';
            })

            ->editColumn('work_day_id', function ($presence) {
            if (empty($presence->work_day_id)) {
                return '-';
            }
                return '<a href="' 
                    . route('workDay.edit', ['id' => $presence->work_day_id]) 
                    . '"
                    . class="text-primary fw-normal text-decoration-none hover-underline">' 
                    . ($presence->workday->name ?? '-') 
                    . '</a>';
            })

            ->editColumn('check_in', function ($presence) {
                if (empty($presence->work_day_id)) {
                    return '';
                }
                return $presence->check_in ?: '-';
            })

            ->editColumn('check_out', function ($presence) {
                if (empty($presence->work_day_id)) {
                    return ''; 
                }
                return $presence->check_out ?: '-';
            })

            ->editColumn('edit', function ($presence) {
                if (empty($presence)) return '';

                return \Illuminate\Support\Facades\Blade::render(
                    '<x-modal-trigger class="btn btn-green" 
                        title="Edit Presensi" 
                        modal="presence-manual-modal" 
                        :args="[\'presenceId\' => ' . $presence->id . ']" 
                        size="lg">
                        <i class="ri-edit-box-fill"></i>
                    </x-modal-trigger>'
                );

            })

            ->editColumn('detail', function ($presence) {
                if (empty($presence)) return '';

                return \Illuminate\Support\Facades\Blade::render(
                    '<x-modal-trigger class="btn btn-tosca" 
                        title="Detail Presensi" 
                        modal="presence-detail-modal" 
                        :args="[\'id\' => ' . $presence->id . ']" 
                        size="xl">
                        <i class="ri-eye-fill"></i>
                    </x-modal-trigger>'
                );

            })

            ->setRowId('id')
            ->rawColumns(['eid', 'name', 'employee_id', 'work_day_id', 'date', 'check_in', 'check_out', 'edit', 'detail']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Presence $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('presences-table')
                    ->columns($this->getColumns())
                    ->ajax([
                        'url' => route('presences.datatable'),
                        'type' => 'GET',
                        'data' => 'function(d) {
                            d.date_start = startDate;
                            d.date_end = endDate;
                            d.status = status;
                        }',
                    ])
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->parameters([
                        'lengthChange' => false,
                        'searching'    => true,
                        'dom'          => 'lrtip'
                    ])
                        ->buttons([
                            [
                                'extend' => 'print',
                                'text' => __('Print'),
                                'title' => 'function() { return "Sales Quotation " + moment(startDate, "YYYY-MM-DD").format("D MMMM YYYY") + " - " + moment(endDate, "YYYY-MM-DD").format("D MMMM YYYY"); }',
                                'exportOptions' => ['modifier' => ['selected' => true]],
                                'className' => 'd-none',
                            ],
            //                [
            //                    'extend' => 'excelHtml5',
            //                    'text' => __('Excel'),
            //                    // use dynamic file name based on startDate and endDate in javascript
            //                    'filename' => 'function() { return "Sales Quotation_" + moment(startDate, "YYYY-MM-DD").format("D MMMM YYYY") + " - " + moment(endDate, "YYYY-MM-DD").format("D MMMM YYYY"); }',
            //                    'title' => 'function() { return "Sales Quotation " + moment(startDate, "YYYY-MM-DD").format("D MMMM YYYY") + " - " + moment(endDate, "YYYY-MM-DD").format("D MMMM YYYY"); }',
            //                    'exportOptions' => ['modifier' => ['selected' => true]],
            //                    'className' => 'd-none',
            //                ],
                        ]);
    }

    /**
     * Get the dataTable columns definition.
     */
public function getColumns(): array
{
    return [
        Column::make('id'),
        Column::make('date'),
        Column::make('eid'),
        Column::make('name'),
        Column::make('status'),
        Column::make('work_day_id'),
        Column::make('check_in'),
        Column::make('check_out'),
        Column::make('edit'),
        Column::make('detail'),
    ];
}


    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Presences_' . date('YmdHis');
    }
}
