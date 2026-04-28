<script lang="ts">
    import { ModeWatcher } from 'mode-watcher';
    import QueryClientProvider from '@/lib/components/providers/query-client-provider.svelte';
    import { Toaster } from '@/lib/components/ui/sonner';
    import type { ParentProps } from '@/lib/types/parent-props';
    type Props = ParentProps;
    const { children }: Props = $props();
</script>

<ModeWatcher />
<Toaster position="top-center" />
<QueryClientProvider>
    {@render children()}
</QueryClientProvider>

<footer class="mt-auto border-t border-border bg-background text-foreground">
    <div class="container mx-auto px-4 md:px-8 py-8 md:py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="md:col-span-2 space-y-4">
                <div class="flex items-center gap-2">
                    <img
                        class="h-8 w-auto inline dark:hidden"
                        src="/logo.png"
                        alt="Siaga Banjir Logo"
                    />
                    <img
                        class="h-8 w-auto hidden dark:inline"
                        src="/logo-dark.png"
                        alt="Siaga Banjir Logo"
                    />
                    <span class="text-xl font-bold">Siaga Banjir</span>
                </div>
                <p class="text-sm text-muted-foreground max-w-sm">
                    Platform informasi dan pelaporan bencana banjir terpadu
                    untuk membantu masyarakat lebih tanggap dan siaga terhadap
                    bencana.
                </p>
            </div>
            <div class="space-y-4">
                <h4 class="font-semibold">Tautan Cepat</h4>
                <ul class="space-y-2 text-sm text-muted-foreground">
                    <li>
                        <a href="/" class="hover:text-primary transition-colors"
                            >Beranda</a
                        >
                    </li>
                    <li>
                        <a
                            href="/peta"
                            class="hover:text-primary transition-colors"
                            >Peta Banjir</a
                        >
                    </li>
                    <li>
                        <a
                            href="/donasi"
                            class="hover:text-primary transition-colors"
                            >Bantuan</a
                        >
                    </li>
                </ul>
            </div>
            <div class="space-y-4">
                <h4 class="font-semibold">Bantuan & Legal</h4>
                <ul class="space-y-2 text-sm text-muted-foreground">
                    <li>
                        <a
                            href="/kontak"
                            class="hover:text-primary transition-colors"
                            >Hubungi Kami</a
                        >
                    </li>
                    <li>
                        <a
                            href="/privasi"
                            class="hover:text-primary transition-colors"
                            >Kebijakan Privasi</a
                        >
                    </li>
                    <li>
                        <a
                            href="/syarat"
                            class="hover:text-primary transition-colors"
                            >Syarat & Ketentuan</a
                        >
                    </li>
                </ul>
            </div>
        </div>
        <div
            class="mt-8 pt-8 border-t border-border flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-muted-foreground"
        >
            <p>
                &copy; {new Date().getFullYear()} Siaga Banjir. All rights reserved.
            </p>
            <div class="flex flex-col md:items-end text-center md:text-right">
                <p class="font-medium text-foreground">
                    Kelompok 1 — Web Programming III
                </p>
                <p class="text-xs opacity-70">
                    Ires, Hadzasy, Candra, Syaiful Aqmal, Farin
                </p>
            </div>
        </div>
    </div>
</footer>
