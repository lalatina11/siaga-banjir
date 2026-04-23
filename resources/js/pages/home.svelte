<script lang="ts">
    import MainLayout from '@/layouts/main-layout.svelte';
    import AppHead from '@/lib/components/AppHead.svelte';
    import FloodCard from '@/lib/components/floods/flood-card.svelte';
    import { Button } from '@/lib/components/ui/button';
    import * as ButtonGroup from '@/lib/components/ui/button-group';
    import { floodFilterCapitalize } from '@/lib/helpers';
    import type {
        AllowedFloodFilter,
        PageProps as DefaultPageProps,
        FloodWithUser,
    } from '@/lib/types';
    import { allowedFloodFilters } from '@/lib/validations/flood-validations';
    import { usePage } from '@inertiajs/svelte';

    interface PageProps extends DefaultPageProps {
        floods: Array<FloodWithUser>;
        avatar: string;
    }

    const { floods, avatar, ...props } = usePage().props as PageProps;
    const floodFilters = allowedFloodFilters.filter((st) => st !== 'PENDING');
    let activeFilter = $state(floodFilters[0]);
    let filteredFloods = $derived(
        activeFilter === 'ALL'
            ? floods
            : floods.filter((fl) => fl.status === activeFilter),
    );

    const handleFilter = (filter: (typeof floodFilters)[number]) => {
        activeFilter = filter;
    };
</script>

<AppHead title="Home" />
<MainLayout>
    <div class="p-4 flex gap-2 items-center">
        <span class="font-semibold">Filter:</span>
        <ButtonGroup.Root>
            {#each floodFilters as filter (filter)}
                <Button
                    variant={filter === activeFilter ? 'default' : 'outline'}
                    onclick={() => handleFilter(filter)}
                    size="lg">{floodFilterCapitalize(filter)}</Button
                >
            {/each}
        </ButtonGroup.Root>
    </div>
    <main class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 p-4 gap-3">
        {#each filteredFloods as flood (flood.id)}
            <FloodCard {flood} />
        {/each}
    </main>
</MainLayout>
