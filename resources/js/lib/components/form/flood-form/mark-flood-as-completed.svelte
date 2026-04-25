<script lang="ts">
    import * as Dialog from '$lib/components/ui/dialog/index.js';
    import type { FloodAid } from '@/lib/types';
    import { type VisitHelperOptions } from '@inertiajs/core';
    import { router } from '@inertiajs/svelte';
    import { toast } from 'svelte-sonner';
    import { Button } from '../../ui/button';
    import { Spinner } from '../../ui/spinner';
    interface Props {
        floodAidId: FloodAid['id'];
    }

    const { floodAidId }: Props = $props();
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

    function handleMarkAsArrived() {
        const requestOptions = {
            onStart: () => {
                isLoading = true;
            },
            onFinish: () => {
                isLoading = false;
            },
            onSuccess: () => {
                toast.success('Berhasil', {
                    description: 'Status bantuan banjir diperbaharui',
                });
                setOpen('close');
            },
            onError: (error) => {
                const description = error[0] || 'Coba lagi beberapa saat';
                toast.error('Terjadi Kesalahan!', { description });
            },
        } satisfies VisitHelperOptions;
        router.patch(
            `/api/flood/mark-as-resolved/${floodAidId}`,
            undefined,
            requestOptions,
        );
    }
</script>

<Dialog.Root {open} onOpenChange={() => setOpen()}>
    <Button onclick={() => setOpen('open')} size="lg"
        >Tandai Bencana Selesai</Button
    >
    <Dialog.Content class="w-sm z-50">
        <Dialog.Header>
            <Dialog.Title>Tandai Bencana telah selesai</Dialog.Title>
            <Dialog.Description>
                Pastikan bencana banjir telah diselesaikan, dan semua
                operasional warga telah pulih dan berlangsung kembali.
            </Dialog.Description>
        </Dialog.Header>
        <Dialog.Footer>
            <Button variant="outline" size="lg" onclick={() => setOpen('close')}
                >Batal</Button
            >
            <Button
                disabled={isLoading}
                onclick={handleMarkAsArrived}
                variant="default"
                size="lg"
            >
                {#if isLoading}
                    <Spinner />
                {:else}
                    Submit
                {/if}
            </Button>
        </Dialog.Footer>
    </Dialog.Content>
</Dialog.Root>
