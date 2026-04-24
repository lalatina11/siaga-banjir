<script lang="ts">
    import MainLayout from '@/layouts/main-layout.svelte';
    import AppHead from '@/lib/components/AppHead.svelte';
    import AcceptFlood from '@/lib/components/form/flood-form/accept-flood.svelte';
    import FloodAidTable from '@/lib/components/form/flood-form/flood-aid-table.svelte';
    import SendAid from '@/lib/components/form/flood-form/send-aid.svelte';
    import * as Avatar from '@/lib/components/ui/avatar';
    import { Button } from '@/lib/components/ui/button';
    import * as Card from '@/lib/components/ui/card';
    import { useRoleBasedPermission } from '@/lib/helpers/role-and-access';
    import type {
        PageProps as DefaultPageProps,
        FloodAndAid,
    } from '@/lib/types';
    import { usePage } from '@inertiajs/svelte';
    import { ArrowLeft, HatGlasses } from '@lucide/svelte';
    import { type MapOptions } from 'leaflet';
    import 'leaflet/dist/leaflet.css';
    import { onDestroy, onMount } from 'svelte';

    interface PageProps extends DefaultPageProps {
        flood: FloodAndAid;
    }

    const { flood, auth } = usePage().props as PageProps;

    $inspect(flood);

    const permission = useRoleBasedPermission();

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
            class="mt-5 ml-5 w-fit mr-auto px-5"
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
                        <Avatar.Fallback>
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
                        src={flood.image}
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
                    <div
                        bind:this={mapElement}
                        class="map rounded-md z-10"
                    ></div>
                </Card.Content>
                <Card.Footer class="flex gap-2 justify-end items-end w-full">
                    {#if flood.status === 'PENDING' && permission.adminOrAbove(auth.user)}
                        <div class="flex gap-2 w-fit ml-auto items-center">
                            <AcceptFlood floodId={flood.id} />
                        </div>
                    {:else if flood.status === 'NEW' && permission.adminOrAbove(auth.user)}
                        <div class="flex gap-2 w-fit ml-auto items-center">
                            <SendAid floodId={flood.id} />
                        </div>
                    {/if}
                    <Button
                        size="lg"
                        onclick={() => {
                            const url = `https://www.google.com/maps?q=${flood.lat},${flood.lng}`;
                            window.open(url, '_blank');
                        }}>Lihat di Maps</Button
                    >
                </Card.Footer>
            </Card.Root>
        </section>
        {#if flood.flood_aid}
            <section
                class="bg-card ring ring-foreground/10 m p-5 m-5 rounded-md"
            >
                <h1 class="text-2xl font-semibold">Bantuan</h1>
                <FloodAidTable items={flood.flood_aid.flood_aid_items} />
            </section>
        {/if}
    </main>
</MainLayout>

<style>
    .map {
        height: 500px;
        width: 500px;
        z-index: 10;
    }
</style>
