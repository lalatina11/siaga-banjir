<script lang="ts">
    import DashboardLayout from '@/layouts/dashboard-layout.svelte';
    import AppHead from '@/lib/components/AppHead.svelte';
    import FloodCard from '@/lib/components/floods/flood-card.svelte';
    import { Button } from '@/lib/components/ui/button';
    import * as ButtonGroup from '@/lib/components/ui/button-group';
    import { floodFilterCapitalize } from '@/lib/helpers';
    import type {
        AllowedFloodFilter,
        DefaultPageProps,
        FloodWithUser,
    } from '@/lib/types';
    import { allowedFloodFilters } from '@/lib/validations/flood-validations';
    import { usePage } from '@inertiajs/svelte';

    interface Props extends DefaultPageProps {
        floods: Array<FloodWithUser>;
    }

    const { floods } = usePage().props as Props;
    console.log({ floods });

    let activeFilter = $state(allowedFloodFilters[0]);
    let filteredFloods = $derived(
        activeFilter === 'ALL'
            ? floods
            : floods.filter((flood) => flood.status === activeFilter),
    );
    const handleChangeFilter = (filter: AllowedFloodFilter) => {
        activeFilter = filter;
    };
</script>

<AppHead title="Dashboard User " />

<DashboardLayout>
    <main class="flex flex-col gap-3">
        <div class="flex gap-2 items-center">
            <span class="font-semibold">Filter:</span>
            <ButtonGroup.Root>
                {#each allowedFloodFilters as filter (filter)}
                    <Button
                        variant={filter === activeFilter
                            ? 'default'
                            : 'outline'}
                        onclick={() => handleChangeFilter(filter)}
                        >{floodFilterCapitalize(filter)}</Button
                    >
                {/each}
            </ButtonGroup.Root>
        </div>
        {#if filteredFloods.length > 0}
            <div
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 p-4 gap-3"
            >
                {#each filteredFloods as flood (flood.id)}
                    <FloodCard {flood} />
                {/each}
            </div>
        {:else if filteredFloods.length < 1 && activeFilter !== 'ALL'}
            <span class="flex h-full justify-center items-center"
                >Tidak ada laporan banjir yang sesuai dengan filter, coba ganti
                filter ke semua</span
            >
        {:else if filteredFloods.length < 1 && activeFilter !== 'ALL'}
            <span>Anda belum pernah membuat laporan banjir</span>
        {/if}
    </main>
</DashboardLayout>
