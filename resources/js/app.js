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

document.addEventListener('alpine:init', () => {
    Alpine.data('locationPickerData', () => ({
        map: null,
        marker: null,
        circle: null,
        searchQuery: '',
        searchResults: [], // Menyimpan list hasil pencarian
        isSearching: false,
        showResults: false,

        initMap() {
            this.$nextTick(() => {
                this.setupLeaflet();
                
                // Watcher untuk sinkronisasi dari Livewire (Mode Edit)
                this.$watch('$wire.latitude', (val) => {
                    if (val && this.map) {
                        const lat = parseFloat(this.$wire.latitude);
                        const lng = parseFloat(this.$wire.longitude);
                        this.updateMarkerPosition(lat, lng, true);
                    }
                });

                // Watcher untuk sinkronisasi Radius
                this.$watch('$wire.radius', (val) => {
                    if (this.circle) this.circle.setRadius(parseInt(val || 100));
                });
            });
        },

        setupLeaflet() {
            const lat = this.$wire.get('latitude') || -6.200000;
            const lng = this.$wire.get('longitude') || 106.816666;
            const rad = this.$wire.get('radius') || 100;

            if (this.map) this.map.remove();

            this.map = L.map('map-picker', {
                zoomControl: false, 
                attributionControl: false
            }).setView([lat, lng], 16);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(this.map);

            this.marker = L.marker([lat, lng]).addTo(this.map);
            this.circle = L.circle([lat, lng], {
                color: '#06b6d4',
                fillColor: '#22d3ee',
                fillOpacity: 0.2,
                radius: parseInt(rad)
            }).addTo(this.map);

            this.map.on('click', (e) => this.handleMapClick(e));

            // Perbaikan tampilan container map
            setTimeout(() => this.map.invalidateSize(), 500);
        },

        handleMapClick(e) {
            this.updateMarkerPosition(e.latlng.lat, e.latlng.lng);
            this.showResults = false; // Tutup list pencarian jika klik di map
        },

        // Fungsi Pencarian dengan List (Nominatim)
        async searchLocation() {
            if (!this.searchQuery || this.searchQuery.length < 3) return;
            
            this.isSearching = true;
            try {
                const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(this.searchQuery)}&limit=5`);
                this.searchResults = await response.json();

                if (this.searchResults.length > 0) {
                    this.showResults = true;
                } else {
                    window.Swal.fire({ icon: 'info', title: 'Info', text: 'Lokasi tidak ditemukan.' });
                }
            } catch (error) {
                console.error("Search Error:", error);
            } finally {
                this.isSearching = false;
            }
        },

        // Pilih lokasi dari list
        selectLocation(result) {
            const lat = parseFloat(result.lat);
            const lng = parseFloat(result.lon);
            this.searchQuery = result.display_name;
            this.updateMarkerPosition(lat, lng, true);
            this.showResults = false;
        },

        getCurrentLocation() {
            if (!navigator.geolocation) {
                return window.Swal.fire({ icon: 'error', title: 'Error', text: 'GPS tidak didukung.' });
            }

            navigator.geolocation.getCurrentPosition(
                (pos) => this.updateMarkerPosition(pos.coords.latitude, pos.coords.longitude, true),
                (err) => window.Swal.fire({ icon: 'warning', title: 'GPS Error', text: 'Gagal akses lokasi.' }),
                { enableHighAccuracy: true }
            );
        },

        // Fungsi utama untuk update posisi visual dan data
        updateMarkerPosition(lat, lng, fly = false) {
            if (!this.map) return;

            const coords = [lat, lng];
            this.marker.setLatLng(coords);
            this.circle.setLatLng(coords);

            if (fly) this.map.flyTo(coords, 17, { animate: true, duration: 1.5 });

            // Set data ke Livewire
            this.$wire.set('latitude', lat.toFixed(8));
            this.$wire.set('longitude', lng.toFixed(8));
        }
    }));
});
document.addEventListener('alpine:init', () => {
    Alpine.data('presenceDetailMap', () => ({
        maps: { in: null, out: null },
        markers: { in: null, out: null },

        initMap(type, location) {
            if (!location) return;

            // Pastikan kontainer DOM sudah ada
            this.$nextTick(() => {
                const coords = location.split(',');
                const lat = parseFloat(coords[0]);
                const lng = parseFloat(coords[1]);
                const containerId = type === 'in' ? 'mapInDetail' : 'mapOutDetail';
                const container = document.getElementById(containerId);

                if (!container) return;

                // 1. Jika peta belum diinisialisasi
                if (!this.maps[type]) {
                    this.maps[type] = L.map(containerId, {
                        zoomControl: true,
                        attributionControl: false
                    }).setView([lat, lng], 16);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(this.maps[type]);
                    this.markers[type] = L.marker([lat, lng]).addTo(this.maps[type]);
                } else {
                    // 2. Jika sudah ada, cukup update posisi
                    this.maps[type].setView([lat, lng], 16);
                    this.markers[type].setLatLng([lat, lng]);
                }

                // 3. Penting: Supaya tiles tidak abu-abu (render ulang ukuran)
                setTimeout(() => {
                    this.maps[type].invalidateSize();
                }, 400);
            });
        }
    }));
});

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
import "datatables.net";

$.extend(true, $.fn.dataTable.defaults, {
    responsive: true,
    autoWidth: false,
    language: {
        search: "Cari:",
        lengthMenu: "_MENU_",
        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        paginate: {
            first: "Awal",
            last: "Akhir",
            next: "›",
            previous: "‹"
        },
        zeroRecords: "Tidak ada data yang cocok"
    },
    dom: '<"flex items-center justify-between m-4"lf>rt<"flex items-center justify-between m-4"ip>'
});

$(document).ready(function () {
    $("table.datatable, table[id^='datatable']").DataTable();
});


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
import './plugins/sweetalert';

// Import semua gambar agar bisa dipakai oleh bundler
import.meta.glob(["../images/**"]);

