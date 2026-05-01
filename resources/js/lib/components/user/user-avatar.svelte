<script lang="ts">
    import { usePage } from '@inertiajs/svelte';
    import { User } from '@lucide/svelte';
    import * as Avatar from '../ui/avatar';
    interface Props {
        src?: string;
        class?: string;
    }
    const { auth } = usePage().props;
    const { src = auth?.user?.avatar || '', ...props }: Props = $props();
</script>

<Avatar.Root class={props.class ?? ''}>
    <Avatar.Image {src} />
    <Avatar.Fallback>
        <User />
    </Avatar.Fallback>
</Avatar.Root>
