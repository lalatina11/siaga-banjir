import type { User } from '@/types';
import { HouseIcon, LayoutDashboard, User as UserIcon } from '@lucide/svelte';
import SettingsIcon from '@lucide/svelte/icons/settings';
const userItems = [
    {
        title: 'Beranda',
        url: '/',
        icon: HouseIcon,
    },
    {
        title: 'Dashboard',
        url: '/dashboard',
        icon: LayoutDashboard,
    },
    {
        title: 'Profile',
        url: '/dashboard/profile',
        icon: UserIcon,
    },
    {
        title: 'Settings',
        url: '/dashboard/setting',
        icon: SettingsIcon,
    },
];

const adminItems = [
    {
        title: 'Beranda',
        url: '/',
        icon: HouseIcon,
    },
    {
        title: 'Dashboard',
        url: '/dashboard/admin',
        icon: LayoutDashboard,
    },
    {
        title: 'Profile',
        url: '/dashboard/profile',
        icon: UserIcon,
    },
    {
        title: 'Settings',
        url: '/dashboard/setting',
        icon: SettingsIcon,
    },
];
const superAdminItems = [
    {
        title: 'Beranda',
        url: '/',
        icon: HouseIcon,
    },
    {
        title: 'Dashboard',
        url: '/dashboard/superadmin',
        icon: LayoutDashboard,
    },
    {
        title: 'Profile',
        url: '/dashboard/profile',
        icon: UserIcon,
    },
    {
        title: 'Settings',
        url: '/dashboard/setting',
        icon: SettingsIcon,
    },
];

export const useSidebarMenuItems = (role: User['role']) => {
    switch (role) {
        case 'SUPERADMIN':
            return superAdminItems;
        case 'ADMIN':
            return adminItems;
        default:
            return userItems;
    }
};
