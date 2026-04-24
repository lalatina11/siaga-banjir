<script lang="ts">
    import { Button } from '@/lib/components/ui/button';
    import * as Field from '@/lib/components/ui/field';
    import { Input } from '@/lib/components/ui/input';
    import * as InputGroup from '@/lib/components/ui/input-group';
    import { Spinner } from '@/lib/components/ui/spinner';
    import { capitalizeFirstLetter } from '@/lib/helpers';
    import type { DefaultPageProps } from '@/lib/types';
    import {
        allowedUserRole,
        editUserSchema,
    } from '@/lib/validations/auth-validations';
    import type { User } from '@/types';
    import { type VisitHelperOptions } from '@inertiajs/core';
    import { router } from '@inertiajs/svelte';
    import { Eye, EyeOff, Pencil } from '@lucide/svelte/icons';
    import { createForm } from '@tanstack/svelte-form';
    import { toast } from 'svelte-sonner';
    import z from 'zod';
    import * as ButtonGroup from '../../ui/button-group';
    import * as Dialog from '../../ui/dialog';
    import { ScrollArea } from '../../ui/scroll-area';

    let isLoading = $state(false);
    let formError = $state('');
    let showPassword = $state(false);

    interface PageProps extends DefaultPageProps {
        users: Array<User>;
    }

    interface Props {
        users: Array<User>;
        user: User;
        activeFilter: 'USER' | 'ADMIN' | 'SUPERADMIN' | 'ALL';
    }

    let {
        users = $bindable(),
        user,
        activeFilter = $bindable(),
    }: Props = $props();

    const currentEditUserSchema = editUserSchema.extend({
        role: z.enum(allowedUserRole),
    });

    const form = createForm(() => ({
        validators: {
            onSubmit: currentEditUserSchema,
            onChange: currentEditUserSchema,
        },
        defaultValues: {
            name: user.name,
            email: user.email,
            password: '',
            role: user.role,
        },
        onSubmit: async ({ value }) => {
            if (value.password.length > 0) {
                if (value.password.length < 8) {
                    return (formError = 'Password minimal 8 karakter');
                }
                if (value.password.length > 32) {
                    return (formError = 'Password maksimal 32 karakter');
                }
            }
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
                onSuccess: (res) => {
                    activeFilter = 'ALL';
                    const { users: userlist } = res.props as PageProps;
                    users = userlist;
                    toast.success('Berhasil!', {
                        description: 'Berhasil mengedit pengguna',
                    });
                    setOpen('close');
                    if (formError) {
                        formError = '';
                    }
                },
            } satisfies VisitHelperOptions;
            router.patch(
                `/api/superadmin/edit-user/${user.id}`,
                value,
                requestOptions,
            );
        },
    }));

    const formState = form.useStore((state) => state.isSubmitting);
    let isFormLoading = $derived(formState.current || isLoading);
    let open = $state(false);
    function setOpen(mode: 'open' | 'close' | 'switch' = 'switch') {
        if (mode === 'switch') {
            return (open = !open);
        }
        if (mode === 'open') {
            return (open = true);
        }
        open = false;
    }
</script>

<Dialog.Root {open} onOpenChange={() => setOpen()}>
    <Button
        onclick={() => setOpen('open')}
        class="w-fit"
        size="lg"
        variant="outline"
        ><Pencil />
        <span class="hidden md:inline">Edit</span></Button
    >
    <Dialog.Content class="w-full md:w-md">
        <Dialog.Header>
            <Dialog.Title>Edit User</Dialog.Title>
            <Dialog.Description>Edit User: {user.name}</Dialog.Description>
        </Dialog.Header>
        <ScrollArea class="h-[300px] md:h-[400px] pr-3 py-3">
            <form
                class="flex w-full px-3"
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
                                        onblur={() => field.handleBlur()}
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
                                        class="cursor-pointer"
                                        onclick={() =>
                                            (showPassword = !showPassword)}
                                    >
                                        {#if showPassword}
                                            <EyeOff />
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
                    <form.Field name="role">
                        {#snippet children(field)}
                            <Field.Set class="gap-1">
                                <Field.Label for={field.name}>Role</Field.Label>
                                <ButtonGroup.Root>
                                    {#each allowedUserRole as role (role)}
                                        <Button
                                            size="lg"
                                            variant={field.state.value === role
                                                ? 'default'
                                                : 'outline'}
                                            type="button"
                                            onclick={() => field.setValue(role)}
                                            >{capitalizeFirstLetter(
                                                role,
                                            )}</Button
                                        >
                                    {/each}
                                </ButtonGroup.Root>
                                {#if field.state.meta.errors[0]}
                                    <Field.Error
                                        errors={[field.state.meta.errors[0]]}
                                    />
                                {/if}
                            </Field.Set>
                        {/snippet}
                    </form.Field>
                    <div class="grid grid-cols-2 gap-2">
                        <Button
                            variant="outline"
                            type="button"
                            onclick={() => setOpen('close')}
                            size="lg">Batal</Button
                        >
                        <Button
                            type="submit"
                            disabled={isFormLoading}
                            size="lg"
                        >
                            {#if isFormLoading}
                                <Spinner />
                            {:else}
                                Edit User
                            {/if}
                        </Button>
                    </div>
                </Field.Group>
            </form>
        </ScrollArea>
    </Dialog.Content>
</Dialog.Root>
