<script lang="ts">
    import DashboardLayout from '@/layouts/dashboard-layout.svelte';
    import { Button, buttonVariants } from '@/lib/components/ui/button';
    import * as ButtonGroup from '@/lib/components/ui/button-group';
    import * as Card from '@/lib/components/ui/card';
    import { Link } from '@inertiajs/svelte';
    import { setMode, mode } from 'mode-watcher';
    const themeOptions = ['system', 'light', 'dark'] as const;
</script>

<DashboardLayout>
    <Card.Root class="w-sm mx-auto">
        <Card.Header>
            <Card.Title>Ganti tema</Card.Title>
        </Card.Header>
        <Card.Content class="flex flex-col gap-2 justify-center items-center">
            <ButtonGroup.Root>
                {#each themeOptions as opt (opt)}
                    <Button
                        variant={opt === mode.current ? 'default' : 'outline'}
                        onclick={() => setMode(opt)}
                        class="capitalize">{opt}</Button
                    >
                {/each}
            </ButtonGroup.Root>
        </Card.Content>
        <Card.Footer>
            <span
                >Untuk Update Profile bisa <Link
                    class={buttonVariants({ variant: 'link' })}
                    href="/dashboard/profile">klik disini</Link
                ></span
            >
        </Card.Footer>
    </Card.Root>
</DashboardLayout>
