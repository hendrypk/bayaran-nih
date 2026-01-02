document.addEventListener('alpine:init', () => {
    // Helper privat untuk merender Leaflet
    const renderLeaflet = (containerId, coords) => {
        if (!coords || coords === '-' || coords === null) return null;
        
        const [lat, lng] = coords.split(',').map(parseFloat);
        const container = L.DomUtil.get(containerId);
        if (container) { container._leaflet_id = null; } // Reset jika ID sudah terpakai

        const map = L.map(containerId, { 
            zoomControl: false, 
            attributionControl: false 
        }).setView([lat, lng], 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        L.marker([lat, lng]).addTo(map);
        
        // Memastikan ukuran map pas setelah animasi panel selesai
        setTimeout(() => map.invalidateSize(), 500);
        return map;
    };

    Alpine.data('showMap', (suffix = 'default') => ({
        active: false,
        selected: null,
        idSuffix: suffix,
        maps: { in: null, out: null },

        toggleDetail(payload) {
            const isSame = this.selected?.id === payload.id;
            
            // Selalu bersihkan map lama sebelum inisialisasi baru
            this.cleanup();

            this.active = isSame ? !this.active : true;
            this.selected = isSame && !this.active ? null : payload;

            if (this.active && this.selected) {
                this.$nextTick(() => {
                    // Deteksi koordinat (mendukung location_in atau latlng_in)
                    const locIn = this.selected.location_in || this.selected.latlng_in;
                    const locOut = this.selected.location_out || this.selected.latlng_out;

                    this.maps.in = renderLeaflet(`mapIn_${this.idSuffix}`, locIn);
                    this.maps.out = renderLeaflet(`mapOut_${this.idSuffix}`, locOut);
                });
            }
        },

        cleanup() {
            if (this.maps.in) { this.maps.in.remove(); this.maps.in = null; }
            if (this.maps.out) { this.maps.out.remove(); this.maps.out = null; }
        },

        close() {
            this.active = false;
            setTimeout(() => { this.cleanup(); this.selected = null; }, 400);
        }
    }));
});