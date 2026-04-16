<script lang="ts">
    import { Button, type ButtonSize } from '$lib/components/ui/button';
    import { Spinner } from '$lib/components/ui/spinner';
    import { cn } from '@/lib/utils';
    import { LogOut } from '@lucide/svelte';
    import { router, type VisitHelperOptions } from '@inertiajs/core';
    import { toast } from 'svelte-sonner';

    let isLoading = $state(false);
    interface Props {
        className?: string;
        size?: ButtonSize;
    }
    const { className, size }: Props = $props();

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

<Button
    onclick={handleLogOut}
    size={size || 'lg'}
    class={cn(className && className)}
>
    {#if isLoading}
        <Spinner />
    {:else}
        <LogOut />Logout
    {/if}
</Button>
