<script lang="ts">
    import { type ParentProps } from '$lib/types/parent-props';
    import IndexLayout from './index-layout.svelte';
    interface Props extends ParentProps {}

    const { children }: Props = $props();
</script>

<IndexLayout>
    {@render children()}
</IndexLayout>
