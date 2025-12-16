import { dashboard,contact } from '@/routes'
import adminAcademicProduction  from '@/routes/admin/academic-production'

import type { NavItem } from '@/types'
import {
    LayoutGrid,
    GraduationCap,
    FileText,
    FlaskConical,
    FolderKanban,
    ClipboardCheck,
    Presentation,
    BookOpen,
    Users,
    BarChart3,
    Bell,
    LifeBuoy,
    Settings,
} from 'lucide-vue-next'
import { defineStore } from 'pinia'

export const useAdminNavigationStore = defineStore('adminNavigation', {
    state: () => ({
        mainNavItems: [

            {
                title: 'Dashboard',
                href: dashboard(),
                icon: LayoutGrid,
            },

            {
                title: 'Prod. Académica',
                icon: GraduationCap,
                children: [
                    {
                        title: 'Artículos científicos',
                        href: adminAcademicProduction.index({
                            category: 'articles',
                        }),
                        icon: FileText,
                    },
                    {
                        title: 'Investigaciones',
                        href: adminAcademicProduction.index({
                            category: 'research',
                        }),
                        icon: FlaskConical,
                    },
                    {
                        title: 'Tesis doctoral',
                        href: adminAcademicProduction.index({
                            category: 'thesis',
                        }),
                        icon: GraduationCap,
                    },
                    {
                        title: 'Evaluaciones',
                        href: adminAcademicProduction.index({
                            category: 'evaluations',
                        }),
                        icon: ClipboardCheck,
                    },
                    {
                        title: 'Talleres',
                        href: adminAcademicProduction.index({
                            category: 'workshops',
                        }),
                        icon: Presentation,
                    },
                ],
            },  

            {
                title: 'Indicadores',
                icon: BarChart3,
                children: [
                    {
                        title: 'Métricas académicas',
                        href: '/admin/analytics/metrics',
                        icon: BarChart3,
                    },
                    {
                        title: 'Impacto investigativo',
                        href: '/admin/analytics/impact',
                        icon: FileText,
                    },
                ],
            },

        ] as NavItem[],
    }),

    getters: {
        getMainNavItems: (state): NavItem[] => state.mainNavItems,
    },
})
