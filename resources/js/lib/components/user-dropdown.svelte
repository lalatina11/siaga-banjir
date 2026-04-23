<script lang="ts">
    import { Link, usePage } from '@inertiajs/svelte';
    import { buttonVariants } from './ui/button';
    import * as DropdownMenu from './ui/dropdown-menu';
    import * as Avatar from './ui/avatar';
    import type { VisitHelperOptions } from '@inertiajs/core';
    import { router } from '@inertiajs/svelte';
    import { LogOut, Plus, User } from '@lucide/svelte';
    import { toast } from 'svelte-sonner';
    import { Spinner } from './ui/spinner';
    import { roleToIndonesianLang } from '../helpers';
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
</script>

<DropdownMenu.Root>
    <DropdownMenu.Trigger
        class={buttonVariants({ size: 'icon-lg', variant: 'ghost' })}
    >
        <Avatar.Root>
            <Avatar.Image src={auth.user.avatar} />
            <Avatar.Fallback>
                <User />
            </Avatar.Fallback>
        </Avatar.Root>
    </DropdownMenu.Trigger>
    <DropdownMenu.Content class="w-[300px]">
        <DropdownMenu.Label
            >Login sebagai: {roleToIndonesianLang(
                auth.user.role,
            )}</DropdownMenu.Label
        >
        <Link
            href="/dashboard/{auth.user.role === 'SUPERADMIN'
                ? 'superadmin'
                : auth.user.role === 'ADMIN'
                  ? 'admin'
                  : ''}"
        >
            <DropdownMenu.Item>Dashboard</DropdownMenu.Item>
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
