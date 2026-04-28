<script lang="ts">
    import { usePage } from '@inertiajs/svelte';
    import { User } from '@lucide/svelte';
    import * as Avatar from '../ui/avatar';
    interface Props {
        src?: string;
    }
    const { auth } = usePage().props;
    const { src = auth?.user?.avatar || '' }: Props = $props();
</script>

<Avatar.Root>
    <Avatar.Image {src} />
    <Avatar.Fallback>
        <User />
    </Avatar.Fallback>
</Avatar.Root>
