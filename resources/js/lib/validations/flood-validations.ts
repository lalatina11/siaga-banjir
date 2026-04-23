import z from 'zod';
import type { AllowedFloodFilter } from '../types';

export const allowedFloodStatus = [
    'PENDING',
    'NEW',
    'AID_DISPATCHED',
    'AID_ARRIVED',
    'RESOLVE',
] as const;

export const allowedFloodFilters = [
    'ALL',
    ...allowedFloodStatus,
] satisfies Array<AllowedFloodFilter>;

export const floodSchema = z.object({
    description: z.string(),
    province: z.string().min(3, 'Mohon isi nama provinsi minimal 3 karakter'),
    regency: z.string().min(3, 'Mohon isi nama kabupaten minimal 3 karakter'),
    district: z.string().min(3, 'Mohon isi nama kecamatan minimal 3 karakter'),
    village: z.string().min(3, 'Mohon isi nama desa minimal 3 karakter'),
    is_anon: z.boolean(),
});
