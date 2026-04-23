import { Decimal } from 'decimal.js-light';
import { usePage } from '@inertiajs/svelte';
import { allowedFloodStatus } from '../validations/flood-validations';
import type { User } from '@/types';

export type FloodStatus = (typeof allowedFloodStatus)[number];

export interface Flood {
    created_at: string;
    description: string;
    district: string;
    id: number;
    image: string;
    lat: number;
    lng: number;
    province: string;
    regency: string;
    status: FloodStatus;
    updated_at: string;
    village: string;
}

export interface FloodWithUser extends Flood {
    user?: User;
}

export type PageProps = ReturnType<typeof usePage>['props'] & {
    sidebar_state?: 'true' | 'false';
};

export type DefaultPageProps = PageProps;

export type DecimalType = typeof Decimal;

export type UploadedFile = File & {
    uploadedAt: number;
    url: Promise<string>;
};

export type AllowedFloodFilter = FloodStatus | 'ALL';
