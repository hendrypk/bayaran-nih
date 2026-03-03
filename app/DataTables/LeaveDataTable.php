<?php

namespace App\DataTables;

use App\Models\Leave;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LeaveDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $query
            ->leftJoin('employees', 'leaves.employee_id', '=', 'employees.id')
            ->select([
                'leaves.*',
                'employees.name as name',
                'employees.eid as eid',
            ])
            ->when(
                request()->filled(['date_start', 'date_end']),
                fn($q) => $q->whereBetween('leaves.start_date', [
                    request('date_start'),
                    request('date_end'),
                ]),
                fn ($q) => $q->whereRaw('1 = 0')
            )
            ->when(request('status'), function ($q, $status) {
                return match ($status) {
                    'pending' => $q->where('status', 'pending'),
                    'rejected' => $q->where('status', 'rejected'),
                    'accepted' => $q->where('status', 'accepted'),
                    default => $q,
                };
            })
            ->when(request('category'), function ($q, $category) {
                return match ($category) {
                    'annual' => $q->where('category', 'annual'),
                    'leave' => $q->where('category', 'leave'),
                    'sick' => $q->where('category', 'sick'),
                    'permit' => $q->where('category', 'permit'),
                    'halfday' => $q->where('category', 'halfday'),
                    default => $q,
                };
            });

        return (new EloquentDataTable($query))
            ->addColumn('date', function($leaves) {
                return '<span class="">' . formatDate($leaves->start_date) . '</span>';
            })
            ->addColumn('eid', function ($leaves) {
                return '<a href="' 
                    . route('employee.detail', ['id' => $leaves->employee_id]) 
                    . '"
                    . class="text-primary fw-normal text-decoration-none hover-underline">' 
                    . ($leaves->eid ?? '-') 
                    . '</a>';
            })
            ->editColumn('name', function ($leaves) {
                return '<a href="' 
                    . route('employee.detail', ['id' => $leaves->employee_id]) 
                    . '"
                    . class="text-primary fw-normal text-decoration-none hover-underline">' 
                    . ($leaves->employee->name ?? '-') 
                    . '</a>';
            })

            ->editColumn('category', function($leaves) {
                switch ($leaves->category) {
                    case 'annual':
                        return '<span class="px-3 py-1 rounded bg-success bg-opacity-10 text-success fw-semibold">Annual</span>';
                    case 'leave':
                        return '<span class="px-3 py-1 rounded bg-danger bg-opacity-10 text-danger fw-semibold">Leave</span>';
                    case 'permit':
                        return '<span class="px-3 py-1 rounded bg-primary bg-opacity-10 text-primary fw-semibold">Permit</span>';
                    case 'halfday':
                        return '<span class="px-3 py-1 rounded bg-warning bg-opacity-10 text-warning fw-semibold">Halfday</span>';
                    case 'sick':
                        return '<span class="px-3 py-1 rounded bg-secondary bg-opacity-10 text-secondary fw-semibold">Sick</span>';
                }
            })

            ->editColumn('status', function($leaves) {
                switch ($leaves->status) {
                    case 'pending':
                        return '<span class="px-3 py-1 rounded bg-success bg-opacity-10 text-success fw-semibold">Pending</span>';
                    case 'rejected':
                        return '<span class="px-3 py-1 rounded bg-danger bg-opacity-10 text-danger fw-semibold">Rejected</span>';
                    case 'accepted':
                        return '<span class="px-3 py-1 rounded bg-primary bg-opacity-10 text-primary fw-semibold">Accepted</span>';
                }
            })

            ->editColumn('created_at', function($leaves) {
                return '<span class="">' . formatTanggalWaktu($leaves->created_at) . '</span>';
            })

            ->editColumn('updated_at', function($leaves) {
                return '<span class="">' . formatTanggalWaktu($leaves->updated_at) . '</span>';
            })

            ->addColumn('action', function ($transaction) {
                $confirmedBtn = '<button class="dropdown-item" onclick="updateConfirmation(\''.$transaction->id.'\',\''.Transaction::STATUS_ACCEPTED.'\')"><i class="ph-check me-2"></i>'.__('general.accept').'</a>';
                $unconfirmedBtn = '<button class="dropdown-item" onclick="updateConfirmation(\''.$transaction->id.'\',\''.Transaction::STATUS_PENDING.'\')"><i class="ph-x-circle me-2"></i>'.__('wallet.label.not_confirmed').'</a>';
                $rejectBtn = '<button class="dropdown-item" x-on:click="$dispatch(\'open-x-ilz-modal\', {title:\''.__('wallet.label.reason_of_rejection').'\', modal:\'transaction.reject-modal-form\', args: {transactionId: ' . $transaction->id . '}})"><i class="ph-x me-2"></i>' . __('general.reject') . '</button>';
                $dropdown = '';
                if (auth()->user()->can(PermissionName::CONFIRM_TRANSACTION)){
                    if ($transaction->status == Transaction::STATUS_PENDING){
                        $btn = $confirmedBtn;
                        $btn .= $rejectBtn;
                    } else {
                        $btn = $unconfirmedBtn;
                    }
                    $dropdown = '<div class="d-inline-flex">
                            <div class="dropdown">
                                <a href="#" class="text-body" data-bs-toggle="dropdown">
                                    <i class="ph-list"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end" >
                                '.$btn.'
                                </div>
                            </div>
                        </div>';
                }
                return $dropdown;
            })

            ->setRowId('id')
            ->rawColumns(['eid', 'date', 'name', 'category', 'status', 'note', 'created_at', 'updated_at']);

    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Leave $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('leave-table')
                    ->columns($this->getColumns())
                    ->ajax([
                        'url' => route('leaves.datatable'),
                        'type' => 'GET',
                        'data' => 'function(d) {
                            d.date_start = startDate;
                            d.date_end = endDate;
                            d.category = category;
                            d.status = status;
                        }',
                    ])
                    ->parameters([
                        'lengthChange' => false,
                        'searching'    => false,
                        'dom'          => 'lrtip'
                    ])
                    ->orderBy(1)
                    ->selectStyleSingle()
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
            Column::make('date'),
            Column::make('eid'),
            Column::make('name'),
            Column::make('note'),
            Column::make('category'),
            Column::make('status'),
            // Column::make('created_at'),
            // Column::make('updated_at'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Leave_' . date('YmdHis');
    }
}
