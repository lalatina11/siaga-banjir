<script lang="ts">
    import AppHead from '@/lib/components/AppHead.svelte';
    import IndexLayout from '@/layouts/index-layout.svelte';
    import { buttonVariants } from '@/lib/components/ui/button';
    import { Link } from '@inertiajs/svelte';

    interface Props {
        path: '/login' | '/register' | string;
    }
    const { path } = $props();
</script>

<AppHead title="404" />

<IndexLayout>
    <main class="flex min-h-screen justify-center items-center flex-col gap-3">
        <h1 class="text-3xl font-bold">404</h1>
        {#if path === '/login'}
            <h2 class="text-xl font-semibold">
                Apakah anda bermaksud ke halaman login?
            </h2>
            <Link class={buttonVariants({ size: 'lg' })} href="/auth?tab=login"
                >Login</Link
            >
        {:else if path === '/register'}
            <h2 class="text-xl font-semibold">
                Apakah anda bermaksud ke halaman pendaftaran?
            </h2>
            <Link
                class={buttonVariants({ size: 'lg' })}
                href="/auth?tab=register">Daftar</Link
            >
        {:else}
            <Link class={buttonVariants({ size: 'lg' })} href="/"
                >Kembali ke Halaman Utama</Link
            >
        {/if}
    </main>
</IndexLayout>
