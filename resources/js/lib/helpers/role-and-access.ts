import type { User as DefaultUser } from '../../types/auth';
interface User {
    id: string | number;
    role: DefaultUser['role'];
}
export const useRoleBasedPermission = () => {
    return {
        guest: (user?: User) => {
            if (!user) return true;
            return false;
        },
        user: (user: User) => {
            return user.role === 'USER';
        },
        admin: (user: User) => {
            return user.role === 'ADMIN';
        },
        adminOrAbove: (user: User) => {
            return user.role !== 'USER';
        },
        superadmin: (user: User) => {
            return user.role === 'SUPERADMIN';
        },
    };
};
