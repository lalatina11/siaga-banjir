<script lang="ts">
    import { ArrowLeft } from '@lucide/svelte';
    import { type HTMLButtonAttributes } from 'svelte/elements';
    import { cn } from '../utils';
    import { Button, type ButtonVariant, type ButtonSize } from './ui/button';
    interface Props {
        class?: HTMLButtonAttributes['class'];
        size?: ButtonSize;
        variant?: ButtonVariant;
    }
    let { size = 'lg', variant = 'default', ...props }: Props = $props();
</script>

<Button
    class={cn('w-fit mr-auto', props.class && props.class)}
    {size}
    {variant}
    onclick={() => window.history.back()}><ArrowLeft />Back</Button
>
