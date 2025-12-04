<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title','Gajiplus')</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  {{-- <link href="{{asset('e-presensi/assets/img/bayaran-favicon.png')}}" rel="icon"> --}}
  <link href="{{asset('e-presensi/assets/img/logo/favicon.jpg')}}" rel="icon">
  <link href="{{asset('assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/apexcharts@latest"></script>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp" rel="stylesheet"/>

  <link href="{{asset('assets/css/custom.css')}}" rel="stylesheet">
  <link href="{{asset('assets/scss/style.scss')}}" rel="stylesheet">
  <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
  <!-- Include SweetAlert2 CSS and JS -->
  {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script> --}}
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  <!-- flatpickr date -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  
  <!-- Show Maps -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

  <!-- Template Main CSS File -->
  <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body id="body">
@if(!request()->is('login') && !request()->is('register'))
  <!-- ======= Header ======= -->
   @include('_layout.header')
  <!-- End Header -->
   @include('_layout.sidebar')
  <!-- ======= Sidebar ======= -->
@endif
  


  <main id="main" class="main">
    <section class="section">
      <div class="content-wrapper">
        @yield('content')
      </div>
    </section>
  </main>

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    {{-- <div class="copyright">
      &copy; Copyright <strong><span>Bayaran</span></strong>. All Rights Reserved
    </div> --}}
    <div class="credits">
      Powered by <a href="https://hendrypk.my.id/">hendrypk</a>
    </div>
    <div class="release-tag" id="releaseList"></div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
  <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
  <!-- <script src="assets/vendor/simple-datatables/simple-datatables.js"></script> -->

  <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>

  <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>
  <script src="{{ asset('assets/js/release.js') }}"></script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Make sure you put this AFTER Leaflet's CSS -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
  integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
  crossorigin=""></script>


  <script>
    function showSuccessAlert(message) {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: message,
            confirmButtonText: 'Okay'
        });
    }

    function showErrorAlert(message) {
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: message,
            confirmButtonText: 'Try Again'
        });
    }

    // Trigger alerts based on session messages
    @if (session('success'))
        showSuccessAlert("{{ session('success') }}");
    @endif

    @if (session('error'))
        showErrorAlert("{{ session('error') }}");
    @endif

    @if ($errors->any())
        let errorMessage = '';
        @foreach ($errors->all() as $error)
            errorMessage += '{{ $error }}\n';
        @endforeach

        Swal.fire({
            icon: 'error',
            title: 'Eror',
            text: errorMessage,
            confirmButtonText: 'Try Again'
        });
    @endif
</script>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Select multiple elements using a query selector
    const datePickers = document.querySelectorAll("#leave-dates, #holiday-dates");

    // Loop over each element and initialize flatpickr
    datePickers.forEach(function(datePicker) {
        flatpickr(datePicker, {
            mode: "multiple",
            dateFormat: "Y-m-d",
        });
    });

});

</script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
      const toggleIcons = document.querySelectorAll('.toggle-password');

      toggleIcons.forEach(icon => {
          icon.addEventListener('click', function () {
              const targetId = this.getAttribute('data-target');
              const input = document.getElementById(targetId);

              if (input.type === 'password') {
                  input.type = 'text';
                  this.classList.remove('bi-eye-fill');
                  this.classList.add('bi-eye-slash-fill');
              } else {
                  input.type = 'password';
                  this.classList.remove('bi-eye-slash-fill');
                  this.classList.add('bi-eye-fill');
              }
          });
      });
  });
</script>

  @yield('script')

</body>

</html>