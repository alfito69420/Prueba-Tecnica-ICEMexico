import type { PageProps } from '@inertiajs/core';
import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export interface SharedData extends PageProps {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export type BreadcrumbItemType = BreadcrumbItem;

// export interface Certificate {
//     id: number;
//     name: string;
//     description: string;
//     pivot?: {
//         user_id: number;
//         status: 'not evaluated' | 'evaluated' | 'canceled';
//         enrolled_at: string | null;
//     };
// }

export interface Certificate {
    id: number;
    name: string;
    description: string;
    users: {
        id: number;
        name: string;
        email: string;
        pivot: {
            status: 'not evaluated' | 'evaluated' | 'canceled';
            enrolled_at: string | null;
        };
    }[];
}