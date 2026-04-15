<script lang="ts">
    import AppHead from '@/components/AppHead.svelte';
    import AuthLayout from '@/layouts/auth-layout.svelte';
    import { Button, buttonVariants } from '@/lib/components/ui/button';
    import * as Card from '@/lib/components/ui/card';
    import * as Field from '@/lib/components/ui/field';
    import { Input } from '@/lib/components/ui/input';
    import { Link } from '@inertiajs/svelte';
    import { createForm } from '@tanstack/svelte-form';
    import z from 'zod';
    const loginSchema = z.object({
        nik: z.string().length(16),
    });
    const form = createForm(() => ({
        validators: {
            onSubmit: loginSchema,
        },
        defaultValues: {
            nik: '',
        },
    }));
</script>

<AppHead title="Masuk" />

<AuthLayout>
    <main>
        <section class="w-full flex justify-center items-center">
            <Card.Root class="w-sm mx-auto mt-20">
                <Card.Header>
                    <Card.Title>Login</Card.Title>
                    <Card.Description>Masuk ke akun anda</Card.Description>
                </Card.Header>
                <Card.Content>
                    <form>
                        <form.Field name="nik">
                            {#snippet children(props)}
                                <Field.Set>
                                    <Input autocomplete="off" />
                                </Field.Set>
                            {/snippet}
                        </form.Field>
                        <Card.Action class="flex w-full">
                            <Button size="lg" class="w-full">Masuk</Button>
                        </Card.Action>
                    </form>
                </Card.Content>
                <Card.Footer>
                    <span>Belum punya akun?</span>
                    <Link
                        class={buttonVariants({ variant: 'link' })}
                        href="/register">Register</Link
                    >
                </Card.Footer>
            </Card.Root>
        </section>
    </main>
</AuthLayout>
