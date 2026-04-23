<script lang="ts">
    import DashboardLayout from '@/layouts/dashboard-layout.svelte';
    import AppHead from '@/lib/components/AppHead.svelte';
    import FloodCard from '@/lib/components/floods/flood-card.svelte';
    import { Button } from '@/lib/components/ui/button';
    import * as ButtonGroup from '@/lib/components/ui/button-group';
    import * as InputGroup from '@/lib/components/ui/input-group';
    import { useSidebar } from '@/lib/components/ui/sidebar';
    import { floodFilterCapitalize } from '@/lib/helpers';
    import type {
        AllowedFloodFilter,
        DefaultPageProps,
        FloodWithUser,
    } from '@/lib/types';
    import { allowedFloodStatus } from '@/lib/validations/flood-validations';
    import { usePage } from '@inertiajs/svelte';
    import { Search } from '@lucide/svelte';

    interface Props extends DefaultPageProps {
        floods: Array<FloodWithUser>;
    }

    let search = $state('');

    const { floods } = usePage().props as Props;
    console.log({ floods });

    const allowedFilters = [
        'ALL',
        ...allowedFloodStatus,
    ] satisfies Array<AllowedFloodFilter>;
    let activeFilter = $state(allowedFilters[0]);
    let filteredFloods = $derived(
        activeFilter === 'ALL'
            ? floods
            : floods.filter((flood) => flood.status === activeFilter),
    );
    const handleFilter = (filter: AllowedFloodFilter) => {
        activeFilter = filter;
    };
    const filteredAndSearchedFlood = $derived(
        search
            ? filteredFloods.filter(
                  (fl) =>
                      fl.description
                          .toLocaleLowerCase()
                          .includes(search.toLocaleLowerCase()) ||
                      fl.user?.name
                          .toLocaleLowerCase()
                          .includes(search.toLocaleLowerCase()),
              )
            : filteredFloods,
    );
</script>

<AppHead title="Dashboard User " />

<DashboardLayout>
    <main class="flex flex-col gap-3">
        <div class="flex justify-start flex-col items-start">
            <div class="p-4 flex gap-2 items-center">
                <div class="flex flex-col gap-2">
                    <span class="font-semibold hidden lg:inline">Filter:</span>
                    <ButtonGroup.Root class="hidden md:inline">
                        {#each allowedFilters as filter (filter)}
                            <Button
                                variant={filter === activeFilter
                                    ? 'default'
                                    : 'outline'}
                                onclick={() => handleFilter(filter)}
                                size="lg"
                                >{floodFilterCapitalize(filter)}</Button
                            >
                        {/each}
                    </ButtonGroup.Root>
                </div>
                <div class="inline md:hidden flex-col gap-1">
                    <ButtonGroup.Root>
                        {#each allowedFilters.slice(0, 2) as filter (filter)}
                            <Button
                                variant={filter === activeFilter
                                    ? 'default'
                                    : 'outline'}
                                onclick={() => handleFilter(filter)}
                                size="lg"
                                >{floodFilterCapitalize(filter)}</Button
                            >
                        {/each}
                    </ButtonGroup.Root>
                    <ButtonGroup.Root>
                        {#each allowedFilters.slice(3, allowedFilters.length) as filter (filter)}
                            <Button
                                variant={filter === activeFilter
                                    ? 'default'
                                    : 'outline'}
                                onclick={() => handleFilter(filter)}
                                size="lg"
                                >{floodFilterCapitalize(filter)}</Button
                            >
                        {/each}
                    </ButtonGroup.Root>
                </div>
            </div>
            <InputGroup.Root class="w-1/2 md:w-1/3 ml-6 md:ml-4">
                <InputGroup.Input bind:value={search} placeholder="Search..." />
                <InputGroup.Addon align="inline-start">
                    <Search />
                </InputGroup.Addon>
            </InputGroup.Root>
        </div>
        {#if filteredAndSearchedFlood.length > 0}
            <div
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 p-4 gap-3"
            >
                {#each filteredAndSearchedFlood as flood (flood.id)}
                    <FloodCard {flood} />
                {/each}
            </div>
        {:else if (filteredAndSearchedFlood.length < 1 && activeFilter !== 'ALL') || (filteredAndSearchedFlood.length && search)}
            <span class="flex h-full justify-center items-center min-h-[75vh]">
                Tidak ada laporan banjir yang sesuai dengan filter atau
                pencarian, coba ganti filter ke semua
            </span>
        {:else if filteredAndSearchedFlood.length < 1 && activeFilter === 'ALL'}
            <span class="flex h-full justify-center items-center min-h-[75vh]">
                Belum ada laporan banjir untuk ditampilkan
            </span>
        {/if}
    </main>
</DashboardLayout>
