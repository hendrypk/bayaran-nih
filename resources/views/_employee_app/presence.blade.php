@extends('_employee_app._layout_employee.main')
<!-- @section('header.title', 'Presence') -->
@include('_employee_app._layout_employee.header')
<!-- @section('header')
<div class="appHeader blue text-light">
        <div class="left">
            <a href="{{ route('employee.app') }}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle"> Presensi </div>
        <div class="right"></div>
    </div>
@endsection -->
@section('content')
<div class="presence">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('presence.submit') }}" method="POST">
                    @csrf   
                    <div class="row mb-2">
                        <div class="col">
                            <div class="webcam-capture" id="webcam"></div>
                            <img id="capturedImage" alt="Captured Image" style="display: none;"/>
                        </div>
                    </div>
                    <div class="row">
                            <div class="presence-camera">
                                <p id="dateTime"></p>
                                <input type="text" name="location" id="location">                        
                            </div>
                    </div>
                    <div class="row mb-2 align-items-center">
                        <div class="col">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-2">
                            <label for="">Select Shift :</label>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control" name="workDay" aria-label="Default select example">
                                @foreach($employee->workDay as $index => $workDay)
                                    <option value="{{ $workDay->name }}">{{ $workDay->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="note">Note :</label>
                            <input type="text" class="form-control" name="note">                    
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-primary btn-block" id="take-presence">
                            <ion-icon name="camera" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
                            </button>
                        </div>
                    </div>

                </form>
        </div>
    </div>
</div>
@section('script')
<script>

    document.addEventListener("DOMContentLoaded", function() {
        var getLocation = document.getElementById('location');

        // Attempt to get the user's location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallBack, errorCallBack);
        } else {
            console.log("Geolocation is not supported by this browser.");
        }

        function successCallBack(position) {
            // Display latitude and longitude in the input field
            getLocation.value = position.coords.latitude + ", " + position.coords.longitude;

            // Optional: Initialize your map or any other logic here
            var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 13);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
            var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
            var circle = L.circle([-7.761940915549656, 110.31390577561152], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 30
            }).addTo(map).addTo(map);;
        }
        
        function errorCallBack(error) {
            console.error("Error retrieving location:", error);
            // You can also provide a fallback or user-friendly message here
        }
    });

    // $("#take-presence").click(function(e){
    //     Webcam.snap(function(uri){
    //         image = uri;
    //     });
    //     var location = $("#location").val();
    //     $.ajax({
    //         type:'POST'
    //         , route:"{{ route('presence.submit') }}"
    //         , data: {
    //             _token: "{{ csrf_token() }}"
    //             , image: image
    //             , locatioin: location
    //         }
    //         , cache: false
    //         , success: function(respond) {

    //         }
    //     });
    // });

    Webcam.set({
        height: 480,
        width: 320,
        image_format: 'jpeg',
        jpeg_quality: 80
    });

    Webcam.attach('.webcam-capture');

    $('#take-presence').click(function () {
        Webcam.snap(function (uri) {
            // Tampilkan gambar yang ditangkap di elemen img
            $('#capturedImage').attr('src', uri);

            // Kirim data gambar ke server menggunakan AJAX
            $.ajax({
                url: '{{ route('image.submit') }}', // Rute ke controller Laravel Anda
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // Token CSRF Laravel
                    image: uri // Gambar dalam format base64
                },
                success: function (response) {
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    }); 
    
</script>
<script type="text/javascript">
    window.onload = function() {
        dateTime();
    }

    function dateTime() {
            var e = document.getElementById('dateTime'),
                d = new Date(),
                h = set(d.getHours()),
                m = set(d.getMinutes()),
                s = set(d.getSeconds());

            var day = d.toLocaleDateString('id-ID', { weekday: 'long' });
            var date = d.getDate();
            var month = d.toLocaleDateString('id-ID', { month: 'long' });
            var year = d.getFullYear();

            e.innerHTML = day + ', ' + date + ' ' + month + ' ' + year + ' | ' + h + ':' + m + ':' + s;

            setTimeout(dateTime, 1000);
        }

        function set(e) {
            e = e < 10 ? '0' + e : e;
            return e;
        }

</script>
@endsection
@endsection