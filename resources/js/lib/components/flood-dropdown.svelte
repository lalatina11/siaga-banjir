<script lang="ts">
    import { Link } from '@inertiajs/svelte';
    import { buttonVariants } from './ui/button';
    import * as DropdownMenu from './ui/dropdown-menu';
</script>

<DropdownMenu.Root>
    <DropdownMenu.Trigger
        class={buttonVariants({ variant: 'outline', size: 'icon' })}
    >
        +
    </DropdownMenu.Trigger>
    <DropdownMenu.Content>
        <DropdownMenu.Item>
            <Link href="/new-flood">Laporkan Banjir</Link>
        </DropdownMenu.Item>
    </DropdownMenu.Content>
</DropdownMenu.Root>
