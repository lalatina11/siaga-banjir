<script lang="ts">
    import * as Dialog from '$lib/components/ui/dialog/index.js';
    import type { Flood } from '@/lib/types';
    import { PackagePlus, Plus, Trash2 } from '@lucide/svelte';
    import { createForm } from '@tanstack/svelte-form';
    import z from 'zod';
    import { Button } from '../../ui/button';
    import * as Field from '../../ui/field';
    import { Input } from '../../ui/input';
    import { ScrollArea } from '../../ui/scroll-area';
    import { Spinner } from '../../ui/spinner';
    import { router } from '@inertiajs/svelte';
    import { type VisitHelperOptions } from '@inertiajs/core';
    import { toast } from 'svelte-sonner';

    interface Props {
        floodId: Flood['id'];
    }

    const aidItemsSchema = z.object({
        name: z
            .string()
            .min(3, 'Nama item minimal 3 karakter.')
            .max(64, 'Nama item maksimal 64 karakter.'),
        price: z
            .number()
            .min(1000, 'Harga item minimal Rp 1.000.')
            .refine(
                (n) => n % 1000 === 0,
                'Harga item harus kelipatan Rp 1.000.',
            ),
    });

    const aidSchema = z.object({
        items: z.array(aidItemsSchema).min(1, 'Masukkan setidaknya 1 item'),
    });

    const { floodId }: Props = $props();
    let open = $state(false);
    const setOpen = (mode: 'open' | 'close' | 'switch' = 'switch') => {
        if (mode === 'switch') return (open = !open);
        if (mode === 'open') return (open = true);
        open = false;
    };

    let isLoading = $state(false);

    const form = createForm(() => ({
        validators: {
            onSubmit: aidSchema,
            onChange: aidSchema,
        },
        defaultValues: {
            items: [{ name: '', price: 0 }],
        },
        onSubmit: ({ value }) => {
            const data = { ...value, floodId };
            console.log({ data });

            const requestOptions = {
                onStart: () => {
                    isLoading = true;
                },
                onFinish: () => {
                    isLoading = false;
                },
                onSuccess: () => {
                    toast.success('Berhasil', {
                        description:
                            'Bantuanmu sedang dalam proses pengiriman!',
                    });
                    setOpen('close');
                },
                onError: (error) => {
                    const description = error[0] || 'Coba lagi beberapa saat';
                    toast.error('Terjadi Kesalahan!', { description });
                },
            } satisfies VisitHelperOptions;
            router.post(
                `/api/flood/send-aid/${floodId}`,
                value,
                requestOptions,
            );
        },
    }));
</script>

