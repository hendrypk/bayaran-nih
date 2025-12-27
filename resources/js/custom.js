// resources/js/custom.js
import $ from 'jquery';
window.$ = $;
window.jQuery = $;


/*===================================
    Sidebar
=====================================*/
$(function () {
    const $sidebar = $('#sidebar');
    const $navbar = $('#navbar');
    const $toggle = $('#sidebarToggle');
    const $labels = $sidebar.find('.sidebar-label, .sub-menu-icon');
    const $navbarToggle = $('#navbarToggle')

    // --- 1. LOAD INITIAL STATE ---
    const stored = localStorage.getItem('sidebarOpen');
    if (stored === 'false') {
        collapse(true); 
    } else {
        expand(true);
    }

    // --- 2. CLICK HANDLER ---
    $toggle.on('click', function (e) {
        e.preventDefault();
        const isCurrentlyExpanded = $toggle.attr('aria-expanded') === 'true';
        if (isCurrentlyExpanded) {
            collapse(true);
            localStorage.setItem('sidebarOpen', 'false');
        } else {
            expand(true);
            localStorage.setItem('sidebarOpen', 'true');
        }
    });

    $navbarToggle.on('click', function (e) {
        e.preventDefault();

            expand(true);
            localStorage.setItem('sidebarOpen', 'true');
    })

    // --- 3. HOVER HANDLER ---
    $sidebar.on('mouseenter', function() {
        if (localStorage.getItem('sidebarOpen') === 'false') {
            expand(false);
        }
    }).on('mouseleave', function() {
        if (localStorage.getItem('sidebarOpen') === 'false') {
            collapse(false);
        }
    });

    // --- 4. CORE FUNCTIONS ---
    function collapse(isPermanent) {
        $sidebar.addClass('collapsed w-16').removeClass('w-64');
        $navbar.addClass('collapsed left-16 justify-between').removeClass('left-64 justify-end');
        $labels.hide();
        $navbarToggle.show();
        $('.app-wrapper').addClass('collapsed ml-16').removeClass('ml-64');
        
        $('#logoExpand').addClass('hidden');
        $('#logoCollapse').removeClass('hidden');
        window.dispatchEvent(new CustomEvent('close-all-sub'));
        $toggle.addClass('hidden');

        if (isPermanent) {
            $toggle.attr('aria-expanded', 'false');
            $('#iconCollapse').addClass('hidden');
            $('#iconExpand').removeClass('hidden');
        }
    }

    function expand(isPermanent) {
        $sidebar.removeClass('collapsed w-16').addClass('w-64');
        $navbar.removeClass('collapsed left-16 justify-between').addClass('left-64 justify-end');
        $labels.show();
        $navbarToggle.hide();
        $('.app-wrapper').removeClass('collapsed ml-16').addClass('ml-64');
        $('#logoExpand').removeClass('hidden');
        $('#logoCollapse').addClass('hidden');

        $toggle.removeClass('hidden');

        if (isPermanent) {
            $toggle.attr('aria-expanded', 'true');
            $('#iconCollapse').removeClass('hidden');
            $('#iconExpand').addClass('hidden');
        } else {
            $('#iconCollapse').addClass('hidden');
            $('#iconExpand').removeClass('hidden');
        }
    }
});


/*===================================
    Dark and light theme change
=====================================*/
$(function () {
  const $themeToggle = $('#themeMood');
  const $html = $('html');

  // restore theme dari localStorage
  let currentTheme = localStorage.getItem('theme');
  if (currentTheme === 'dark') {
    $html.addClass('dark');
  } else {
    $html.removeClass('dark');
  }

  $themeToggle.on('click', function () {
    if ($html.hasClass('dark')) {
      $html.removeClass('dark');
      localStorage.setItem('theme', 'light');
    } else {
      $html.addClass('dark');
      localStorage.setItem('theme', 'dark');
    }
  });
});


/*===================================
    Datatables
=====================================*/
$('.datatables').DataTable({
  responsive: true,
  autoWidth: false,
  language: {
    search: "Cari:",
    lengthMenu: "Tampilkan _MENU_ data",
    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
    paginate: {
      first: "Awal",
      last: "Akhir",
      next: "›",
      previous: "‹"
    },
    zeroRecords: "Tidak ada data yang cocok"
  },
  dom: '<"flex items-center justify-between mb-4"lf>rt<"flex items-center justify-between mt-4"ip>'
});


// /*===================================
//     Datepicker
// =====================================*/
// $(document).ready(function() {
//     $('.datepicker').flatpickr({
//         disableMobile: true,
//         dateFormat: 'Y-m-d',
//         altInput: true,
//         altInputClass: 'form-input-puffy dark:bg-slate-950 dark:text-white',
//         altFormat: 'l, j F Y',
//         static: true
//     });
// });
