document.addEventListener('alpine:init', () => {
    
    // Helper untuk inisialisasi Map standar (reusable)
    const createBaseMap = (containerId, lat, lng, zoom = 16) => {
        const map = L.map(containerId, { zoomControl: false, attributionControl: false }).setView([lat, lng], zoom);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        return map;
    };

    // 1. DATA: Location Picker (Untuk Form/Input)
    Alpine.data('locationPickerData', () => ({
        map: null, marker: null, circle: null,
        searchQuery: '', searchResults: [], 
        isSearching: false, showResults: false,

        initMap() {
            this.$nextTick(() => {
                this.setupLeaflet();
                
                // Sync dari Livewire (Mode Edit/External Update)
                this.$watch('$wire.latitude', val => val && this.updateMarkerPosition(val, this.$wire.longitude, true));
                this.$watch('$wire.radius', val => this.circle?.setRadius(parseInt(val || 100)));
            });
        },

        setupLeaflet() {
            const lat = parseFloat(this.$wire.latitude || -6.200000);
            const lng = parseFloat(this.$wire.longitude || 106.816666);
            const rad = parseInt(this.$wire.radius || 100);

            if (this.map) this.map.remove();

            this.map = createBaseMap('map-picker', lat, lng);
            this.marker = L.marker([lat, lng]).addTo(this.map);
            this.circle = L.circle([lat, lng], {
                color: '#06b6d4', fillColor: '#22d3ee', fillOpacity: 0.2, radius: rad
            }).addTo(this.map);

            this.map.on('click', e => {
                this.updateMarkerPosition(e.latlng.lat, e.latlng.lng);
                this.showResults = false;
            });

            setTimeout(() => this.map.invalidateSize(), 500);
        },

        async searchLocation() {
            if (this.searchQuery.length < 3) return;
            this.isSearching = true;
            try {
                const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(this.searchQuery)}&limit=5`);
                this.searchResults = await res.json();
                this.showResults = this.searchResults.length > 0;
            } catch (e) { console.error(e); } 
            finally { this.isSearching = false; }
        },

        selectLocation(result) {
            this.searchQuery = result.display_name;
            this.updateMarkerPosition(result.lat, result.lon, true);
            this.showResults = false;
        },

        updateMarkerPosition(lat, lng, fly = false) {
            if (!this.map) return;
            const pos = [parseFloat(lat), parseFloat(lng)];
            this.marker.setLatLng(pos);
            this.circle.setLatLng(pos);
            if (fly) this.map.flyTo(pos, 17);

            this.$wire.set('latitude', pos[0].toFixed(8));
            this.$wire.set('longitude', pos[1].toFixed(8));
        }
    }));

    // // 2. DATA: Presence Detail (Untuk Preview/Read-only)
    //     Alpine.data('detailPanelHandler', () => ({
    //         selectedData: null,
    //         showDetail: false,
    //         maps: {},

    //         toggleDetail(data) {
    //             const isSame = this.selectedData?.id === data.id;
                
    //             // Cleanup map lama jika data berganti
    //             if (!isSame) this.cleanup();

    //             this.showDetail = isSame ? !this.showDetail : true;
    //             this.selectedData = isSame && !this.showDetail ? null : data;

    //             // Inisialisasi Map jika panel dibuka
    //             if (this.showDetail) {
    //                 this.$nextTick(() => {
    //                     this.initMap('in', data.latlng_in);
    //                     this.initMap('out', data.latlng_out);
    //                 });
    //             }
    //         },

    //         initMap(type, loc) {
    //             if (!loc || loc === '-' || loc === null) return;
                
    //             const containerId = `map-${type}`;
    //             const container = document.getElementById(containerId);
    //             if (!container) return;

    //             const [lat, lng] = loc.split(',').map(parseFloat);

    //             // Logic Map (Leaflet)
    //             if (!this.maps[type]) {
    //                 this.maps[type] = L.map(containerId).setView([lat, lng], 15);
    //                 L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(this.maps[type]);
    //                 L.marker([lat, lng]).addTo(this.maps[type]);
    //             } else {
    //                 this.maps[type].setView([lat, lng], 15);
    //             }

    //             // Fix gray tiles issue
    //             setTimeout(() => this.maps[type].invalidateSize(), 400);
    //         },

    //         cleanup() {
    //             Object.values(this.maps).forEach(map => {
    //                 if (map) map.remove();
    //             });
    //             this.maps = {};
    //         }
    //     }));
        
    // Alpine.data('presenceDetailMap', () => ({
    //     selectedPresence: null,
    //     showDetail: false,
    //     maps: { in: null, out: null },
    //     markers: { in: null, out: null },

    //     toggleDetail(data) {
    //         const isSame = this.selectedPresence?.id === data.id;
    //         this.showDetail = isSame ? !this.showDetail : true;
    //         this.selectedPresence = isSame && !this.showDetail ? null : data;
            
    //         // Opsional: Reset maps saat ganti data agar tidak "nyangkut" posisi lama
    //         if (!isSame) this.cleanupMaps();
    //     },

    //     initMap(type, location) {
    //         if (!location || location === '-') return;

    //         this.$nextTick(() => {
    //             const containerId = type === 'in' ? 'mapInDetail' : 'mapOutDetail';
    //             if (!document.getElementById(containerId)) return;

    //             const [lat, lng] = location.split(',').map(parseFloat);

    //             if (!this.maps[type]) {
    //                 this.maps[type] = createBaseMap(containerId, lat, lng);
    //                 this.markers[type] = L.marker([lat, lng]).addTo(this.maps[type]);
    //             } else {
    //                 this.maps[type].setView([lat, lng], 16);
    //                 this.markers[type].setLatLng([lat, lng]);
    //             }

    //             setTimeout(() => this.maps[type]?.invalidateSize(), 400);
    //         });
    //     },

    //     cleanupMaps() {
    //         ['in', 'out'].forEach(type => {
    //             if (this.maps[type]) {
    //                 this.maps[type].remove();
    //                 this.maps[type] = null;
    //             }
    //         });
    //     }
    // }));
});