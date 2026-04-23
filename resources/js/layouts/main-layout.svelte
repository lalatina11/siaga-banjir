<script lang="ts">
    import { type ParentProps } from '$lib/types/parent-props';
    import LogoutForm from '@/lib/components/form/auth-form/logout-form.svelte';
    import IndexLayout from './index-layout.svelte';
    import { Link, usePage } from '@inertiajs/svelte';
    import { buttonVariants } from '@/lib/components/ui/button';
    import ModeToggle from '@/lib/components/mode-toggle.svelte';
    import MainNavbar from '@/lib/components/headers/main-navbar.svelte';
    interface Props extends ParentProps {}

    const { auth } = usePage().props;
    const { children }: Props = $props();
</script>

<IndexLayout>
    <MainNavbar />
    {@render children()}
</IndexLayout>
