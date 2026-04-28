<script lang="ts">
    import type { VisitHelperOptions } from '@inertiajs/core';
    import { Link, router, usePage } from '@inertiajs/svelte';
    import { LayoutDashboard, LogOut, Plus, User } from '@lucide/svelte';
    import type { Snippet } from 'svelte';
    import { toast } from 'svelte-sonner';
    import { roleToIndonesianLang } from '../../helpers';
    import * as DropdownMenu from '../ui/dropdown-menu';
    import { Spinner } from '../ui/spinner';
    import UserAvatar from './user-avatar.svelte';
    const { auth } = usePage().props;

    let isLoading = $state(false);

    function handleLogOut() {
        const requestOptions = {
            onStart: () => {
                isLoading = true;
            },
            onFinish: () => {
                isLoading = false;
            },
            onError: (err) => {
                const description = err[0] || 'Coba lagi beberapa saat';
                toast.error('Terjadi Kesalahan!', { description });
            },
            onSuccess: () => {
                toast.success('Berhasil Log out!', {
                    description: 'Anda akan di arahkan ke halaman login!',
                });
            },
        } satisfies VisitHelperOptions;
        router.post('/logout', undefined, requestOptions);
    }

    interface Props {
        children?: Snippet<[]>;
    }
    const { children }: Props = $props();
</script>

<DropdownMenu.Root>
    <DropdownMenu.Trigger>
        {#if children}
            {@render children()}
        {/if}
    </DropdownMenu.Trigger>
    <DropdownMenu.Content class="w-[300px] z-30">
        <div class="flex flex-col justify-center items-center my-2">
            <UserAvatar />
            <span class="text-sm">{auth.user.name}</span>
            <span class="text-sm text-muted-foreground">{auth.user.email}</span>
        </div>
        <DropdownMenu.Separator />
        {#if auth.user.role !== 'USER'}
            <DropdownMenu.Label
                >Login sebagai: {roleToIndonesianLang(
                    auth.user.role,
                )}</DropdownMenu.Label
            >
            <DropdownMenu.Separator />
        {/if}
        <Link
            href="/dashboard{auth.user.role === 'SUPERADMIN'
                ? '/superadmin'
                : auth.user.role === 'ADMIN'
                  ? '/admin'
                  : ''}"
        >
            <DropdownMenu.Item><LayoutDashboard /> Dashboard</DropdownMenu.Item>
        </Link>
        <Link href="/dashboard/profile">
            <DropdownMenu.Item><User /> Profile</DropdownMenu.Item>
        </Link>
        <Link href="/new-flood">
            <DropdownMenu.Item><Plus /> Lapor Banjir</DropdownMenu.Item>
        </Link>
        <DropdownMenu.Item variant="destructive" onclick={handleLogOut}>
            {#if isLoading}
                <Spinner />
            {:else}
                <LogOut /> Logout
            {/if}
        </DropdownMenu.Item>
    </DropdownMenu.Content>
</DropdownMenu.Root>
