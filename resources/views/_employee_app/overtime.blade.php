@extends('_employee_app._layout_employee.main')
@section('header.title', 'Lembur')
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
        @if (session('error'))
            <div class="alert alert-danger mb-3">
                {{ session('error') }}
            </div>
        @endif
            <form action="{{ route('overtime.submit') }}" method="POST">
                    @csrf   
                    <div class="row mb-3">
                        <div class="webcam-capture "></div>
                    </div>

                    <div class="presence-camera">
                        <p id="dateTime"></p>
                        <input type="text" name="location" id="location">                        
                    </div>

                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-tosca btn-block">
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
    Webcam.set({
        height: 480,
        width: 480,
        image_format: 'jpeg',
        jpeg_quality: 80
    });

    Webcam.attach('.webcam-capture');

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
            var circle = L.circle([position.coords.latitude, position.coords.longitude], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 50
            }).addTo(map);
        }

        function errorCallBack(error) {
            console.error("Error retrieving location:", error);
            // You can also provide a fallback or user-friendly message here
        }
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