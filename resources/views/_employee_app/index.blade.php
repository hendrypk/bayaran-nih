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
                    @if(empty($presenceToday))
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
                    <div id="chart"></div>
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
    if (type === 'check in') {
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
        const colors = ['#118ab2', '004cda', '#f29c11', '#323335', '#8e44ad', '#d8315b'];
        const total = presence.reduce((acc, value) => acc + value, 0);

        // Render chart dengan data dari database
        new ApexCharts(document.querySelector("#chart"), {
            chart: {
                type: 'donut',
                height: 160,
                toolbar: {
                    show: false
                },
            },
            markers: {
                size: 4
            },
            colors: colors,
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.9,
                    stops: [0, 90, 100]
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            series: presence,
            labels: category,
            plotOptions: {
                pie: {
                    donut: {
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontSize: '16px',
                                color: '#333',
                                fontFamily: 'Arial, sans-serif',
                                offsetY: -10,
                            },
                            value: {
                                show: true,
                                fontSize: '20px',
                                fontWeight: 600,
                                color: '#118ab2',
                                fontFamily: 'Arial, sans-serif',
                                formatter: function (value, opts) {
                                    // Menampilkan nilai spesifik dari label yang dipilih
                                    const seriesIndex = opts.seriesIndex; // Mendapatkan index dari data
                                    const seriesValue = opts.w.globals.series[seriesIndex]; // Nilai data tersebut
                                    return seriesValue; // Menampilkan nilai spesifik
                                },
                            },
                            total: {
                                show: true,
                                label: 'Total',
                                fontSize: '14px',
                                fontWeight: 400,
                                color: '#118ab2',
                                formatter: () => total, // Tetap menampilkan total di tengah grafik
                            }
                        }
                    }
                }
            }

            // series: [{
            //     name: '',
            //     data: presence // Gunakan data qty
            // }],
            // chart: {
            //     height: 150,
            //     type: 'bar',
            //     toolbar: {
            //         show: false
            //     },
            // },
            // markers: {
            //     size: 4
            // },
            // colors: ['#118ab2'],
            // fill: {
            //     type: "gradient",
            //     gradient: {
            //         shadeIntensity: 1,
            //         opacityFrom: 0.3,
            //         opacityTo: 0.4,
            //         stops: [0, 90, 100]
            //     }
            // },
            // dataLabels: {
            //     enabled: false
            // },
            // stroke: {
            //     curve: 'smooth',
            //     width: 2
            // },
            // xaxis: {
            //     type: 'category', // Kategori x-axis adalah tipe kategori
            //     categories: category // Data bulan dalam format string
            // },
            // tooltip: {
            //     x: {
            //         format: 'MMMM' // Format tooltip untuk menampilkan bulan penuh
            //     },
            // }
        }).render();
    });



//Chart
// var ctx = document.getElementById('presenceChart').getContext('2d');
//     var presenceChart = new Chart(ctx, {
//         type: 'bar', // Chart type is bar
//         data: {
//             labels: @json($chartData['labels']), // Labels for the X-axis
//             datasets: [{
//                 label: 'Presence Summary',
//                 data: @json($chartData['data']), // Data for the chart
//                 backgroundColor: 'rgba(54, 162, 235, 0.2)', // Bar color
//                 borderColor: 'rgba(54, 162, 235, 1)', // Bar border color
//                 borderWidth: 1
//             }]
//         },
//         options: {
//             scales: {
//                 y: {
//                     beginAtZero: true
//                 }
//             }
//         }
//     });

</script>


@endsection

