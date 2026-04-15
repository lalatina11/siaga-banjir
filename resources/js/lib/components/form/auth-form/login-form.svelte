<script lang="ts">
    import { Button } from '@/lib/components/ui/button';
    import * as Field from '@/lib/components/ui/field';
    import { Input } from '@/lib/components/ui/input';
    import * as InputGroup from '@/lib/components/ui/input-group';
    import { Spinner } from '@/lib/components/ui/spinner';
    import { loginSchema } from '@/lib/validations/auth-validations';
    import { type VisitHelperOptions } from '@inertiajs/core';
    import { router } from '@inertiajs/svelte';
    import { Eye, EyeOff } from '@lucide/svelte/icons';
    import { createForm } from '@tanstack/svelte-form';
    import { toast } from 'svelte-sonner';

    let isLoading = $state(false);
    let formError = $state('');
    let showPassword = $state(false);

    const form = createForm(() => ({
        validators: {
            onSubmit: loginSchema,
            onChange: loginSchema,
        },
        defaultValues: {
            email: '',
            password: '',
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
                    toast.success('Login berhasil!', {
                        description: 'Anda akan diarahkan ke Halaman utama',
                    });
                },
            } satisfies VisitHelperOptions;
            router.post('/login', value, requestOptions);
        },
    }));
</script>

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
        <form.Field name="email">
            {#snippet children(field)}
                <Field.Set class="gap-1">
                    <Field.Label for={field.name}>Email</Field.Label>
                    <Input
                        oninput={(e) => {
                            const { value } = e.target as HTMLInputElement;
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
                        <Field.Error errors={[field.state.meta.errors[0]]} />
                    {/if}
                </Field.Set>
            {/snippet}
        </form.Field>
        <form.Field name="password">
            {#snippet children(field)}
                <Field.Set class="gap-1">
                    <Field.Label for={field.name}>Password</Field.Label>
                    <InputGroup.Root>
                        <InputGroup.Input
                            oninput={(e) => {
                                const { value } = e.target as HTMLInputElement;
                                field.setValue(value);
                            }}
                            id={field.name}
                            name={field.name}
                            value={field.state.value}
                            onblur={() => field.handleBlur()}
                            aria-invalid={field.state.meta.isTouched &&
                                !field.state.meta.isValid}
                            autocomplete="off"
                            placeholder="********"
                            type={showPassword ? 'text' : 'password'}
                        />
                        <InputGroup.Addon align="inline-end">
                            <InputGroup.Button
                                onclick={() => (showPassword = !showPassword)}
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
                        <Field.Error errors={[field.state.meta.errors[0]]} />
                    {/if}
                </Field.Set>
            {/snippet}
        </form.Field>
        <div class="flex w-full">
            <Button type="submit" disabled={isLoading} size="lg" class="w-full">
                {#if isLoading}
                    <Spinner />
                {:else}
                    Masuk
                {/if}
            </Button>
        </div>
    </Field.Group>
</form>
