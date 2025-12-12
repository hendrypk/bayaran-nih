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
        return (new EloquentDataTable($query->with('employee', 'workDay')))
            ->editColumn('eid', function ($presence) {
                return '<a href="' 
                    . route('employee.detail', ['id' => $presence->employee_id]) 
                    . '"
                    . class="">' 
                    . ($presence->employee->eid ?? '-') 
                    . '</a>';
            })
            ->editColumn('employee_id', function ($presence) {
                return '<a href="' 
                    . route('employee.detail', ['id' => $presence->employee_id]) 
                    . '"
                    . class="">' 
                    . ($presence->employee->name ?? '-') 
                    . '</a>';
            })
            ->editColumn('date', function($presence) {
                return '<span class="">' . formatDate($presence->date) . '</span>';
            })
            ->editColumn('work_day_id', function ($presence) {
            if (empty($presence->work_day_id)) {
                return '<span class="px-3 py-1 rounded bg-success bg-opacity-10 text-success fw-semibold">' . ($presence->leave ?? '-') . '</span>';
            }

                return '<a href="' 
                    . route('workDay.detail', ['id' => $presence->work_day_id]) 
                    . '">' 
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
                    '<x-modal-trigger class="btn btn-untosca" 
                        title="Edit Presensi" 
                        modal="presence-manual-modal" 
                        :args="[\'presenceId\' => ' . $presence->id . ']" 
                        size="lg">
                        Edit
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
                        Detail
                    </x-modal-trigger>'
                );

            })

            ->setRowId('id')
            ->rawColumns(['eid', 'employee_id', 'work_day_id', 'date', 'check_in', 'check_out', 'edit', 'detail']);
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
                    ])
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->parameters([
                        'lengthChange' => false,
                        'searching'    => false,
                        'dom'          => 'lrtip'
                    ])

                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
public function getColumns(): array
{
    return [
        Column::make('id'),
        Column::make('eid'),
        Column::make('employee_id')->_title('general.label.name'),
        Column::make('date'),
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
