<script lang="ts">
    import AppHead from '@/components/AppHead.svelte';
    import IndexLayout from '@/layouts/index-layout.svelte';
    import { buttonVariants } from '@/lib/components/ui/button';
    import type { DefaultPageProps } from '@/lib/types';
    import { Link, usePage } from '@inertiajs/svelte';

    interface Props extends DefaultPageProps {
        error: string;
    }

    const { error } = usePage().props as Props;
    console.log(error);
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
