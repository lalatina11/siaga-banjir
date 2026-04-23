<script lang="ts">
    import MainLayout from '@/layouts/main-layout.svelte';
    import BackButton from '@/lib/components/back-button.svelte';
    import NewFloodForm from '@/lib/components/form/flood-form/new-flood-form.svelte';
</script>

<MainLayout>
    <main class="p-4 mt-5 md:mt-10 flex flex-col gap-3">
        <BackButton />
        <NewFloodForm />
    </main>
</MainLayout>
