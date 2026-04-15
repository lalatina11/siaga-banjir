<script lang="ts">
    import MainLayout from '@/layouts/main-layout.svelte';
    import type { MapOptions, TileLayerOptions } from 'leaflet';
    import { onMount, tick } from 'svelte';
    import { LeafletMap, Marker, Popup, TileLayer } from 'svelte-leafletjs';
    import type { Hst as HstType } from '@histoire/plugin-svelte';

    let Hst: HstType;

    // Tambahkan tick
    let leafletMap: any; // Untuk binding komponen

    const mapOptions: MapOptions = {
        center: [-7.4244, 109.2303],
        zoom: 13,
    };

    const tileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';

    const tileOptions: TileLayerOptions = {
        attribution: '&copy; OpenStreetMap contributors',
    };

    onMount(async () => {
        // Tunggu sampai DOM benar-benar stabil
        await tick();

        // Ambil instance map asli dari wrapper
        const mapInstance = leafletMap.getMap();

        if (mapInstance) {
            // Paksa Leaflet menghitung ulang dimensi kontainer
            setTimeout(() => {
                mapInstance.invalidateSize();
            }, 100);
        }
        window.addEventListener('resize', () => {
            mapInstance.invalidateSize();
        });
        document.documentElement.classList.remove('dark');
    });
</script>

<MainLayout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Peta Pantauan Banjir Cepat</h1>

        <div
            class="h-[600px] w-full border rounded-lg overflow-hidden relative"
        >
            <LeafletMap bind:this={leafletMap} options={mapOptions}>
                <TileLayer url={tileUrl} options={tileOptions} />
                <Marker latLng={[-7.4244, 109.2303]}>
                    <Popup>Pusat Kota Purwokerto</Popup>
                </Marker>
            </LeafletMap>
        </div>
    </div>
</MainLayout>

<style>
    :global(.leaflet-container) {
        height: 100% !important;
        width: 100% !important;
        background: #262626;
    }
</style>
