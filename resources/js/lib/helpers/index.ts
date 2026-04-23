import type { User } from '@/types';
import type { AllowedFloodFilter, FloodStatus } from '../types';

export const capitalizeFirstLetter = (text: string) => {
    if (text.length < 2) return text;
    return (
        text.charAt(0).toUpperCase() + text.slice(1, text.length).toLowerCase()
    );
};

export const roleToIndonesianLang = (role: User['role']) => {
    switch (role) {
        case 'SUPERADMIN':
            return 'Superadmin';
        case 'ADMIN':
            return 'Admin';
        default:
            return 'Pengguna';
    }
};

export const floodFilterCapitalize = (filter: AllowedFloodFilter) => {
    switch (filter) {
        case 'NEW':
            return 'Baru';
        case 'AID_DISPATCHED':
            return 'Sedang Dikirim Bantuan';
        case 'AID_ARRIVED':
            return 'Telah Dikirim Bantuan';
        case 'RESOLVE':
            return 'Selesai';
        case 'PENDING':
            return 'Menunggu Persetujuan Admin';
        default:
            return 'Semua';
    }
};
export const floodStatusCapitalize = (filter: FloodStatus) => {
    switch (filter) {
        case 'NEW':
            return 'Baru';
        case 'AID_DISPATCHED':
            return 'Sedang Dikirim Bantuan';
        case 'AID_ARRIVED':
            return 'Telah Dikirim Bantuan';
        case 'RESOLVE':
            return 'Selesai';
        case 'PENDING':
            return 'Menunggu Persetujuan Admin';
    }
};
