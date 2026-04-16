<script lang="ts">
    import AppHead from '@/components/AppHead.svelte';
    import AuthLayout from '@/layouts/auth-layout.svelte';
    import LoginForm from '@/lib/components/form/auth-form/login-form.svelte';
    import RegisterForm from '@/lib/components/form/auth-form/register-form.svelte';
    import ModeToggle from '@/lib/components/mode-toggle.svelte';
    import { Button } from '@/lib/components/ui/button';
    import * as Card from '@/lib/components/ui/card';
    import { router } from '@inertiajs/svelte';

    const searchParams = $derived(new URLSearchParams(window.location.search));
    const isLoginPage = $derived(searchParams.get('tab') !== 'register');
    function switchAuthParam() {
        const params = new URLSearchParams(window.location.search);
        if (isLoginPage) {
            params.set('tab', 'register');
        } else {
            params.set('tab', 'login');
        }
        router.push({
            url: `${window.location.pathname}?${params.toString()}`,
        });
    }
</script>

<AppHead title={!isLoginPage ? 'Daftar' : 'Masuk'} />

<AuthLayout>
    <main>
        <section class="w-full flex justify-center items-center">
            <Card.Root class="w-sm mx-auto mt-20">
                <Card.Header
                    class="flex flex-row justify-between items-center w-full"
                >
                    <Card.Header class="flex-1">
                        <Card.Title
                            >{isLoginPage ? 'Masuk' : 'Daftar'}</Card.Title
                        >
                        <Card.Description
                            >{isLoginPage
                                ? 'Masuk ke akun anda'
                                : 'Daftarkan akun anda'}</Card.Description
                        >
                    </Card.Header>
                    <ModeToggle />
                </Card.Header>
                <Card.Content>
                    {#if isLoginPage}
                        <LoginForm />
                    {:else}
                        <RegisterForm />
                    {/if}
                </Card.Content>
                <Card.Footer>
                    <span
                        >{isLoginPage
                            ? 'Belum Punya akun?'
                            : 'Sudah Punya akun?'}</span
                    >
                    <Button onclick={switchAuthParam} variant="link"
                        >{isLoginPage ? 'Daftar' : 'Masuk'}</Button
                    >
                </Card.Footer>
            </Card.Root>
        </section>
    </main>
</AuthLayout>
