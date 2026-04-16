<script lang="ts">
    import { type ParentProps } from '$lib/types/parent-props';
    import LogoutForm from '@/lib/components/form/auth-form/logout-form.svelte';
    import IndexLayout from './index-layout.svelte';
    import { Link, usePage } from '@inertiajs/svelte';
    import { buttonVariants } from '@/lib/components/ui/button';
    import ModeToggle from '@/lib/components/mode-toggle.svelte';
    interface Props extends ParentProps {}

    const { auth } = usePage().props;
    const { children }: Props = $props();
</script>

<IndexLayout>
    <header
        class="flex justify-between items-center p-4 bg-card border-b border-muted-foreground"
    >
        <Link class="tracking-wide text-3xl font-extrabold">SB</Link>
        <div class="flex gap-2 items-center">
            <ModeToggle />
            {#if auth.user !== null}
                <LogoutForm className="w-fit mx-auto" />
            {:else}
                <Link
                    href="/auth?tab=login"
                    class={`w-fit mx-auto ${buttonVariants({ size: 'lg' })}`}
                    >Login</Link
                >
            {/if}
        </div>
    </header>
    {@render children()}
</IndexLayout>
