<script lang="ts">
    import AppHead from '@/components/AppHead.svelte';
    import AuthLayout from '@/layouts/auth-layout.svelte';
    import LoginForm from '@/lib/components/form/auth-form/login-form.svelte';
    import RegisterForm from '@/lib/components/form/auth-form/register-form.svelte';
    import { Button } from '@/lib/components/ui/button';
    import * as Card from '@/lib/components/ui/card';
    let isLoginPage = $state(true);

    function switchAuthParam() {
        isLoginPage = !isLoginPage;
    }
</script>

{#if !isLoginPage}
    <AppHead title="Daftar" />
{:else}
    <AppHead title="Masuk" />
{/if}

<AuthLayout>
    <main>
        <section class="w-full flex justify-center items-center">
            <Card.Root class="w-sm mx-auto mt-20">
                <Card.Header>
                    {#if isLoginPage}
                        <Card.Title>Masuk</Card.Title>
                        <Card.Description>Masuk ke akun anda</Card.Description>
                    {:else}
                        <Card.Title>Daftar</Card.Title>
                        <Card.Description>Daftarkan akun anda</Card.Description>
                    {/if}
                </Card.Header>
                <Card.Content>
                    {#if isLoginPage}
                        <LoginForm />
                    {:else}
                        <RegisterForm />
                    {/if}
                </Card.Content>
                <Card.Footer>
                    {#if isLoginPage}
                        <span>Belum Punya akun?</span>
                        <Button onclick={switchAuthParam} variant="link"
                            >Daftar</Button
                        >
                    {:else}
                        <span>Sudah Punya akun?</span>
                        <Button onclick={switchAuthParam} variant="link"
                            >Masuk</Button
                        >
                    {/if}
                </Card.Footer>
            </Card.Root>
        </section>
    </main>
</AuthLayout>
