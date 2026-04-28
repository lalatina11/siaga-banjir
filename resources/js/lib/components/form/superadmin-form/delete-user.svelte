<script lang="ts">
    import type { VisitHelperOptions } from '@inertiajs/core';
    import { router } from '@inertiajs/svelte';
    import { Trash } from '@lucide/svelte/icons';
    import { toast } from 'svelte-sonner';
    import { Button } from '@/lib/components/ui/button';
    import { Spinner } from '@/lib/components/ui/spinner';
    import type { DefaultPageProps } from '@/lib/types';
    import type { User } from '@/types';
    import * as Dialog from '../../ui/dialog';

    let isLoading = $state(false);

    interface PageProps extends DefaultPageProps {
        users: Array<User>;
    }

    interface Props {
        users: Array<User>;
        user: User;
        activeFilter: 'USER' | 'ADMIN' | 'SUPERADMIN' | 'ALL';
    }

    let {
        users = $bindable(),
        user,
        activeFilter = $bindable(),
    }: Props = $props();

    let open = $state(false);
    function setOpen(mode: 'open' | 'close' | 'switch' = 'switch') {
        if (mode === 'switch') {
            return (open = !open);
        }

        if (mode === 'open') {
            return (open = true);
        }

        open = false;
    }

    function handleDelete() {
        const requestOptions = {
            onStart: () => {
                isLoading = true;
            },
            onFinish: () => {
                isLoading = false;
            },
            onError: (err) => {
                const errMessage = err[0] || 'Something Went Wrong';
                toast.success('Gagal!', {
                    description: errMessage,
                });
            },
            onSuccess: (res) => {
                activeFilter = 'ALL';
                const { users: userlist } = res.props as PageProps;
                users = userlist;
                toast.success('Berhasil!', {
                    description: 'Berhasil menghapus pengguna',
                });
                setOpen('close');
            },
        } satisfies VisitHelperOptions;
        router.delete(`/api/superadmin/delete-user/${user.id}`, requestOptions);
    }
</script>

<Dialog.Root {open} onOpenChange={() => setOpen()}>
    <Button size="lg" onclick={() => setOpen('open')} variant="destructive">
        <Trash />
        <span class="hidden md:inline">Delete</span>
    </Button>
    <Dialog.Content class="w-full md:w-md">
        <Dialog.Header>
            <Dialog.Title>Delete User</Dialog.Title>
            <Dialog.Description
                >Apakah anda yakin ingin Menghapus User: {user.name}? Tindakan
                ini tidak dapat dipulihkan</Dialog.Description
            >
        </Dialog.Header>
        <div class="grid grid-cols-2 gap-2">
            <Button
                variant="outline"
                type="button"
                onclick={() => setOpen('close')}
                size="lg">Batal</Button
            >
            <Button
                onclick={handleDelete}
                type="submit"
                disabled={isLoading}
                size="lg"
            >
                {#if isLoading}
                    <Spinner />
                {:else}
                    Hapus
                {/if}
            </Button>
        </div>
    </Dialog.Content>
</Dialog.Root>
