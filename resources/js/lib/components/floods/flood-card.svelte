<script lang="ts">
    import { floodStatusCapitalize } from '@/lib/helpers';
    import type { FloodWithUser } from '@/lib/types';
    import { Link } from '@inertiajs/svelte';
    import { HatGlasses } from '@lucide/svelte';
    import * as Avatar from '../ui/avatar';
    import { Badge } from '../ui/badge';
    import { buttonVariants } from '../ui/button';
    import * as Card from '../ui/card';
    import UserAvatar from '../user/user-avatar.svelte';
    interface Props {
        flood: FloodWithUser;
    }
    const { flood }: Props = $props();
</script>

<Card.Root>
    {#if flood.user}
        <Card.Header class="flex flex-row gap-3 items-center">
            <UserAvatar src={flood.user.avatar} />
            <div class="flex flex-col gap-0">
                <Card.Title class="text-sm">{flood.user.name}</Card.Title>
                <!-- <Card.Description class="text-xs"
                >{flood.user.created_at}</Card.Description
                > -->
            </div>
        </Card.Header>
    {:else}
        <Card.Header class="flex flex-row gap-3 items-center">
            <Avatar.Root>
                <Avatar.Fallback>
                    <HatGlasses />
                </Avatar.Fallback>
            </Avatar.Root>
            <div class="flex flex-col gap-0">
                <Card.Title class="text-sm">anonymous</Card.Title>
                <Card.Description class="text-xs"
                    >anonymous@anon.com</Card.Description
                >
            </div>
        </Card.Header>
    {/if}
    <Card.Content class="flex flex-col gap-3 flex-1">
        <Badge>{floodStatusCapitalize(flood.status)}</Badge>
        <span class="flex-1">
            {flood.description || 'Tidak ada deskripsi'}
        </span>
        <img
            src={flood.image}
            alt="Gambar banjir"
            class="w-full aspect-square object-cover rounded-md"
        />
    </Card.Content>
    <Card.Footer>
        <Link
            href={`/flood/${flood.id}`}
            class={`ml-auto ${buttonVariants({ size: 'lg' })}`}
            >Lihat Selengkapnya</Link
        >
    </Card.Footer>
</Card.Root>
