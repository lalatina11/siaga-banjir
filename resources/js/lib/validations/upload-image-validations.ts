import z from 'zod';

export const imageSchema = z
    .file()
    .refine((file) => file.type.startsWith('image'), 'Hanya bisa upload image')
    .refine((file) => file.size > 1, 'Gambar wajib diisi')
    .refine(
        (file) => file.size < 5_000_000,
        'Gambar tidak boleh lebih dari 5mb',
    )
    .optional();
