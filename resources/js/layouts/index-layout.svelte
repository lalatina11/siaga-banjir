<script lang="ts">
    import QueryClientProvider from '@/lib/components/providers/query-client-provider.svelte';
    import { Toaster } from '@/lib/components/ui/sonner';
    import type { ParentProps } from '@/lib/types/parent-props';
    import { ModeWatcher } from 'mode-watcher';
    interface Props extends ParentProps {}
    const { children }: Props = $props();
</script>

<ModeWatcher />
<Toaster position="top-center" />
<QueryClientProvider>
    {@render children()}
</QueryClientProvider>
