@extends('_employee_app._layout_employee.main')
@section('content')

<!-- @if (session('message'))
    <div class="alert alert-danger">
        {{ session('message') }}
    </div>
@endif -->

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="release-tag-mobile" id="releaseList"></div>
        <div class="section" id="user-section">
            <div id="user-detail">
                {{-- <div class="avatar">
                    <img src="" alt="" class="imaged w64 rounded">
                </div> --}}
                <div id="user-info">
                    <h2 id="user-name">{{ Auth::user()->name }}</h2>
                    <span id="user-role">{{ Auth::user()->position->name }} ({{ Auth::user()->eid }})</span>
                </div>
            </div>
        </div>

        
        <div class="section" id="menu-section">
            <div class="card">
                <div class="card-body text-center">
                    <div class="list-menu">
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                {{-- <button class="btn-untosca" style="font-size: 40px;">
                                    <i class="ri-map-pin-user-fill"></i>
                                </button> --}}
                                <a href="{{ route('profileIndex') }}" class="tosca" style="font-size: 40px;">
                                    <i class="ri-map-pin-user-fill"></i>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">{{ __('app.label.profile') }}</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="{{ route('leave.index') }}" class="tosca" style="font-size: 40px;">
                                    <i class="ri-flight-takeoff-fill"></i>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">{{ __('app.label.permit') }}</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="{{ route('presence.history') }}" class="tosca" style="font-size: 40px;">
                                    <i class="ri-file-history-line"></i>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">{{ __('app.label.attendance') }}</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="{{ route('overtime.history') }}" class="tosca" style="font-size: 40px;">
                                    <i class="ri-map-pin-time-line"></i>
                                </a>
                            </div>
                            <div class="menu-name">
                                {{ __('app.label.overtime') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section mt-2" id="presence-section">
            <div class="todaypresence">
                <div class="row">
                    @if(!empty($presenceToday->leave))
                    <div class="col-6">
                        <a href="javascript:void(0);" onclick="showAlert('has permit')">
                            <div class="card checkin">
                                <div class="card-body">
                                    <div class="presencecontent">
                                        <div class="iconpresence">
                                            <i class="ri-logout-box-line"></i>
                                        </div>
                                        <div class="presencedetail">
                                            <h4 class="presencetitle">You Have Permit</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @elseif(empty($presenceToday))
                        <div class="col-6">
                            <a href="{{ route('presence.in') }}" class="clickable-link">
                                <div class="card checkin">
                                    <div class="card-body">
                                        <div class="presencecontent">
                                            <div class="iconpresence">
                                                <i class="ri-logout-box-r-line"></i>
                                            </div>
                                            <div class="presencedetail">
                                                <h4 class="presencetitle">{{ __('app.label.check_in') }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @elseif(!empty($presenceToday->date) && !$presenceToday->check_out)
                        <div class="col-6">
                            <a href="{{ route('presence.out') }}" class="clickable-link">
                                <div class="card checkout">
                                    <div class="card-body">
                                        <div class="presencecontent">
                                            <div class="iconpresence">
                                                <i class="ri-logout-box-r-line"></i>
                                            </div>
                                            <div class="presencedetail">
                                                <h4 class="presencetitle">{{ __('app.label.check_out') }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @else
                        <div class="col-6">
                            <a href="javascript:void(0);" onclick="showAlert('check out')">
                                <div class="card checkout">
                                    <div class="card-body">
                                        <div class="presencecontent">
                                            <div class="iconpresence">
                                                <i class="ri-logout-box-line"></i>
                                            </div>
                                            <div class="presencedetail">
                                                <h4 class="presencetitle">{{ __('app.label.check_out') }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif

                    @if(empty($overtimeToday))
                        <div class="col-6">
                            <a href="{{ route('overtime.create') }}" class="clickable-link">
                                <div class="card checkin">
                                    <div class="card-body">
                                        <div class="presencecontent">
                                            <div class="iconpresence">
                                                <i class="ri-clockwise-2-line"></i>
                                            </div>
                                            <div class="presencedetail">
                                                <h4 class="presencetitle">{{ __('app.label.overtime_in') }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @elseif(!empty($overtimeToday->date) && !$overtimeToday->end_at)
                        <div class="col-6">
                            <a href="{{ route('overtime.create') }}" class="clickable-link">
                                <div class="card checkout">
                                    <div class="card-body">
                                        <div class="presencecontent">
                                            <div class="iconpresence">
                                                <i class="ri-anticlockwise-2-line"></i>
                                            </div>
                                            <div class="presencedetail">
                                                <h4 class="presencetitle">{{ __('app.label.overtime_out') }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @else
                        <div class="col-6">
                            <a href="javascript:void(0);" onclick="showAlert('overtime out')">
                                <div class="card checkout">
                                    <div class="card-body">
                                        <div class="presencecontent">
                                            <div class="iconpresence">
                                                <i class="ri-anticlockwise-2-line"></i>
                                            </div>
                                            <div class="presencedetail">
                                                <h4 class="presencetitle">{{ __('app.label.overtime_out') }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif 
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="presence-summary-title mb-3">
                        {{ __('app.label.attendance_chart') }}
                    </div>
                    <canvas id="attendanceChart" width="400" height="200"></canvas>
                    {{-- <div id="chart"></div> --}}
                </div>
            </div>



        </div>
    </div>
    <!-- * App Capsule -->

    

@include('_employee_app.modal.presence')
@include('modal.message')

<script>
function showAlert(type) {
    const messages = @json(__('messages'));
    let message = '';
    
    // Tentukan pesan berdasarkan tipe
    if (type === 'has permit') {
    message = messages.has_permit;
    }
    else if (type === 'check in') {
    message = messages.already_check_in;
    } else if (type === 'check out') {
        message = messages.already_check_out;
    } else if (type === 'overtime in') {
        message = messages.already_overtime_in;
    } else if (type === 'overtime out') {
        message = messages.already_overtime_out;
    }

    // if (type === 'check in') {
    //     message = 'Wis absen melbu, rasah absen meneh!';
    // } else if (type === 'check out') {
    //     message = 'Wis absen metu, rasah absen meneh!';
    // }
    // if (type === 'overtime in') {
    //     message = 'Wis absen melbu lembur, rasah absen neh!';
    // } else if (type === 'overtime out') {
    //     message = 'Wis absen metu lembur, rasah absen neh!';
    // }

    // Tampilkan SweetAlert dengan pesan sesuai
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: message,
    });
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
                        display: false
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

