  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="{{route('home')}}" class="logo d-flex align-items-center">
        <img src="{{asset('e-presensi/assets/img/logo/logo.jpg')}}" alt="">
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">        
        <li class="nav-item">
          <x-language-switcher />
        </li>
        <li class="nav-item">
          <div class="release-tag" id="latestRelease">Checking version release...</div>
        </li>
      </ul>
    </nav>

  </header>