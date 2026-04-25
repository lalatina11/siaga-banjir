<script lang="ts">
    import * as Dialog from '$lib/components/ui/dialog/index.js';
    import type { Flood } from '@/lib/types';
    import { type VisitHelperOptions } from '@inertiajs/core';
    import { router } from '@inertiajs/svelte';
    import { toast } from 'svelte-sonner';
    import { Button } from '../../ui/button';
    import { Spinner } from '../../ui/spinner';
    import { Trash } from '@lucide/svelte';
    interface Props {
        floodId: Flood['id'];
    }

    const { floodId }: Props = $props();
    let open = $state(false);
    const setOpen = (mode: 'open' | 'close' | 'switch' = 'switch') => {
        if (mode === 'switch') {
            return (open = !open);
        }
        if (mode === 'open') {
            return (open = true);
        }
        open = false;
    };

    let isLoading = $state(false);

    function handleDeleteFlood() {
        const requestOptions = {
            onStart: () => {
                isLoading = true;
            },
            onFinish: () => {
                isLoading = false;
            },
            onSuccess: () => {
                toast.success('Berhasil', {
                    description: 'Berhasil menghapus laporan banjir',
                });
                setOpen('close');
            },
            onError: (error) => {
                const description = error[0] || 'Coba lagi beberapa saat';
                toast.error('Terjadi Kesalahan!', { description });
            },
        } satisfies VisitHelperOptions;
        router.delete(`/api/flood/delete/${floodId}`, requestOptions);
    }
</script>

<Dialog.Root {open} onOpenChange={() => setOpen()}>
    <Button onclick={() => setOpen('open')} size="lg" variant="destructive"
        ><Trash /> Delete</Button
    >
    <Dialog.Content class="w-sm z-50">
        <Dialog.Header>
            <Dialog.Title>Apakah anda yakin?</Dialog.Title>
            <Dialog.Description>
                Tindakan ini tidak bisa dipulihkan
            </Dialog.Description>
        </Dialog.Header>
        <Dialog.Footer>
            <Button variant="outline" size="lg" onclick={() => setOpen('close')}
                >Batal</Button
            >
            <Button
                disabled={isLoading}
                onclick={handleDeleteFlood}
                variant="default"
                size="lg"
            >
                {#if isLoading}
                    <Spinner />
                {:else}
                    Hapus
                {/if}
            </Button>
        </Dialog.Footer>
    </Dialog.Content>
</Dialog.Root>
