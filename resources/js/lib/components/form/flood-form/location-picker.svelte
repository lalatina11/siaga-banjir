<script lang="ts">
    import { onDestroy, onMount } from 'svelte';
    import { Button } from '$lib/components/ui/button';
    let map: any;
    let marker: any;
    let mapElement: HTMLElement;
    import 'leaflet/dist/leaflet.css';

    interface Props {
        lat: number;
        lng: number;
    }

    let { lat = $bindable(), lng = $bindable() }: Props = $props();

    let zoom = $state(11);

    function moveMarker(newLat: number, newLng: number) {
        lat = newLat;
        lng = newLng;

        if (marker) {
            marker.setLatLng([lat, lng]);
            map.setView([lat, lng], map.getZoom());
        }
    }

    onMount(async () => {
        const leaflet = await import('leaflet');

        map = leaflet.map(mapElement).setView([lat, lng], zoom);

        leaflet
            .tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
            })
            .addTo(map);

        // Simpan marker ke variabel, bukan langsung chain
        marker = leaflet
            .marker([lat, lng])
            .addTo(map)
            .bindPopup('Pilih lokasi banjir');

        // ✅ Event klik peta
        map.on('click', (e: any) => {
            moveMarker(e.latlng.lat, e.latlng.lng);
        });
    });

    onDestroy(() => {
        if (map) {
            map.remove();
        }
    });

    let isLocating = $state(false);
    let gpsError = $state('');

    async function getGPSLocation() {
        if (!navigator.geolocation) {
            gpsError = 'Browser tidak mendukung GPS';
            return;
        }

        isLocating = true;
        gpsError = '';

        navigator.geolocation.getCurrentPosition(
            (position) => {
                moveMarker(position.coords.latitude, position.coords.longitude);
                zoom = 13;
                isLocating = false;
            },
            (error) => {
                // Error codes: 1=PERMISSION_DENIED, 2=UNAVAILABLE, 3=TIMEOUT
                const messages: Record<number, string> = {
                    1: 'Izin GPS ditolak. Cek pengaturan browser.',
                    2: 'GPS tidak tersedia.',
                    3: 'Timeout. Coba lagi.',
                };
                gpsError = messages[error.code] || 'GPS error.';
                isLocating = false;
            },
            {
                enableHighAccuracy: true, // pakai GPS chip, bukan WiFi triangulation
                timeout: 10000, // max 10 detik
                maximumAge: 0, // selalu ambil lokasi fresh
            },
        );
    }
</script>

<div class="flex flex-col gap-3 justify-center items-center">
    <div
        bind:this={mapElement}
        class="map w-full md:w-sm mx-auto aspect-square rounded-md"
    ></div>

    <!-- Tombol GPS di atas peta -->
    <Button
        onclick={getGPSLocation}
        disabled={isLocating}
        class="shadow"
        variant="secondary"
        size="sm"
    >
        {#if isLocating}
            Mencari lokasi...
        {:else}
            📍 Lokasi saya
        {/if}
    </Button>
    {#if gpsError}
        <p class="text-sm text-destructive mt-1">{gpsError}</p>
    {/if}

    <p class="text-sm text-muted-foreground mt-2">
        Koordinat: {lat.toFixed(6)}, {lng.toFixed(6)}
    </p>
</div>

<style>
    .map {
        height: 350px;
        width: 350px;
    }
    @media (min-width: 768px) {
        .map {
            height: 500px;
            width: 500px;
        }
    }
</style>
