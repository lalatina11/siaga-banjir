<script lang="ts">
    import AppHead from '@/components/AppHead.svelte';
    import MainLayout from '@/layouts/main-layout.svelte';
    import LogoutForm from '@/lib/components/form/auth-form/logout-form.svelte';
    import { Button, buttonVariants } from '@/lib/components/ui/button';
    import { Link, usePage } from '@inertiajs/svelte';
    import { toast } from 'svelte-sonner';
    const { auth, ...props } = usePage().props;

    function handleBtn() {
        toast.error('Hei');
    }
</script>

<AppHead title="Home" />
<MainLayout>
    <main class="flex flex-col min-h-screen">
        <span>Main</span>
        <Button onclick={handleBtn}>Test</Button>
        <data
            >Lorem ipsum dolor sit, amet consectetur adipisicing elit. Itaque
            illum a velit suscipit fugit facilis sit atque eos, sint ipsa unde
            error tempora, maiores harum architecto nihil ab explicabo minima!</data
        >
        {#if auth.user !== null}
            <LogoutForm className="w-fit mx-auto" />
        {:else}
            <Link
                href="/auth?tab=login"
                class={`w-fit mx-auto ${buttonVariants({ size: 'lg' })}`}
                >Login</Link
            >
        {/if}
    </main>
</MainLayout>
