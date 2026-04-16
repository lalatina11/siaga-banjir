import { Decimal } from 'decimal.js-light';
import { usePage } from '@inertiajs/svelte';

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
    status: string;
    updated_at: string;
    village: string;
}

export type PageProps = ReturnType<typeof usePage>['props'];

export type DecimalType = typeof Decimal;
