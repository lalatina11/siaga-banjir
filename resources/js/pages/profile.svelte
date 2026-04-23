<script lang="ts">
    import DashboardLayout from '@/layouts/dashboard-layout.svelte';
    import AppHead from '@/lib/components/AppHead.svelte';
    import { Button, buttonVariants } from '@/lib/components/ui/button';
    import * as Card from '@/lib/components/ui/card';
    import * as Field from '@/lib/components/ui/field';
    import { Input } from '@/lib/components/ui/input';
    import { Spinner } from '@/lib/components/ui/spinner';
    import { updateProfileSchema } from '@/lib/validations/auth-validations';
    import { type VisitHelperOptions } from '@inertiajs/core';
    import { Link, router, usePage } from '@inertiajs/svelte';
    import { createForm } from '@tanstack/svelte-form';
    import { toast } from 'svelte-sonner';

    let isLoading = $state(false);
    let formError = $state('');
    let newAvatar = $state<File | null>(null);
    let newAvatarURL = $derived<string>(
        newAvatar !== null ? URL.createObjectURL(newAvatar) : '',
    );

    const { auth } = usePage().props;

    const form = createForm(() => ({
        validators: {
            onSubmit: updateProfileSchema,
            onChange: updateProfileSchema,
        },
        defaultValues: {
            name: auth.user.name || '',
            email: auth.user.email || '',
        },
        onSubmit: async ({ value }) => {
            const requestOptions = {
                onStart: () => {
                    isLoading = true;
                },
                onFinish: () => {
                    isLoading = false;
                },
                onError: (err) => {
                    const errMessage = err[0] || 'Something Went Wrong';
                    toast.error('Gagal', { description: errMessage });
                    formError = errMessage;
                },
                onSuccess: () => {
                    toast.success('Berhasil!', {
                        description: 'Update Profile berhasil!',
                    });
                },
            } satisfies VisitHelperOptions;
            const data = { ...value, avatar: newAvatar };
            router.post('/api/update-profile', data, requestOptions);
        },
    }));
    const formState = form.useStore((state) => state.isSubmitting);
    const handleResetAvatar = () => {
        newAvatar = null;
    };
    let isFormLoading = $derived(formState.current || isLoading);
</script>

<AppHead title="Profile {auth.user.name}" />

<DashboardLayout>
    <main class="flex justify-center min-h-screen mt-10 p-3">
        <Card.Root class="w-full md:w-sm h-fit">
            <Card.Header>
                <Card.Title>Profile</Card.Title>
                <Card.Description>Update Profile</Card.Description>
            </Card.Header>
            <Card.Content>
                <Field.Group>
                    {#if formError}
                        <Field.Error
                            class="text-center"
                            errors={[{ message: formError }]}
                        />
                    {/if}
                    <form.Field name="name">
                        {#snippet children(field)}
                            <Field.Set class="gap-1">
                                <Field.Label for={field.name}>Nama</Field.Label>
                                <Input
                                    oninput={(e) => {
                                        const { value } =
                                            e.target as HTMLInputElement;
                                        field.setValue(value);
                                    }}
                                    id={field.name}
                                    name={field.name}
                                    value={field.state.value}
                                    onblur={() => field.handleBlur()}
                                    aria-invalid={field.state.meta.isTouched &&
                                        !field.state.meta.isValid}
                                    autocomplete="off"
                                    placeholder="Masukkan Nama"
                                />
                                {#if field.state.meta.errors[0]}
                                    <Field.Error
                                        errors={[field.state.meta.errors[0]]}
                                    />
                                {/if}
                            </Field.Set>
                        {/snippet}
                    </form.Field>
                    <form.Field name="email">
                        {#snippet children(field)}
                            <Field.Set class="gap-1">
                                <Field.Label for={field.name}>Email</Field.Label
                                >
                                <Input
                                    oninput={(e) => {
                                        const { value } =
                                            e.target as HTMLInputElement;
                                        field.setValue(value);
                                    }}
                                    id={field.name}
                                    name={field.name}
                                    value={field.state.value}
                                    onblur={() => field.handleBlur()}
                                    aria-invalid={field.state.meta.isTouched &&
                                        !field.state.meta.isValid}
                                    autocomplete="off"
                                    placeholder="john@doe.com"
                                />
                                {#if field.state.meta.errors[0]}
                                    <Field.Error
                                        errors={[field.state.meta.errors[0]]}
                                    />
                                {/if}
                            </Field.Set>
                        {/snippet}
                    </form.Field>
                    {#if newAvatarURL}
                        <img
                            src={newAvatarURL}
                            class="w-1/2 mx-auto object-cover aspect-square rounded-full"
                            alt="..."
                        />
                    {:else}
                        <img
                            src={auth.user.avatar}
                            class="w-1/2 mx-auto object-cover aspect-square rounded-full"
                            alt="..."
                        />
                    {/if}
                    {#if newAvatarURL}
                        <div class="grid grid-cols-2 gap-2">
                            <label
                                class={buttonVariants({
                                    variant: 'default',
                                    size: 'lg',
                                })}
                                for="avatar">Ganti avatar</label
                            >
                            <Button
                                onclick={handleResetAvatar}
                                size="lg"
                                variant="outline">Batal</Button
                            >
                        </div>
                    {:else}
                        <label
                            class={`mx-auto ${buttonVariants({ variant: 'default', size: 'lg' })}`}
                            for="avatar">Ganti avatar</label
                        >
                    {/if}
                    <input
                        type="file"
                        id="avatar"
                        hidden
                        onchange={(e) => {
                            const { files } = e.target as HTMLInputElement;
                            if (files && files?.[0]) {
                                if (formError) {
                                    formError = '';
                                }
                                newAvatar = files[0];
                            }
                        }}
                    />
                </Field.Group>
            </Card.Content>
            <Card.Footer class="flex flex-col gap-2">
                <Button
                    class="w-full"
                    size="lg"
                    disabled={isFormLoading}
                    onclick={() => form.handleSubmit()}
                >
                    {#if isFormLoading}
                        <Spinner />
                    {:else}
                        Submit
                    {/if}
                </Button>
                <span
                    >Untuk update password bisa <Link
                        href="/dashboard/profile/update-password"
                        class={buttonVariants({ variant: 'link' })}
                        >klik disini</Link
                    ></span
                >
            </Card.Footer>
        </Card.Root>
    </main>
</DashboardLayout>
