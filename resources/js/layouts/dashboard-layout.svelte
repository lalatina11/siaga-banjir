<script lang="ts">
    import { usePage } from '@inertiajs/svelte';
    import type { Snippet } from 'svelte';
    import FloodNotification from '@/lib/components/floods/flood-notification.svelte';
    import ModeToggle from '@/lib/components/mode-toggle.svelte';
    import DashboardSidebar from '@/lib/components/sidebar/dashboard-sidebar.svelte';
    import * as Sidebar from '@/lib/components/ui/sidebar';
    import UserAvatar from '@/lib/components/user/user-avatar.svelte';
    import UserDropdown from '@/lib/components/user/user-dropdown.svelte';
    import { roleToIndonesianLang } from '@/lib/helpers';
    import type { DefaultPageProps } from '@/lib/types';
    import IndexLayout from './index-layout.svelte';
    interface Props {
        children: Snippet<[]>;
    }
    const { children }: Props = $props();
    const pageProps = usePage().props as DefaultPageProps;
</script>

<IndexLayout>
    <Sidebar.Provider open={pageProps.sidebar_state !== 'false'}>
        <DashboardSidebar />
        <main class="flex flex-col min-h-screen w-full">
            <header
                class="p-4 bg-card flex justify-between border-b border-foreground/10"
            >
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
                <div class="flex gap-2 items-center">
                    <FloodNotification />
                    <ModeToggle />
                    <UserDropdown>
                        <UserAvatar />
                    </UserDropdown>
                </div>
            </header>
            <section class="p-4 flex-1">
                {@render children()}
            </section>
        </main>
    </Sidebar.Provider>
</IndexLayout>
