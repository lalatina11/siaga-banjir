<script lang="ts">
    import { show } from '@/actions/App/Http/Controllers/FloodController';
    import MainLayout from '@/layouts/main-layout.svelte';
    import AppHead from '@/lib/components/AppHead.svelte';
    import { Button } from '@/lib/components/ui/button';
    import * as Card from '@/lib/components/ui/card';
    import * as Field from '@/lib/components/ui/field';
    import * as InputGroup from '@/lib/components/ui/input-group';
    import { Spinner } from '@/lib/components/ui/spinner';
    import { updatePasswordSchema } from '@/lib/validations/auth-validations';
    import { type VisitHelperOptions } from '@inertiajs/core';
    import { router, usePage } from '@inertiajs/svelte';
    import { Eye, EyeClosed } from '@lucide/svelte';
    import { createForm } from '@tanstack/svelte-form';
    import { toast } from 'svelte-sonner';

    let isLoading = $state(false);
    let formError = $state('');

    type PasswordKeys =
        | 'current_password'
        | 'password'
        | 'password_confirmation';

    let showPasswords = $state<Record<PasswordKeys, boolean>>({
        current_password: false,
        password: false,
        password_confirmation: false,
    });

    const handleSwitchShowPassword = (key: PasswordKeys) => {
        showPasswords = { ...showPasswords, [key]: !showPasswords[key] };
    };

    const { auth } = usePage().props;

    const form = createForm(() => ({
        validators: {
            onSubmit: updatePasswordSchema,
            onChange: updatePasswordSchema,
        },
        defaultValues: {
            current_password: '',
            password: '',
            password_confirmation: '',
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
            router.post('/api/update-password', value, requestOptions);
        },
    }));
    const formState = form.useStore((state) => state.isSubmitting);

    let isFormLoading = $derived(formState.current || isLoading);
</script>

<AppHead title="Ganti Password {auth.user.name}" />

<MainLayout>
    <main class="flex justify-center min-h-screen mt-10 p-3">
        <Card.Root class="w-full md:w-sm h-fit">
            <Card.Header>
                <Card.Title>Password</Card.Title>
                <Card.Description>Update Password</Card.Description>
            </Card.Header>
            <Card.Content>
                <Field.Group>
                    {#if formError}
                        <Field.Error
                            class="text-center"
                            errors={[{ message: formError }]}
                        />
                    {/if}
                    <form.Field name="current_password">
                        {#snippet children(field)}
                            <Field.Set class="gap-1">
                                <Field.Label for={field.name}
                                    >Password Lama</Field.Label
                                >
                                <InputGroup.Root>
                                    <InputGroup.Input
                                        oninput={(e) => {
                                            const { value } =
                                                e.target as HTMLInputElement;
                                            field.setValue(value);
                                        }}
                                        id={field.name}
                                        name={field.name}
                                        value={field.state.value}
                                        onblur={() => field.handleBlur()}
                                        aria-invalid={field.state.meta
                                            .isTouched &&
                                            !field.state.meta.isValid}
                                        autocomplete="off"
                                        placeholder="Masukkan Nama"
                                        type={showPasswords.current_password
                                            ? 'text'
                                            : 'password'}
                                    />
                                    <InputGroup.Addon
                                        onclick={() =>
                                            handleSwitchShowPassword(
                                                field.name,
                                            )}
                                        align="inline-end"
                                        class="cursor-pointer"
                                    >
                                        {#if showPasswords.current_password}
                                            <EyeClosed />
                                        {:else}
                                            <Eye />
                                        {/if}
                                    </InputGroup.Addon>
                                </InputGroup.Root>
                                {#if field.state.meta.errors[0]}
                                    <Field.Error
                                        errors={[field.state.meta.errors[0]]}
                                    />
                                {/if}
                            </Field.Set>
                        {/snippet}
                    </form.Field>
                    <form.Field name="password">
                        {#snippet children(field)}
                            <Field.Set class="gap-1">
                                <Field.Label for={field.name}
                                    >Password Baru</Field.Label
                                >
                                <InputGroup.Root>
                                    <InputGroup.Input
                                        oninput={(e) => {
                                            const { value } =
                                                e.target as HTMLInputElement;
                                            field.setValue(value);
                                        }}
                                        id={field.name}
                                        name={field.name}
                                        value={field.state.value}
                                        onblur={() => field.handleBlur()}
                                        aria-invalid={field.state.meta
                                            .isTouched &&
                                            !field.state.meta.isValid}
                                        autocomplete="off"
                                        placeholder="john@doe.com"
                                        type={showPasswords.password
                                            ? 'text'
                                            : 'password'}
                                    />
                                    <InputGroup.Addon
                                        onclick={() =>
                                            handleSwitchShowPassword(
                                                field.name,
                                            )}
                                        align="inline-end"
                                        class="cursor-pointer"
                                    >
                                        {#if showPasswords.password}
                                            <EyeClosed />
                                        {:else}
                                            <Eye />
                                        {/if}
                                    </InputGroup.Addon>
                                </InputGroup.Root>
                                {#if field.state.meta.errors[0]}
                                    <Field.Error
                                        errors={[field.state.meta.errors[0]]}
                                    />
                                {/if}
                            </Field.Set>
                        {/snippet}
                    </form.Field>
                    <form.Field name="password_confirmation">
                        {#snippet children(field)}
                            <Field.Set class="gap-1">
                                <Field.Label for={field.name}
                                    >Konfirmasi Password Baru</Field.Label
                                >
                                <InputGroup.Root>
                                    <InputGroup.Input
                                        oninput={(e) => {
                                            const { value } =
                                                e.target as HTMLInputElement;
                                            field.setValue(value);
                                        }}
                                        id={field.name}
                                        name={field.name}
                                        value={field.state.value}
                                        onblur={() => field.handleBlur()}
                                        aria-invalid={field.state.meta
                                            .isTouched &&
                                            !field.state.meta.isValid}
                                        autocomplete="off"
                                        placeholder="john@doe.com"
                                        type={showPasswords.password_confirmation
                                            ? 'text'
                                            : 'password'}
                                    />
                                    <InputGroup.Addon
                                        onclick={() =>
                                            handleSwitchShowPassword(
                                                field.name,
                                            )}
                                        align="inline-end"
                                        class="cursor-pointer"
                                    >
                                        {#if showPasswords.password_confirmation}
                                            <EyeClosed />
                                        {:else}
                                            <Eye />
                                        {/if}
                                    </InputGroup.Addon>
                                </InputGroup.Root>
                                {#if field.state.meta.errors[0]}
                                    <Field.Error
                                        errors={[field.state.meta.errors[0]]}
                                    />
                                {/if}
                            </Field.Set>
                        {/snippet}
                    </form.Field>
                </Field.Group>
            </Card.Content>
            <Card.Footer>
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
            </Card.Footer>
        </Card.Root>
    </main>
</MainLayout>
