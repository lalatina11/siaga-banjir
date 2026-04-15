<script lang="ts">
    import AppHead from '@/components/AppHead.svelte';
    import MainLayout from '@/layouts/main-layout.svelte';
    import { Button } from '@/lib/components/ui/button';
    import { toast } from 'svelte-sonner';
    const { ...props } = $props();
    $inspect(props);

    function handleBtn() {
        toast.error('Hei');
    }
</script>

<AppHead></AppHead>
<MainLayout>
    <main class="flex flex-col min-h-screen">
        <span>Main</span>
        <Button onclick={handleBtn}>Test</Button>
        <data
            >Lorem ipsum dolor sit, amet consectetur adipisicing elit. Itaque
            illum a velit suscipit fugit facilis sit atque eos, sint ipsa unde
            error tempora, maiores harum architecto nihil ab explicabo minima!</data
        >
    </main>
</MainLayout>
