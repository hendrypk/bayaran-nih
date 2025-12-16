@extends('_layout.main')
@section('title', __('sidebar.label.leave'))
@section('content')

{{ Breadcrumbs::render('leave') }}
<div class="row align-items-center">
    <div class="col-md-9">
        <x-absence-date-filter action="{{ route('leave.index') }}" 
                        :startDate="request()->get('start_date')" 
                        :endDate="request()->get('end_date')" />
    </div>
    <div class="col-md-3 d-flex justify-content-end">
        @can('create leave')
                    <x-modal-trigger
                        class="btn btn-tosca"
                        title="{{ __('attendance.label.add_leave') }}"
                        modal="leave-modal"
                        size="md">
                        <i class="ri-add-circle-line"></i>
                    </x-modal-trigger>
        @endcan
    </div>
</div>

<div class="row">
    <div class="col-md">
        <div class="card">
            <div class="card-body">
                <div class="card-header d-flex align-items-center py-0">
                    <div class="col-md-10">
                        <h5 class="card-title mb-0 py-3">{{ __('attendance.label.leave_list') }}</h5>
                    </div>
                </div>
                    <table class="table datatable table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ __('employee.label.eid') }}</th>
                                <th scope="col">{{ __('general.label.name') }}</th>
                                <th scope="col">{{ __('attendance.label.apply_date') }}</th>
                                <th scope="col">{{ __('attendance.label.absence_date') }}</th>
                                <th scope="col">{{ __('general.label.category') }}</th>
                                <th scope="col">{{ __('general.label.note') }}</th>
                                <th scope="col">{{ __('general.label.status') }}</th>
                                <th scope="col">{{ __('general.label.edit') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($leaves as $no=>$leave)
                            <tr>
                                <th scope="row">{{ $no+1 }}</th>
                                <td>{{ $leave->employee->eid }}</td>
                                <td>{{ $leave->employee->name }}</td>
                                <td>{{ formatDate($leave->created_at) }}</td>
                                <td>{{ formatDate($leave->start_date) }}</td>
                                <td>{{ ucfirst($leave->category) }}</td>
                                <td>{{ $leave->note }}</td>
                                <td>
                                    @if ($leave->status === 'accepted')
                                        <span class="px-2 py-1 rounded bg-success bg-opacity-10 text-success fw-semibold"><i class="ri-check-double-line"></i></span>
                                    @elseif ($leave->status === 'rejected')
                                        <span class="px-2 py-1 rounded bg-danger bg-opacity-10 text-danger fw-semibold"><i class="ri-close-line"></i></span>
                                    @else
                                        <span class="px-2 py-1 rounded bg-primary bg-opacity-10 text-primary fw-semibold"><i class="ri-time-line"></i></span>
                                    @endif
                                </td>
                                <td>
                                    @can('update leave')
                                        <x-modal-trigger
                                            class="btn btn-success btn-sm"
                                            title="{{ __('attendance.label.edit_leave') }}"
                                            modal="leave-modal"
                                            :args="['leaveId' => $leave->id]"
                                            size="md">
                                            <i class="ri-edit-line"></i>
                                        </x-modal-trigger>
                                    @endcan                                
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
</div>

@endsection