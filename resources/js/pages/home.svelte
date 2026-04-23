<script lang="ts">
    import AppHead from '@/components/AppHead.svelte';
    import MainLayout from '@/layouts/main-layout.svelte';
    import * as Avatar from '@/lib/components/ui/avatar';
    import { buttonVariants } from '@/lib/components/ui/button';
    import * as Card from '@/lib/components/ui/card';
    import type {
        PageProps as DefaultPageProps,
        FloodWithUser,
    } from '@/lib/types';
    import { Link, usePage } from '@inertiajs/svelte';
    import { HatGlasses, User as UserIcon } from '@lucide/svelte';

    interface PageProps extends DefaultPageProps {
        floods: Array<FloodWithUser>;
        avatar: string;
    }

    const { floods, avatar, ...props } = usePage().props as PageProps;
    console.log({ floods });
</script>

<AppHead title="Home" />
<MainLayout>
    <main class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 p-4 gap-3">
        {#each floods as flood (flood.id)}
            <Card.Root>
                {#if flood.user}
                    <Card.Header class="flex flex-row gap-3 items-center">
                        <Avatar.Root>
                            <Avatar.Image src={flood.user.avatar} />
                            <Avatar.Fallback>
                                <UserIcon />
                            </Avatar.Fallback>
                        </Avatar.Root>
                        <div class="flex flex-col gap-0">
                            <Card.Title class="text-sm"
                                >{flood.user.name}</Card.Title
                            >
                            <!-- <Card.Description class="text-xs"
                                >{flood.user.created_at}</Card.Description
                            > -->
                        </div>
                    </Card.Header>
                {:else}
                    <Card.Header class="flex flex-row gap-3 items-center">
                        <Avatar.Root>
                            <!-- <Avatar.Image src={avatar} /> -->
                            <Avatar.Fallback>
                                <!-- <User /> -->
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
        {/each}
    </main>
</MainLayout>
