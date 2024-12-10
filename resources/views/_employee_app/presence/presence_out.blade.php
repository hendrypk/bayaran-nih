@extends('_employee_app._layout_employee.main')
<!-- @section('header.title', 'Absen Keluar') -->
@include('_employee_app._layout_employee.header')
<!-- @section('header')

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

                    <div class="rekappresence">
                        <div class="row mb-2">
                            <div class="col-6">
                                <div class="col-md-2">
                                    <label for="">Shif Sekarang :</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" value="{{ $workDay }}" name="workDay" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="col-md-2">
                                    <label for="">Pilih Lokasi :</label>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" name="officeLocations" aria-label="Default select example">
                                        @foreach($employee->officeLocations as $index => $officeLocations)
                                            <option value="{{ $officeLocations->name }}">{{ $officeLocations->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="note">Catatan :</label>
                            <input type="text" class="form-control" name="note">                    
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button type="button" class="btn btn-tosca btn-block" id="take-presence">
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

    //display web cam
    Webcam.set({
        height: 480,
        width: 480,
        image_format: 'jpeg',
        jpeg_quality: 80
    });
    Webcam.attach('.webcam-capture');

//handle presence submit
    $('#take-presence').click(function (event) {
    event.preventDefault(); 

    Webcam.snap(function (uri) {
        $('#capturedImage').attr('src', uri);
        $.ajax({
            url: '{{ route('presence.submit') }}', 
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}', 
                image: uri, 
                workDay: $('[name="workDay"]').val(), 
                officeLocations: $('[name="officeLocations"]').val(), 
                note: $('[name="note"]').val(), 
                location: $('#location').val() 
            },
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message, 
                    }).then(() => {
                        window.location.href = response.redirectUrl; 
                    });
                } else if ( response.status = 'error') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Eror',
                        text: response.message,
                        confirmButtonText: 'Try Again'
                    });
                }
            },
            error: function (xhr, status, error,) {
                if (xhr.status === 422) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON.message, 
                        confirmButtonText: 'Try Again'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan saat mengirim data!',
                    });
                }
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