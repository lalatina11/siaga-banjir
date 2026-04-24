<script lang="ts">
    import { User } from '@lucide/svelte';
    import * as Avatar from '../ui/avatar';
    import { usePage } from '@inertiajs/svelte';
    interface Props {
        src?: string;
    }
    const { auth } = usePage().props;
    const { src = auth.user.avatar }: Props = $props();
</script>

<Avatar.Root>
    <Avatar.Image {src} />
    <Avatar.Fallback>
        <User />
    </Avatar.Fallback>
</Avatar.Root>
