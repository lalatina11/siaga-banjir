<script lang="ts">
    import { Button, buttonVariants } from '$lib/components/ui/button';
    import * as Card from '$lib/components/ui/card';
    import * as Field from '$lib/components/ui/field';
    import ScrollArea from '$lib/components/ui/scroll-area/scroll-area.svelte';
    import { Textarea } from '$lib/components/ui/textarea';
    import AppHead from '@/components/AppHead.svelte';
    import { createForm } from '@tanstack/svelte-form';
    import { toast } from 'svelte-sonner';
    import z from 'zod';
    import { Input } from '../../ui/input';
    import ScrollAreaScrollbar from '../../ui/scroll-area/scroll-area-scrollbar.svelte';
    import { Spinner } from '../../ui/spinner';
    import LocationPicker from './location-picker.svelte';
    import { createQuery } from '@tanstack/svelte-query';
    import { router } from '@inertiajs/svelte';
    import { type VisitHelperOptions } from '@inertiajs/core';
    import { imageSchema } from '@/lib/validations/upload-image-validations';
    import { floodSchema } from '@/lib/validations/flood-validations';
    import { Checkbox } from '../../ui/checkbox';

    let lat = $state(-7.4244);
    let lng = $state(109.2303);
    let formError = $state('');
    let isLoading = $state(false);
    let image = $state<File | null>(null);
    let imagePreviewUrl = $derived(
        image !== null ? URL.createObjectURL(image) : '',
    );

    const form = createForm(() => ({
        validators: {
            onChange: floodSchema,
            onsubmit: floodSchema,
        },
        defaultValues: {
            description: '',
            province: '',
            regency: '',
            district: '',
            village: '',
            is_anon: false,
        },
        onSubmit: async ({ value }) => {
            const validations = imageSchema.safeParse(image);
            if (!validations.success) {
                toast.error('Error!', {
                    description: 'Ada field yang belum diisi dengan benar',
                });
                formError = validations.error.issues[0].message;
                return;
            }
            if (!validations.data) {
                toast.error('Error!', {
                    description: 'Ada field yang belum diisi dengan benar',
                });
                formError = 'Tolong masukkan gambar';
                return;
            }
            const data = {
                ...value,
                is_anon: value.is_anon ? 'true' : 'false',
                image: validations.data,
                lat,
                lng,
            };

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
                        description: 'Laporanmu akan ditinjau admin!',
                    });
                },
                onError: (error) => {
                    const description = error[0] || 'Coba lagi beberapa saat';
                    toast.error('Terjadi Kesalahan!', { description });
                    formError = description;
                },
            } satisfies VisitHelperOptions;
            router.post('/api/flood/create', data, requestOptions);
        },
    }));

    let formBusy = $derived(
        isLoading || form.useStore((state) => state.isSubmitting).current,
    );

    const revokeImage = () => (image = null);

    const _query = createQuery(() => ({
        queryKey: ['flood', lat, lng],
        queryFn: async () => {
            const res = await fetch(
                `${import.meta.env.VITE_PUBLIC_NOMINATIM_OPEN_STREET_MAP}?lat=${lat}&lon=${lng}&format=json&addressdetails=1`,
                {
                    headers: {
                        Accept: 'application/json',
                        'User-Agent': 'SiagaBanjir/1.0',
                        'Accept-Language': 'id',
                    },
                },
            );
            const result = await res.json();
            console.log({ result });

            form.setFieldValue('province', result.address.state || '');
            if (result.address.county) {
                form.setFieldValue('regency', result.address.county);
            }
            form.setFieldValue('village', result.address.village || '');

            return { success: true };
        },
    }));
</script>

<AppHead title="Buat Laporan" />

