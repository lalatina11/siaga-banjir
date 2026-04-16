export type User = {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    role: 'USER' | 'ADMIN' | 'SUPERADMIN';
    [key: string]: unknown;
};

export type Auth = {
    user: User;
};
