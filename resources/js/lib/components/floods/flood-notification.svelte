<script lang="ts">
    import { Link, usePage } from '@inertiajs/svelte';
    import { Bell } from '@lucide/svelte';
    import type { DefaultPageProps, Flood } from '@/lib/types';
    import { Badge } from '../ui/badge';
    import { Button } from '../ui/button';
    import * as DropdownMenu from '../ui/dropdown-menu';

    interface Props extends DefaultPageProps {
        latest_floods: Array<Flood>;
    }

    const props = usePage().props as Props;
</script>

<DropdownMenu.Root>
    <DropdownMenu.Trigger>
        <Button variant="outline" class="relative">
            <Badge
                variant="default"
                class="size-4 text-xs absolute -top-1 -right-1"
            >
                {props.latest_floods.length}
            </Badge>
            <Bell />
        </Button>
    </DropdownMenu.Trigger>
    <DropdownMenu.Content class="w-[300px] md:w-md">
        <DropdownMenu.Label>Laporan Banjir Terbaru</DropdownMenu.Label>
        {#each props.latest_floods as flood (flood.id)}
            <Link href={`/flood/${flood.id}`}>
                <DropdownMenu.Item
                    class="flex justify-start items-start flex-col gap-3"
                >
                    <div class="flex gap-2 items-center w-full">
                        <img
                            src={flood.image}
                            alt="..."
                            class="size-5 object-cover rounded-md"
                        />

                        <span class="text-sm text-muted-foreground">
                            {flood.description}
                        </span>
                    </div>
                </DropdownMenu.Item>
            </Link>
        {/each}
    </DropdownMenu.Content>
</DropdownMenu.Root>
