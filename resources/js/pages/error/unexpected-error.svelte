<script lang="ts">
    import { Link } from '@inertiajs/svelte';
    import IndexLayout from '@/layouts/index-layout.svelte';
    import AppHead from '@/lib/components/AppHead.svelte';
    import { buttonVariants } from '@/lib/components/ui/button';
</script>

<AppHead title="404" />

<IndexLayout>
    <main class="flex min-h-screen justify-center items-center flex-col gap-3">
        <h1 class="text-3xl font-bold">500</h1>
        <h2 class="text-2xl font-semibold">Terjadi Kesalahan</h2>
        <Link class={buttonVariants({ size: 'lg' })} href="/"
            >Kembali ke Halaman Utama</Link
        >
    </main>
</IndexLayout>
