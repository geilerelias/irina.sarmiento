import { InertiaLinkProps } from '@inertiajs/vue3';
import type { LucideIcon } from 'lucide-vue-next';
import { route as ziggyRoute } from 'ziggy-js'

declare global {
    const route: typeof ziggyRoute
}
export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: NonNullable<InertiaLinkProps['href']>;
    icon?: LucideIcon;
    isActive?: boolean;
    children?: NavItem[];
}

export type AppPageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    sidebarOpen: boolean;
};

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export const AcademicCategories = {
    ARTICLES: 'articles',
    RESEARCH: 'research',
    THESIS: 'thesis',
    EVALUATIONS: 'evaluations',
    WORKSHOPS: 'workshops',
} as const

export type AcademicCategory =
    | 'articles'
    | 'research'
    | 'thesis'
    | 'evaluations'
    | 'workshops'

export interface AcademicDocument {
    id?: number

    /** Metadata principal */
    title?: string
    description?: string | null

    /** Categoría académica */
    category?: AcademicCategory

    /** Archivos */
    pdf_path?: string | null
    cover_image?: string | null

    /** Información académica */
    authors?: string | null
    institution?: string | null
    publication_date?: string | null

    /** Estado */
    is_published: boolean

    /** Auditoría */
    created_at?: string
    updated_at?: string
}


export type BreadcrumbItemType = BreadcrumbItem;
