<script lang="ts">
    import AppHead from '@/components/AppHead.svelte';
    import MainLayout from '@/layouts/main-layout.svelte';
    import * as Avatar from '@/lib/components/ui/avatar';
    import { Button } from '@/lib/components/ui/button';
    import * as Card from '@/lib/components/ui/card';
    import type { PageProps as DefaultPageProps, Flood } from '@/lib/types';
    import { usePage } from '@inertiajs/svelte';
    import { ArrowLeft, HatGlasses } from '@lucide/svelte';
    import { type MapOptions } from 'leaflet';
    import 'leaflet/dist/leaflet.css';
    import { onDestroy, onMount } from 'svelte';

    interface PageProps extends DefaultPageProps {
        flood: Flood;
    }

    const { flood } = usePage().props as PageProps;

    let mapElement: HTMLElement;
    let map: any;

    let latlng = $derived<MapOptions['center']>([flood.lat, flood.lng]);

    const mapOptions = {
        center: [-7.4244, 109.2303],
        zoom: 10,
    } satisfies MapOptions;

    onMount(async () => {
        const leaflet = await import('leaflet');
        map = leaflet
            .map(mapElement)
            .setView(latlng || mapOptions.center, mapOptions.zoom);

        leaflet
            .tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
            })
            .addTo(map);
        leaflet
            .marker(latlng || mapOptions.center)
            .addTo(map)
            .bindPopup('Banjir');
    });

    onDestroy(() => {
        if (map) {
            map.remove();
        }
    });
</script>

<AppHead title="Banjir {flood.id}" />

<MainLayout>
    <main class="flex flex-col">
        <Button
            class="mt-5 ml-10 w-fit mr-auto"
            size="lg"
            onclick={() => {
                if (map) {
                    map.remove();
                }
                window.location.href = '/';
            }}
        >
            <ArrowLeft />
            Back</Button
        >
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-10 p-5">
            <Card.Root>
                <Card.Header class="flex flex-row gap-3 items-center">
                    <Avatar.Root>
                        <!-- <Avatar.Image src={avatar} /> -->
                        <Avatar.Fallback>
                            <!-- <User /> -->
                            <HatGlasses />
                        </Avatar.Fallback>
                    </Avatar.Root>
                    <div class="flex flex-col gap-0">
                        <Card.Title class="text-sm">Oleh anonymous</Card.Title>
                        <Card.Description class="text-xs"
                            >anonymous@anon.com</Card.Description
                        >
                    </div>
                </Card.Header>
                <Card.Content class="flex flex-col gap-3 flex-1">
                    <span class="flex-1">
                        {flood.description || 'Tidak ada deskripsi'}
                    </span>
                    <img
                        src={'https://imgs.search.brave.com/dRa4h7ULbtiSUe0nvs0d_an56m5gniWMi7A3jXKwvho/rs:fit:500:0:1:0/g:ce/aHR0cHM6Ly9pbWFn/ZXMucGV4ZWxzLmNv/bS9waG90b3MvNjQ3/MTkyNy9wZXhlbHMt/cGhvdG8tNjQ3MTky/Ny5qcGVnP2F1dG89/Y29tcHJlc3MmY3M9/dGlueXNyZ2ImZHBy/PTEmdz01MDA'}
                        alt="Gambar banjir"
                        width="1000"
                        height="1000"
                        class="w-full aspect-square object-cover rounded-md"
                    />
                </Card.Content>
            </Card.Root>
            <Card.Root class="flex flex-col justify-center items-center">
                <Card.Header>
                    <Card.Title>Lokasi</Card.Title>
                    <Card.Description></Card.Description>
                </Card.Header>
                <Card.Content
                    class="w-full overflow-hidden aspect-square flex justify-center items-center"
                >
                    <div bind:this={mapElement} class="map rounded-md"></div>
                </Card.Content>
                <Card.Footer class="w-full">
                    <Button
                        class="ml-auto"
                        size="lg"
                        onclick={() => {
                            const url = `https://www.google.com/maps?q=${flood.lat},${flood.lng}`;
                            window.open(url, '_blank');
                        }}>Lihat di Maps</Button
                    >
                </Card.Footer>
            </Card.Root>
        </section>
    </main>
</MainLayout>

<style>
    .map {
        height: 500px;
        width: 500px;
    }
</style>
