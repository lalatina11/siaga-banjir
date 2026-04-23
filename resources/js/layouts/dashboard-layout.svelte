<script lang="ts">
    import AppSidebar from '@/lib/components/sidebar/app-sidebar.svelte';
    import * as Sidebar from '@/lib/components/ui/sidebar';
    import { roleToIndonesianLang } from '@/lib/helpers';
    import { usePage } from '@inertiajs/svelte';
    import type { Snippet } from 'svelte';
    import IndexLayout from './index-layout.svelte';
    interface Props {
        children: Snippet<[]>;
    }
    const { children }: Props = $props();
    const pageProps = usePage().props;
</script>

<IndexLayout>
    <Sidebar.Provider>
        <AppSidebar />
        <main class="flex flex-col min-h-screen w-full">
            <header class="p-4 bg-card flex justify-between">
                <div class="flex gap-2 items-center">
                    <Sidebar.Trigger />
                    {#if pageProps.auth.user && pageProps.auth.user.role}
                        <span
                            >Dashboard {roleToIndonesianLang(
                                pageProps.auth.user.role,
                            )}</span
                        >
                    {:else}
                        <span>Dashboard</span>
                    {/if}
                </div>
            </header>
            <section class="p-4 flex-1">
                {@render children()}
            </section>
        </main>
    </Sidebar.Provider>
</IndexLayout>
