@extends('_employee_app._layout_employee.main')
@section('content')

<!-- @if (session('message'))
    <div class="alert alert-danger">
        {{ session('message') }}
    </div>
@endif -->

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="release-tag-mobile" id="latestRelease"></div>
        <div class="section" id="user-section">
            <div id="user-detail" class="d-flex align-items-center">
                {{-- Avatar --}}
                <div class="">
                    <img src="{{ Auth::user()->getFirstMediaUrl('profile_photos') ?: asset('e-presensi/assets/img/avatar.jpg') }}" 
                        alt="Avatar" 
                        class="avatar">
                    {{-- <img src="{{ asset('e-presensi/assets/img/avatar.jpg') }}" alt=""
                        class="avatar"> --}}
                </div>
                {{-- User Info --}}
                <div id="user-info">
                    <h3 id="user-name" class="mb-0">{{ Auth::user()->name }}</h3>
                    <span id="user-role">{{ Auth::user()->position->name }} ({{ Auth::user()->eid }})</span>
                </div>
            </div>
            </div>
        </div>

        
        <div class="section" id="menu-section">
            <div class="card-menu">
                <div class="text-center">
                    <div class="list-menu">
                        <div class="item-menu text-center">
                            <div class="menu-card">
                                <a href="{{ route('presence.history') }}" class="tosca" style="font-size: 40px;">
                                    <img src="{{ asset('e-presensi/assets/img/attendance.png') }}" alt=""
                                       class="menu-icon">
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">{{ __('app.label.attendance') }}</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-card">
                                <a href="{{ route('overtime.history') }}">
                                    <img src="{{ asset('e-presensi/assets/img/app-overtime.png') }}" alt=""
                                       class="menu-icon">
                                </a>
                            </div>
                            <div class="menu-name">
                                {{ __('app.label.overtime') }}
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-card">
                                <a href="{{ route('laporHrIndex') }}" class="" style="font-size: 40px;">
                                    <img src="{{ asset('e-presensi/assets/img/lapor-hr.png') }}" alt=""
                                       class="menu-icon">
                                </a>
                            </div>
                            <div class="menu-name">
                                {{ __('option.label.lapor_hr') }}
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-card">
                                <a href="{{ route('leave.index') }}" class="tosca" style="font-size: 40px;">
                                    <img src="{{ asset('e-presensi/assets/img/on-leave.png') }}" alt=""
                                       class="menu-icon">
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">{{ __('app.label.permit') }}</span>
                            </div>
                        </div>
                    {{-- </div>
                    <div class="list-menu"> --}}
                        <div class="item-menu text-center">
                            @if(!empty($presenceToday) && $presenceToday->check_in && $presenceToday->check_out)
                                <div class="menu-card danger">
                                    <a href="javascript:void(0);" onclick="showAlert('check out')">
                                        <img src="{{ asset('e-presensi/assets/img/checkin.png') }}" alt="" class="menu-icon">
                                    </a>
                                </div>
                                <div class="menu-name danger">
                                    <span class="text-center">{{ __('app.label.check_out') }}</span>
                                </div>
                            @elseif(!empty($presenceToday->check_in) || empty($pastPresence->check_out) && !empty($pastPresence->check_in))
                                <div class="menu-card danger">
                                    <a href="{{ route('presence.out') }}" class="clickable-link">
                                        <img src="{{ asset('e-presensi/assets/img/checkin.png') }}" alt="" class="menu-icon">
                                    </a>
                                </div>
                                <div class="menu-name danger">
                                    <span class="text-center">{{ __('app.label.check_out') }}</span>
                                </div>
                            @elseif($leaveAccepted)
                                <div class="menu-card danger">
                                    <a href="javascript:void(0);" onclick="showAlert('has permit')">
                                        <img src="{{ asset('e-presensi/assets/img/checkin.png') }}" alt="" class="menu-icon">
                                    </a>
                                </div>
                                <div class="menu-name danger">
                                    <span class="text-center">{{ __('app.label.have_permit') }}</span>
                                </div>
                            @elseif(empty($presenceToday->check_in))
                                <div class="menu-card">
                                    <a href="{{ route('presence.in') }}" class="clickable-link">
                                        <img src="{{ asset('e-presensi/assets/img/checkin.png') }}" alt="" class="menu-icon">
                                    </a>
                                </div>
                                <div class="menu-name">
                                    <span class="text-center">{{ __('app.label.check_in') }}</span>
                                </div>
                            @else
                                <div class="menu-card danger">
                                    <a href="javascript:void(0);" onclick="showAlert('check out')">
                                        <img src="{{ asset('e-presensi/assets/img/checkin.png') }}" alt="" class="menu-icon">
                                    </a>
                                </div>
                                <div class="menu-name danger">
                                    <span class="text-center">{{ __('app.label.check_out') }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="item-menu text-center">
                            @if($overtimeToday && $overtimeToday->start_at && !$overtimeToday->end_at)
                                <div class="menu-card danger">
                                    <a href="{{ route('overtime.out') }}" class="clickable-link">
                                        <img src="{{ asset('e-presensi/assets/img/overtime-in.jpg') }}" alt="" class="menu-icon">
                                    </a>
                                </div>
                                <div class="menu-name danger">
                                    <span class="text-center">{{ __('app.label.overtime_out') }}</span>
                                </div>
                            @else
                                <div class="menu-card">
                                    <a href="{{ route('overtime.in') }}" class="clickable-link">
                                        <img src="{{ asset('e-presensi/assets/img/overtime-in.jpg') }}" alt="" class="menu-icon">
                                    </a>
                                </div>
                                <div class="menu-name">
                                    <span class="text-center">{{ __('app.label.overtime_in') }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-card">
                                <a href="javascript:void(0);" onclick="showAlert('coming soon')">
                                    <img src="{{ asset('e-presensi/assets/img/performance.png') }}" alt=""
                                       class="menu-icon">
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">{{ __('sidebar.label.performance') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="section mt-2" id="graph-section">
            <div class="card">
                <div class="card-chart">
                    <div class="chart-title mb-3">
                        {{ __('app.label.attendance_chart') }}
                    </div>
                    <canvas id="attendanceChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div> --}}
    </div>
    <!-- * App Capsule -->

    

@include('_employee_app.modal.presence')
@include('modal.message')

<script>
    function showAlert(type) {
        const messages = @json(__('messages'));

        // Mapping tipe ke pesan dan ikon yang sesuai
        const alertTypes = {
            'has permit': { icon: 'error', message: messages.has_permit },
            'check in': { icon: 'error', message: messages.already_check_in },
            'check out': { icon: 'error', message: messages.already_check_out },
            'overtime in': { icon: 'error', message: messages.already_overtime_in },
            'overtime out': { icon: 'error', message: messages.already_overtime_out },
            'coming soon': { icon: 'warning', message: messages.coming_soon }
        };

        // Jika tipe valid, tampilkan SweetAlert
        if (alertTypes[type]) {
            Swal.fire({
                icon: alertTypes[type].icon,
                title: 'Oops...',
                text: alertTypes[type].message,
            });
        }
    }

    document.addEventListener("DOMContentLoaded", () => {
        // Data dari controller
        const category = @json($chartData['labels']); // Ambil bulan dalam format string
        const presence = @json($chartData['data']); // Ambil total quantity
        const colors = ['#118ab2'];
        const total = presence.reduce((acc, value) => acc + value, 0);

        var ctx = document.getElementById('attendanceChart').getContext('2d');
        var educationChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: category,

                datasets: [{
                    data: presence, 
                    backgroundColor: '#118ab2', 
                    borderColor: '#118ab2',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.raw; 
                            }
                        }
                    },
                },
            }
        });
    });
</script>


@endsection

