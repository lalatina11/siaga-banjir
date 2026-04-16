<script lang="ts">
    import AppHead from '@/components/AppHead.svelte';
    import MainLayout from '@/layouts/main-layout.svelte';
    import * as Avatar from '@/lib/components/ui/avatar';
    import { buttonVariants } from '@/lib/components/ui/button';
    import * as Card from '@/lib/components/ui/card';
    import type { PageProps as DefaultPageProps, Flood } from '@/lib/types';
    import { Link, usePage } from '@inertiajs/svelte';
    import { HatGlasses, User } from '@lucide/svelte';

    interface PageProps extends DefaultPageProps {
        floods: Array<Flood>;
        avatar: string;
    }

    const { floods, avatar, ...props } = usePage().props as PageProps;
</script>

<AppHead title="Home" />
<MainLayout>
    <main class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 p-4 gap-3">
        {#each floods as flood (flood.id)}
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
