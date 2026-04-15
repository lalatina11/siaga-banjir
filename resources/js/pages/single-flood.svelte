<script lang="ts">
    import { onMount, onDestroy } from 'svelte';
    import 'leaflet/dist/leaflet.css';
    import { marker, type MapOptions } from 'leaflet';
    import MainLayout from '@/layouts/main-layout.svelte';
    import * as Card from '@/lib/components/ui/card';

    let mapElement: HTMLElement;
    let map: any;
    let markerId = $state('');

    const mapOptions = {
        center: [-7.4244, 109.2303],
        zoom: 10,
    } satisfies MapOptions;

    onMount(async () => {
        const leaflet = await import('leaflet');
        map = leaflet
            .map(mapElement)
            .setView(mapOptions.center, mapOptions.zoom)
            .on('click', (e) => {
                leaflet
                    .marker({ ...e.latlng })
                    .addTo(map)
                    .bindPopup('Banjir');
            });
        leaflet
            .tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
            })
            .addTo(map);
        // leaflet.marker(mapOptions.center).addTo(map).bindPopup('Banjir');
    });

    onDestroy(() => {
        if (map) map.remove();
    });
</script>

<MainLayout>
    <main class="flex flex-col">
        <Card.Root
            class="mx-auto flex flex-col justify-center items-center mt-10"
        >
            <Card.Content
                class="w-[350px] md:w-[600px] overflow-hidden aspect-square flex justify-center items-center"
            >
                <div bind:this={mapElement} class="map rounded-md"></div>
            </Card.Content>
        </Card.Root>
    </main>
</MainLayout>

<style>
    .map {
        height: 500px;
        width: 500px;
    }
</style>
