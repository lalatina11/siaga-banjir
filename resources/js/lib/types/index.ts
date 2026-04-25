import { Decimal } from 'decimal.js-light';
import { usePage } from '@inertiajs/svelte';
import { allowedFloodStatus } from '../validations/flood-validations';
import type { User } from '@/types';

export type FloodStatus = (typeof allowedFloodStatus)[number];
export interface TimeStamps {
    created_at: string;
    updated_at: string;
}

export interface TimeStampsAndId extends TimeStamps {
    id: number | string;
}
export interface Flood extends TimeStampsAndId {
    description: string;
    district: string;
    image: string;
    lat: number;
    lng: number;
    province: string;
    regency: string;
    status: FloodStatus;
    village: string;
    user?: User;
}

export interface FloodAidItems extends TimeStampsAndId {
    name: string;
    flood_aid_id: number;
    price: number;
}

export interface FloodAid extends TimeStampsAndId {
    status: 'ON_DELIEVERY' | 'ARRIVED';
    flood_id: number;
    flood_aid_items: Array<FloodAidItems>;
}

export interface FloodAndAid extends Flood {
    flood_aid?: FloodAid;
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
