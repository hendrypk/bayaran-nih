import './bootstrap';

// Core Js
import jQuery from "jquery";
window.$ = jQuery;
window.jQuery = jQuery;

// Tailwind Elements
import "tw-elements";

// Animate.css
import "animate.css";

// ResizeObserver polyfill (untuk Safari/Edge lama)
import ResizeObserver from "resize-observer-polyfill";
window.ResizeObserver = ResizeObserver;

// Leaflet
// ... kode import yang sudah ada ...
import L from "leaflet";
window.L = L;


// FullCalendar
import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";
window.Calendar = Calendar;
window.dayGridPlugin = dayGridPlugin;
window.timeGridPlugin = timeGridPlugin;
window.listPlugin = listPlugin;

// Cleave.js
import Cleave from "cleave.js";
window.Cleave = Cleave;

// Chart.js & ApexCharts
import * as Chart from "chart.js";
window.Chart = Chart;
import ApexCharts from "apexcharts";
window.ApexCharts = ApexCharts;

// Country select
import "country-select-js";

// Dragula (drag & drop)
import dragula from "dragula/dist/dragula";
import "dragula/dist/dragula.css";
window.dragula = dragula;

// Iconify
import "iconify-icon";

// SweetAlert2
import Swal from "sweetalert2";
window.Swal = Swal;

// Tippy.js (tooltip/popover)
import tippy from "tippy.js";
import "tippy.js/dist/tippy.css";
window.tippy = tippy;

// DataTables (core only, tanpa theme bawaan)
// import "datatables.net";

// $.extend(true, $.fn.dataTable.defaults, {
//     responsive: true,
//     autoWidth: false,
//     language: {
//         search: "Cari:",
//         lengthMenu: "_MENU_",
//         info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
//         paginate: {
//             first: "Awal",
//             last: "Akhir",
//             next: "›",
//             previous: "‹"
//         },
//         zeroRecords: "Tidak ada data yang cocok"
//     },
//     dom: '<"flex items-center justify-between m-4"lf>rt<"flex items-center justify-between m-4"ip>'
// });

// $(document).ready(function () {
//     $("table.datatable, table[id^='datatable']").DataTable();
// });


// jQuery Validation
import validate from "jquery-validation";
window.validate = validate;

// Flatpickr
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.css"; // Pastikan CSS diimport juga
window.flatpickr = flatpickr;

// Moment.js
import moment from "moment";
window.moment = moment;

// DateRangePicker (butuh jQuery + moment)
import "daterangepicker";

// ECharts
import * as echarts from "echarts";
window.echarts = echarts;

// Quill editor
import Quill from "quill";
window.Quill = Quill;

// TinyMCE
import tinymce from "tinymce";
window.tinymce = tinymce;

// Select2
// Import Select2 setelah jQuery global tersedia
import select2 from 'select2';

// Inisialisasi secara eksplisit agar menempel ke jQuery
select2(); 
$('.select2-puffy').select2({
    // Memaksa search muncul di box utama, bukan di dropdown
    // Catatan: Secara default Select2 Multiple sudah melakukan ini.
    // Untuk Single, ini akan memastikan search field aktif di atas.
    dropdownParent: $('#some-container'), 
    searchInputPlaceholder: 'Cari...'
});
// Import CSS-nya
import 'select2/dist/css/select2.css';

// Custom scripts
import './custom';
import './leaflet';
import './plugins/sweetalert';

// Import semua gambar agar bisa dipakai oleh bundler
import.meta.glob(["../images/**"]);