<Card.Root class="w-full">
    <Card.Header>
        <Card.Title>Laporkan Banjir</Card.Title>
        <Card.Description>Laporkan Banjir ke pihak berwenang</Card.Description>
        {#if formError}
            <Field.Error
                class="w-full text-center"
                errors={[{ message: formError }]}
            />
        {/if}
    </Card.Header>
    <Card.Content class="">
        <form
            class="w-full grid grid-cols-1 md:grid-cols-2"
            onsubmit={(e) => {
                e.preventDefault();
                e.stopPropagation();
                form.handleSubmit();
            }}
        >
            <LocationPicker bind:lat bind:lng />
            <Field.Group class="flex flex-col">
                <ScrollArea class="w-full h-[500px]">
                    <Field.Field class="flex-1 p-3">
                        <form.Field name="description">
                            {#snippet children(field)}
                                <Field.Set class="gap-1">
                                    <Field.Label
                                        class="capitalize"
                                        for={field.name}>keterangan</Field.Label
                                    >
                                    <Textarea
                                        id={field.name}
                                        name={field.name}
                                        autocomplete="off"
                                        value={field.state.value}
                                        oninput={(e) => {
                                            const { value } =
                                                e.target as HTMLInputElement;
                                            field.setValue(value);
                                        }}
                                        onblur={() => field.handleBlur()}
                                        aria-invalid={field.state.meta
                                            .isTouched &&
                                            !field.state.meta.isValid}
                                        placeholder="Sedang terjadi banjir di daerah saya!"
                                    ></Textarea>
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
                        <Field.Set class="gap-1">
                            <Field.Label>Gambar</Field.Label>
                            <input
                                id="flood-image"
                                type="file"
                                hidden
                                onchange={(e) => {
                                    const { files } =
                                        e.target as HTMLInputElement;
                                    if (files) {
                                        formError = '';
                                        image = files?.[0];
                                    }
                                }}
                            />
                            {#if imagePreviewUrl}
                                <div class="flex flex-col gap-2">
                                    <img
                                        src={imagePreviewUrl}
                                        alt="no img"
                                        class="flex-1 object-cover rounded-md"
                                    />
                                    <div class="grid grid-cols-2 gap-2">
                                        <Button
                                            type="button"
                                            onclick={revokeImage}
                                            variant="destructive">Hapus</Button
                                        >
                                        <label
                                            for="flood-image"
                                            class={buttonVariants()}
                                            >Ganti</label
                                        >
                                    </div>
                                </div>
                            {:else}
                                <label
                                    for="flood-image"
                                    class={'mx-auto w-fit' + buttonVariants()}
                                    >Tambahkan Gambar</label
                                >
                            {/if}
                        </Field.Set>
                        <form.Field name="province">
                            {#snippet children(field)}
                                <Field.Set class="gap-1">
                                    <Field.Label
                                        class="capitalize"
                                        for={field.name}>Provinsi</Field.Label
                                    >
                                    <Input
                                        id={field.name}
                                        name={field.name}
                                        autocomplete="off"
                                        value={field.state.value}
                                        oninput={(e) => {
                                            const { value } =
                                                e.target as HTMLInputElement;
                                            field.setValue(value);
                                        }}
                                        onblur={() => field.handleBlur()}
                                        aria-invalid={field.state.meta
                                            .isTouched &&
                                            !field.state.meta.isValid}
                                        placeholder="Jawa Tengah"
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
                        <form.Field name="regency">
                            {#snippet children(field)}
                                <Field.Set class="gap-1">
                                    <Field.Label
                                        class="capitalize"
                                        for={field.name}
                                        >Kabupaten/Kota</Field.Label
                                    >
                                    <Input
                                        id={field.name}
                                        name={field.name}
                                        autocomplete="off"
                                        value={field.state.value}
                                        oninput={(e) => {
                                            const { value } =
                                                e.target as HTMLInputElement;
                                            field.setValue(value);
                                        }}
                                        onblur={() => field.handleBlur()}
                                        aria-invalid={field.state.meta
                                            .isTouched &&
                                            !field.state.meta.isValid}
                                        placeholder="Banyumas"
                                        defaultValue="Banyumas"
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
                        <form.Field name="district">
                            {#snippet children(field)}
                                <Field.Set class="gap-1">
                                    <Field.Label
                                        class="capitalize"
                                        for={field.name}>Kecamatan</Field.Label
                                    >
                                    <Input
                                        id={field.name}
                                        name={field.name}
                                        autocomplete="off"
                                        value={field.state.value}
                                        oninput={(e) => {
                                            const { value } =
                                                e.target as HTMLInputElement;
                                            field.setValue(value);
                                        }}
                                        onblur={() => field.handleBlur()}
                                        aria-invalid={field.state.meta
                                            .isTouched &&
                                            !field.state.meta.isValid}
                                        placeholder="Wakanda"
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
                        <form.Field name="village">
                            {#snippet children(field)}
                                <Field.Set class="gap-1">
                                    <Field.Label
                                        class="capitalize"
                                        for={field.name}>Desa</Field.Label
                                    >
                                    <Input
                                        id={field.name}
                                        name={field.name}
                                        autocomplete="off"
                                        value={field.state.value}
                                        oninput={(e) => {
                                            const { value } =
                                                e.target as HTMLInputElement;
                                            field.setValue(value);
                                        }}
                                        onblur={() => field.handleBlur()}
                                        aria-invalid={field.state.meta
                                            .isTouched &&
                                            !field.state.meta.isValid}
                                        placeholder="Gotham"
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
                        <form.Field name="is_anon">
                            {#snippet children(field)}
                                <Field.Set class="gap-1">
                                    <div class="flex gap-2 items-center mt-3">
                                        <Checkbox
                                            id={field.name}
                                            name={field.name}
                                            onblur={() => field.handleBlur()}
                                            aria-invalid={field.state.meta
                                                .isTouched &&
                                                !field.state.meta.isValid}
                                            checked={field.state.value}
                                            onCheckedChange={(check) =>
                                                field.setValue(check)}
                                        />
                                        <Field.Label
                                            class="capitalize"
                                            for={field.name}
                                            >Posting sebagai anonymous</Field.Label
                                        >
                                    </div>
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
                    </Field.Field>
                    <ScrollAreaScrollbar orientation="vertical" />
                </ScrollArea>
                <Field.Set class="w-full">
                    <Button disabled={formBusy} size="lg" type="submit"
                        >{#if formBusy}
                            <Spinner />
                        {:else}
                            Laporkan Banjir
                        {/if}</Button
                    >
                </Field.Set>
            </Field.Group>
        </form>
    </Card.Content>
</Card.Root>
