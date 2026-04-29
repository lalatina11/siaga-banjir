<script lang="ts">
    import { Link, usePage } from '@inertiajs/svelte';
    import { HatGlasses, Hourglass, ShieldCheck } from '@lucide/svelte';
    import { floodStatusCapitalize, roleToIndonesianLang } from '@/lib/helpers';
    import { useRoleBasedPermission } from '@/lib/helpers/role-and-access';
    import type { FloodWithUser } from '@/lib/types';
    import AcceptFlood from '../form/flood-form/accept-flood.svelte';
    import * as Avatar from '../ui/avatar';
    import { Badge } from '../ui/badge';
    import { Button, buttonVariants } from '../ui/button';
    import * as Card from '../ui/card';
    import UserAvatar from '../user/user-avatar.svelte';
    interface Props {
        flood: FloodWithUser;
    }
    const permission = useRoleBasedPermission();
    const { flood }: Props = $props();
    const pageProps = usePage().props;
</script>

<Card.Root>
    {#if flood.user}
        <Card.Header class="flex flex-row gap-3 items-center">
            <UserAvatar src={flood.user.avatar} />
            <div class="flex flex-col gap-0">
                <Card.Title class="text-sm">{flood.user.name}</Card.Title>
                {#if flood.user && flood.user.role !== 'USER'}
                    <Card.Description>
                        <Badge>
                            <ShieldCheck />
                            {roleToIndonesianLang(flood.user.role)}
                        </Badge>
                    </Card.Description>
                {/if}
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
        {#if flood.status !== 'PENDING' || (flood.status === 'PENDING' && pageProps.auth.user !== null && permission.adminOrAbove(pageProps.auth.user))}
            {#if flood.status === 'PENDING'}
                <div class="flex gap-2 items-center w-fit ml-auto">
                    <AcceptFlood floodId={flood.id} />
                    <Link
                        href={`/flood/${flood.id}`}
                        class={`ml-auto ${buttonVariants({ size: 'lg' })}`}
                        >Lihat Selengkapnya</Link
                    >
                </div>
            {:else}
                <Link
                    href={`/flood/${flood.id}`}
                    class={`ml-auto ${buttonVariants({ size: 'lg' })}`}
                    >Lihat Selengkapnya</Link
                >
            {/if}
        {:else}
            <Button class="ml-auto" disabled><Hourglass /> Pending</Button>
        {/if}
    </Card.Footer>
</Card.Root>
