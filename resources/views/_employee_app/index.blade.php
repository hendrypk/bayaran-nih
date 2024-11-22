@extends('_employee_app._layout_employee.main')
@section('content')

<!-- @if (session('message'))
    <div class="alert alert-danger">
        {{ session('message') }}
    </div>
@endif -->

    <!-- App Capsule -->
    <div id="appCapsule">
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
                                <a href="{{ route('profileIndex') }}" class="green" style="font-size: 40px;">
                                    <ion-icon name="person-sharp"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Profile</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="{{ route('leave.index') }}" class="danger" style="font-size: 40px;">
                                    <ion-icon name="calendar-number"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Leave</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="{{ route('presence.history') }}" class="warning" style="font-size: 40px;">
                                    <ion-icon name="document-text"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Presence</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="{{ route('overtime.history') }}" class="orange" style="font-size: 40px;">
                                    <ion-icon name="location"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                Overtime
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section mt-2" id="presence-section">
            <div class="todaypresence">
                <div class="row mb-3">
                    @if(!empty($presenceToday) && !empty($presenceToday->date))
                    <div class="col-6">
                        <a href="javascript:void(0);" onclick="showAlert('check in')">
                            <div class="card checkin">
                                <div class="card-body">
                                    <div class="presencecontent">
                                        <div class="iconpresence">
                                            <ion-icon name="camera"></ion-icon>
                                        </div>
                                        <div class="presencedetail">
                                            <h4 class="presencetitle">Check In</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @else
                    <div class="col-6">
                        <a href="{{ route('presence.in') }}" class="clickable-link">
                            <div class="card checkin">
                                <div class="card-body">
                                    <div class="presencecontent">
                                        <div class="iconpresence">
                                            <ion-icon name="camera"></ion-icon>
                                        </div>
                                        <div class="presencedetail">
                                            <h4 class="presencetitle">Check In</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endif

                    <div class="col-6">
                        <div class="card checkout">
                            <div class="card-body">
                                <a href="{{ route('presence.out') }}" class="clickable-link">
                                    <div class="presencecontent">
                                        <div class="iconpresence">
                                            <ion-icon name="camera"></ion-icon>
                                        </div>
                                        <div class="presencedetail">
                                            <h4 class="presencetitle">Check Out</h4>
                                            <!-- @foreach($employee->workDay as $index => $workDay)
                                            <span>{{ $workDay->name }}</span>
                                            @endforeach -->
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @if(!@empty($overtimeToday) && !@empty($overtimeToday->date))
                    <div class="col-6">
                        <div class="card checkout">
                            <div class="card-body">
                                <a href="javascript:void(0);" onclick="showAlert('overtime in')">
                                    <div class="presencecontent">
                                        <div class="iconpresence">
                                            <ion-icon name="camera"></ion-icon>
                                        </div>
                                        <div class="presencedetail">
                                            <h4 class="presencetitle">Overtime In</h4>
                                            <!-- <span>07:00</span> -->
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="col-6">
                        <div class="card checkout">
                            <div class="card-body">
                                <a href="{{ route('overtime.create') }}" class="clickable-link">
                                    <div class="presencecontent">
                                        <div class="iconpresence">
                                            <ion-icon name="camera"></ion-icon>
                                        </div>
                                        <div class="presencedetail">
                                            <h4 class="presencetitle">Overtime In</h4>
                                            <!-- <span>07:00</span> -->
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="col-6">
                        <div class="card checkin">
                            <div class="card-body">
                                <a href="{{ route('overtime.create') }}" class="clickable-link">
                                    <div class="presencecontent">
                                        <div class="iconpresence">
                                            <ion-icon name="camera"></ion-icon>
                                        </div>
                                        <div class="presencedetail">
                                            <h4 class="presencetitle">Overtime Out</h4>
                                            <!-- @foreach($employee->workDay as $index => $workDay)
                                            <span>{{ $workDay->name }}</span>
                                            @endforeach -->
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rekappresence">
                {{-- <div id="chartdiv"></div> --}}
                <!-- <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence primary">
                                        <ion-icon name="log-in"></ion-icon>
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="rekappresencetitle">Hadir</h4>
                                        <span class="rekappresencedetail">0 Hari</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence green">
                                        <ion-icon name="document-text"></ion-icon>
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="rekappresencetitle">Izin</h4>
                                        <span class="rekappresencedetail">0 Hari</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence warning">
                                        <ion-icon name="sad"></ion-icon>
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="rekappresencetitle">Sakit</h4>
                                        <span class="rekappresencedetail">0 Hari</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence danger">
                                        <ion-icon name="alarm"></ion-icon>
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="rekappresencetitle">Terlambat</h4>
                                        <span class="rekappresencedetail">0 Hari</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
            {{-- <div class="presencetab mt-2">
                <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                    <ul class="nav nav-tabs style1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                                Bulan Ini
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                                Leaderboard
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content mt-2" style="margin-bottom:100px;">
                    <div class="tab-pane fade show active" id="home" role="tabpanel">
                        <ul class="listview image-listview">
                            <li>
                                <div class="item">
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="image-outline" role="img" class="md hydrated"
                                            aria-label="image outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                        <div>Photos</div>
                                        <span class="badge badge-danger">10</span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item">
                                    <div class="icon-box bg-secondary">
                                        <ion-icon name="videocam-outline" role="img" class="md hydrated"
                                            aria-label="videocam outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                        <div>Videos</div>
                                        <span class="text-muted">None</span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item">
                                    <div class="icon-box bg-danger">
                                        <ion-icon name="musical-notes-outline" role="img" class="md hydrated"
                                            aria-label="musical notes outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                        <div>Music</div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel">
                        <ul class="listview image-listview">
                            <li>
                                <div class="item">
                                    <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                                    <div class="in">
                                        <div>Edward Lindgren</div>
                                        <span class="text-muted">Designer</span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item">
                                    <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                                    <div class="in">
                                        <div>Emelda Scandroot</div>
                                        <span class="badge badge-primary">3</span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item">
                                    <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                                    <div class="in">
                                        <div>Henry Bove</div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item">
                                    <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                                    <div class="in">
                                        <div>Henry Bove</div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item">
                                    <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                                    <div class="in">
                                        <div>Henry Bove</div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                </div>
            </div> --}}
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
    } else if (type === 'overtime in') {
        message = 'Wis absen melbu lembur, rasah absen neh!';
    } else {
        message = 'Aksi tidak diizinkan!';
    }

    // Tampilkan SweetAlert dengan pesan sesuai
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: message,
    });
}

</script>

@endsection

