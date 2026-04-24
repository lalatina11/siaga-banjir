<script lang="ts">
    import { Link, usePage } from '@inertiajs/svelte';
    import ModeToggle from '../mode-toggle.svelte';
    import { buttonVariants } from '../ui/button';
    import UserAvatar from '../user/user-avatar.svelte';
    import UserDropdown from '../user/user-dropdown.svelte';
    const { auth } = usePage().props;
</script>

<header
    class="flex justify-between items-center p-4 bg-card border-b border-foreground/10"
>
    <Link href="/" class="tracking-wide text-3xl font-extrabold">SB</Link>
    <div class="flex gap-2 items-center">
        <ModeToggle />
        {#if auth.user !== null}
            <UserDropdown>
                <UserAvatar />
            </UserDropdown>
        {:else}
            <Link
                href="/auth?tab=login"
                class={`w-fit mx-auto ${buttonVariants({ size: 'lg' })}`}
                >Login</Link
            >
        {/if}
    </div>
</header>