<Dialog.Root {open} onOpenChange={() => setOpen()}>
    <Button onclick={() => setOpen('open')} size="lg">
        <PackagePlus class="w-4 h-4 mr-2" />
        Kirim Bantuan
    </Button>
    <!-- max-h + flex-col agar header & footer fixed, hanya area item yang scroll -->
    <Dialog.Content
        class="w-full md:w-[520px] p-0 overflow-hidden gap-0 flex flex-col max-h-[90vh]"
    >
        <ScrollArea class="h-[70vh]">
            <!-- Header with subtle accent -->
            <div class="px-6 pt-6 pb-4 border-b border-border/50 shrink-0">
                <div class="flex items-center gap-3 mb-1">
                    <div
                        class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center"
                    >
                        <PackagePlus class="w-4 h-4 text-primary" />
                    </div>
                    <Dialog.Title class="text-lg font-semibold"
                        >Kirim Bantuan</Dialog.Title
                    >
                </div>
                <Dialog.Description class="text-sm text-muted-foreground ml-11">
                    Beri tahu semua orang kalau bencana ini akan segera dikirim
                    bantuan
                </Dialog.Description>
            </div>
            <form
                class="flex flex-col flex-1 justify-between"
                onsubmit={(e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    form.handleSubmit();
                }}
            >
                <div class="px-6 py-4 flex flex-col gap-3">
                    <form.Field name="items">
                        {#snippet children(field)}
                            <!-- Item rows -->
                            {#each field.state.value as item, i}
                                <div
                                    class="group relative rounded-xl border border-border/60 bg-muted/30 p-4 transition-colors hover:border-border hover:bg-muted/50"
                                >
                                    <!-- Row number badge -->
                                    <div
                                        class="flex items-center justify-between mb-3"
                                    >
                                        <span
                                            class="text-xs font-medium text-muted-foreground bg-background border border-border/50 rounded-md px-2 py-0.5"
                                        >
                                            Item #{i + 1}
                                        </span>

                                        <!-- Delete button — hanya tampil kalau item > 1 -->
                                        {#if field.state.value.length > 1}
                                            <button
                                                type="button"
                                                onclick={() =>
                                                    field.removeValue(i)}
                                                class="opacity-0 group-hover:opacity-100 transition-opacity w-7 h-7 rounded-md flex items-center justify-center text-muted-foreground hover:text-destructive hover:bg-destructive/10"
                                            >
                                                <Trash2 class="w-3.5 h-3.5" />
                                            </button>
                                        {/if}
                                    </div>

                                    <!-- Fields in a 2-column grid -->
                                    <div class="grid grid-cols-2 gap-3">
                                        <form.Field name={`items[${i}].name`}>
                                            {#snippet children(subField)}
                                                <Field.Set>
                                                    <Field.Label
                                                        class="text-xs font-medium text-muted-foreground mb-1.5"
                                                    >
                                                        Nama Item
                                                    </Field.Label>
                                                    <Input
                                                        value={item.name}
                                                        placeholder="Mis. Beras, Mie..."
                                                        class="h-9 text-sm"
                                                        oninput={(e: Event) => {
                                                            const target =
                                                                e.target as HTMLInputElement;
                                                            subField.handleChange(
                                                                target.value,
                                                            );
                                                        }}
                                                    />
                                                    {#if subField.state.meta.errors[0]}
                                                        <Field.Error
                                                            errors={[
                                                                subField.state
                                                                    .meta
                                                                    .errors[0],
                                                            ]}
                                                        />
                                                    {/if}
                                                </Field.Set>
                                            {/snippet}
                                        </form.Field>

                                        <form.Field name={`items[${i}].price`}>
                                            {#snippet children(subField)}
                                                <Field.Set>
                                                    <Field.Label
                                                        class="text-xs font-medium text-muted-foreground mb-1.5"
                                                    >
                                                        Harga (Rp)
                                                    </Field.Label>
                                                    <div class="relative">
                                                        <span
                                                            class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-muted-foreground font-medium pointer-events-none"
                                                        >
                                                            Rp
                                                        </span>
                                                        <Input
                                                            value={item.price ||
                                                                ''}
                                                            placeholder="10.000"
                                                            type="number"
                                                            class="h-9 text-sm pl-9"
                                                            oninput={(
                                                                e: Event,
                                                            ) => {
                                                                const target =
                                                                    e.target as HTMLInputElement;
                                                                subField.handleChange(
                                                                    Number(
                                                                        target.value,
                                                                    ),
                                                                );
                                                            }}
                                                        />
                                                    </div>
                                                    {#if subField.state.meta.errors[0]}
                                                        <Field.Error
                                                            errors={[
                                                                subField.state
                                                                    .meta
                                                                    .errors[0],
                                                            ]}
                                                        />
                                                    {/if}
                                                </Field.Set>
                                            {/snippet}
                                        </form.Field>
                                    </div>
                                </div>
                            {/each}

                            <!-- Array-level error -->
                            {#if field.state.meta.errors[0]}
                                <Field.Error
                                    errors={[field.state.meta.errors[0]]}
                                />
                            {/if}

                            <!-- Add item button -->
                            <button
                                onclick={() =>
                                    field.pushValue({ name: '', price: 0 })}
                                type="button"
                                class="w-full h-10 rounded-xl border border-dashed border-border/70 text-sm text-muted-foreground flex items-center justify-center gap-2 transition-colors hover:border-primary/50 hover:text-primary hover:bg-primary/5"
                            >
                                <Plus class="w-4 h-4" />
                                Tambah Item
                            </button>
                        {/snippet}
                    </form.Field>
                </div>

                <div
                    class="px-6 py-4 border-t border-border/50 flex items-center justify-between gap-3 bg-muted/20 shrink-0 mt-14"
                >
                    <p class="text-xs text-muted-foreground">
                        <form.Subscribe selector={(s) => s.values.items.length}>
                            {#snippet children(count)}
                                {count} item ditambahkan
                            {/snippet}
                        </form.Subscribe>
                    </p>
                    <div class="flex gap-2">
                        <Button
                            variant="outline"
                            size="sm"
                            type="button"
                            onclick={() => setOpen('close')}
                        >
                            Batal
                        </Button>
                        <Button
                            disabled={isLoading}
                            variant="default"
                            size="sm"
                            type="submit"
                            class="min-w-[110px]"
                        >
                            {#if isLoading}
                                <Spinner class="w-4 h-4 mr-2" />
                                Mengirim...
                            {:else}
                                <PackagePlus class="w-4 h-4 mr-2" />
                                Kirim Bantuan
                            {/if}
                        </Button>
                    </div>
                </div>
            </form>
        </ScrollArea>
    </Dialog.Content>
</Dialog.Root>
