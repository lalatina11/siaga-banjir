<script lang="ts">
    import { Toaster } from '@/lib/components/ui/sonner';
    import type { ParentProps } from '@/lib/types/parent-props';
    import { ModeWatcher } from 'mode-watcher';
    interface Props extends ParentProps {}
    const { children }: Props = $props();
</script>

<ModeWatcher />
<Toaster position="top-center" />
{@render children()}
