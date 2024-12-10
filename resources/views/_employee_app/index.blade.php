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
                                <span class="text-center">Profil</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="{{ route('leave.index') }}" class="tosca" style="font-size: 40px;">
                                    <i class="ri-flight-takeoff-fill"></i>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Ijin</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="{{ route('presence.history') }}" class="tosca" style="font-size: 40px;">
                                    <i class="ri-file-history-line"></i>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Presensi</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="{{ route('overtime.history') }}" class="tosca" style="font-size: 40px;">
                                    <i class="ri-map-pin-time-line"></i>
                                </a>
                            </div>
                            <div class="menu-name">
                                Lembur
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
                                                <h4 class="presencetitle">Absen Masuk</h4>
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
                                                <h4 class="presencetitle">Absen Keluar</h4>
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
                                                <h4 class="presencetitle">Absen Keluar</h4>
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
                                                <h4 class="presencetitle">Lembur Masuk</h4>
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
                                                <h4 class="presencetitle">Lembur Keluar</h4>
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
                                                <h4 class="presencetitle">Lembur Keluar</h4>
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
                    <div class="presence-summary-title">
                        Ringkasann Kehadiran
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
    let message = '';
    
    // Tentukan pesan berdasarkan tipe
    if (type === 'check in') {
        message = 'Wis absen melbu, rasah absen meneh!';
    } else if (type === 'check out') {
        message = 'Wis absen metu, rasah absen meneh!';
    }
    if (type === 'overtime in') {
        message = 'Wis absen melbu lembur, rasah absen neh!';
    } else if (type === 'overtime out') {
        message = 'Wis absen metu lembur, rasah absen neh!';
    }

    // Tampilkan SweetAlert dengan pesan sesuai
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: message,
    });
}

document.addEventListener("DOMContentLoaded", () => {
        // Data dari controller
        const months = @json($chartData['labels']); // Ambil bulan dalam format string
        const quantities = @json($chartData['data']); // Ambil total quantity

        // Render chart dengan data dari database
        new ApexCharts(document.querySelector("#chart"), {
            series: [{
                name: 'Sales',
                data: quantities // Gunakan data qty
            }],
            chart: {
                height: 150,
                type: 'bar',
                toolbar: {
                    show: false
                },
            },
            markers: {
                size: 4
            },
            colors: ['#118ab2'],
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.3,
                    opacityTo: 0.4,
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
            xaxis: {
                type: 'category', // Kategori x-axis adalah tipe kategori
                categories: months // Data bulan dalam format string
            },
            tooltip: {
                x: {
                    format: 'MMMM' // Format tooltip untuk menampilkan bulan penuh
                },
            }
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

