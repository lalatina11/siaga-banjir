import z from 'zod';

export const registerSchema = z
    .object({
        name: z
            .string()
            .min(3, { message: 'Nama minimal 3 karakter' })
            .max(64, { message: 'Nama maksimal 64 karakter' }),
        email: z
            .email({ message: 'Email tidak valid' })
            .trim()
            .lowercase('Email harus menggunakan huruf kecil'),
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

export const loginSchema = z.object({
    email: z
        .email({ message: 'Email tidak valid' })
        .trim()
        .lowercase('Email harus menggunakan huruf kecil'),
    password: z
        .string()
        .min(8, { message: 'Password minimal 8 karakter' })
        .max(32, { message: 'Password maksimal 32 karakter' }),
});
