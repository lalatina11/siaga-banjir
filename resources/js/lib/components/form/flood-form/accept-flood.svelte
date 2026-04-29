<script lang="ts">
    import type { VisitHelperOptions } from '@inertiajs/core';
    import { router } from '@inertiajs/svelte';
    import { toast } from 'svelte-sonner';
    import * as Dialog from '$lib/components/ui/dialog/index.js';
    import type { Flood } from '@/lib/types';
    import { Button } from '../../ui/button';
    import { Spinner } from '../../ui/spinner';
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

    function handleAccept() {
        const requestOptions = {
            onStart: () => {
                isLoading = true;
            },
            onFinish: () => {
                isLoading = false;
            },
            onSuccess: () => {
                toast.success('Berhasil', {
                    description:
                        'Sekarang semua orang bisa melihat laporan ini',
                });
                setOpen('close');
                const pathname = window.location.pathname;

                if (
                    pathname.endsWith('admin') ||
                    pathname.endsWith('superadmin')
                ) {
                    window.location.reload();
                }
            },
            onError: (error) => {
                const description = error[0] || 'Coba lagi beberapa saat';
                toast.error('Terjadi Kesalahan!', { description });
            },
        } satisfies VisitHelperOptions;
        router.post(`/api/flood/accept/${floodId}`, undefined, requestOptions);
    }
</script>

<Dialog.Root {open} onOpenChange={() => setOpen()}>
    <Button onclick={() => setOpen('open')} size="lg">Setujui</Button>
    <Dialog.Content class="w-sm z-50">
        <Dialog.Header>
            <Dialog.Title>Setujui</Dialog.Title>
            <Dialog.Description>
                Dengan menyetujui laporan banjir ini, maka laporan banjir ini
                akan di terpublikasikan dan bisa dilihat semua orang.
            </Dialog.Description>
        </Dialog.Header>
        <Dialog.Footer>
            <Button variant="outline" size="lg" onclick={() => setOpen('close')}
                >Batal</Button
            >
            <Button
                disabled={isLoading}
                onclick={handleAccept}
                variant="default"
                size="lg"
            >
                {#if isLoading}
                    <Spinner />
                {:else}
                    Setujui
                {/if}</Button
            >
        </Dialog.Footer>
    </Dialog.Content>
</Dialog.Root>
