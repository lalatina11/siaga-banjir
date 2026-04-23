<script lang="ts">
    import { queryClient } from '@/lib/query-client';
    import { QueryClientProvider as TanstackQueryClientProvider } from '@tanstack/svelte-query';
    import type { Snippet } from 'svelte';
    interface Props {
        children: Snippet<[]>;
    }
    const { children }: Props = $props();
</script>

<TanstackQueryClientProvider client={queryClient}>
    {@render children()}
</TanstackQueryClientProvider>
