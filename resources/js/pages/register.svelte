<script lang="ts">
    import AppHead from '@/components/AppHead.svelte';
    import AuthLayout from '@/layouts/auth-layout.svelte';
    import { Button, buttonVariants } from '@/lib/components/ui/button';
    import * as Card from '@/lib/components/ui/card';
    import * as InputGroup from '@/lib/components/ui/input-group';
    import * as Field from '@/lib/components/ui/field';
    import { Input } from '@/lib/components/ui/input';
    import { Link, router } from '@inertiajs/svelte';
    import { type VisitHelperOptions } from '@inertiajs/core';
    import { createForm } from '@tanstack/svelte-form';
    import { toast } from 'svelte-sonner';
    import z from 'zod';
    import { Spinner } from '@/lib/components/ui/spinner';
    import { Eye, EyeOff } from '@lucide/svelte/icons';

    const registerSchema = z
        .object({
            name: z
                .string()
                .min(3, { message: 'Nama minimal 3 karakter' })
                .max(64, { message: 'Nama maksimal 64 karakter' }),
            email: z.email({ message: 'Email tidak valid' }),
            password: z
                .string()
                .min(8, { message: 'Password minimal 8 karakter' })
                .max(32, { message: 'Password maksimal 32 karakter' }),
            password_confirmation: z
                .string()
                .min(8, { message: 'Konfirmasi password minimal 8 karakter' })
                .max(32, {
                    message: 'Konfirmasi password maksimal 32 karakter',
                }),
        })
        .refine((data) => data.password === data.password_confirmation, {
            message: 'Kata sandi tidak cocok',
            path: ['password_confirmation'],
        });
    let isLoading = $state(false);
    let formError = $state('');
    let showPassword = $state(false);
    let showConfirmPassword = $state(false);

    const form = createForm(() => ({
        validators: {
            onSubmit: registerSchema,
        },
        defaultValues: {
            name: '',
            email: '',
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
                    formError = errMessage;
                },
                onSuccess: () => {
                    toast.success('Pendaftaran berhasil', {
                        description: 'Anda akan diarahkan ke Halaman utama',
                    });
                },
            } satisfies VisitHelperOptions;
            router.post('/register', value, requestOptions);
        },
    }));
</script>

<AppHead title="Daftar" />

<AuthLayout>
    <main>
        <section class="w-full flex justify-center items-center">
            <Card.Root class="w-sm mx-auto mt-20">
                <Card.Header>
                    <Card.Title>Daftar</Card.Title>
                    <Card.Description>Daftarkan akun anda</Card.Description>
                </Card.Header>
                <Card.Content>
                    <form
                        onsubmit={(e) => {
                            e.preventDefault();
                            e.stopPropagation();
                            form.handleSubmit();
                        }}
                    >
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
                                        <Field.Label for={field.name}
                                            >Nama</Field.Label
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
                                            aria-invalid={field.state.meta
                                                .isTouched &&
                                                !field.state.meta.isValid}
                                            autocomplete="off"
                                            placeholder="Masukkan Nama"
                                        />
                                        {#if field.state.meta.errors[0]}
                                            <Field.Error
                                                errors={[
                                                    field.state.meta.errors[0],
                                                ]}
                                            />
                                        {/if}
                                    </Field.Set>
                                {/snippet}
                            </form.Field>
                            <form.Field name="email">
                                {#snippet children(field)}
                                    <Field.Set class="gap-1">
                                        <Field.Label for={field.name}
                                            >Email</Field.Label
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
                                            aria-invalid={field.state.meta
                                                .isTouched &&
                                                !field.state.meta.isValid}
                                            autocomplete="off"
                                            placeholder="john@doe.com"
                                        />
                                        {#if field.state.meta.errors[0]}
                                            <Field.Error
                                                errors={[
                                                    field.state.meta.errors[0],
                                                ]}
                                            />
                                        {/if}
                                    </Field.Set>
                                {/snippet}
                            </form.Field>
                            <form.Field name="password">
                                {#snippet children(field)}
                                    <Field.Set class="gap-1">
                                        <Field.Label for={field.name}
                                            >Password</Field.Label
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
                                                onblur={() =>
                                                    field.handleBlur()}
                                                aria-invalid={field.state.meta
                                                    .isTouched &&
                                                    !field.state.meta.isValid}
                                                autocomplete="off"
                                                placeholder="********"
                                                type={showPassword
                                                    ? 'text'
                                                    : 'password'}
                                            />
                                            <InputGroup.Addon
                                                align="inline-end"
                                            >
                                                <InputGroup.Button
                                                    onclick={() =>
                                                        (showPassword =
                                                            !showPassword)}
                                                >
                                                    {#if showPassword}
                                                        <EyeOff />
                                                    {:else}
                                                        <Eye />
                                                    {/if}
                                                </InputGroup.Button>
                                            </InputGroup.Addon>
                                        </InputGroup.Root>

                                        {#if field.state.meta.errors[0]}
                                            <Field.Error
                                                errors={[
                                                    field.state.meta.errors[0],
                                                ]}
                                            />
                                        {/if}
                                    </Field.Set>
                                {/snippet}
                            </form.Field>
                            <form.Field name="password_confirmation">
                                {#snippet children(field)}
                                    <Field.Set class="gap-1">
                                        <Field.Label for={field.name}
                                            >Konfirmasi Password</Field.Label
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
                                                onblur={() =>
                                                    field.handleBlur()}
                                                aria-invalid={field.state.meta
                                                    .isTouched &&
                                                    !field.state.meta.isValid}
                                                autocomplete="off"
                                                placeholder="********"
                                                type={showConfirmPassword
                                                    ? 'text'
                                                    : 'password'}
                                            />
                                            <InputGroup.Addon
                                                align="inline-end"
                                            >
                                                <InputGroup.Button
                                                    onclick={() =>
                                                        (showConfirmPassword =
                                                            !showConfirmPassword)}
                                                >
                                                    {#if showConfirmPassword}
                                                        <EyeOff />
                                                    {:else}
                                                        <Eye />
                                                    {/if}
                                                </InputGroup.Button>
                                            </InputGroup.Addon>
                                        </InputGroup.Root>
                                        {#if field.state.meta.errors[0]}
                                            <Field.Error
                                                errors={[
                                                    field.state.meta.errors[0],
                                                ]}
                                            />
                                        {/if}
                                    </Field.Set>
                                {/snippet}
                            </form.Field>
                            <div class="flex w-full">
                                <Button
                                    type="submit"
                                    disabled={isLoading}
                                    size="lg"
                                    class="w-full"
                                >
                                    {#if isLoading}
                                        <Spinner />
                                    {:else}
                                        Daftar
                                    {/if}
                                </Button>
                            </div>
                        </Field.Group>
                    </form>
                </Card.Content>
                <Card.Footer>
                    <span>Sudah Punya akun?</span>
                    <Link
                        class={buttonVariants({ variant: 'link' })}
                        href="/login">Masuk</Link
                    >
                </Card.Footer>
            </Card.Root>
        </section>
    </main>
</AuthLayout>
