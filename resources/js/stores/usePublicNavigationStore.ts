// src/stores/useNavigationStore.ts
import {
    Home,
    Mail,
    Newspaper,
    Settings,
    Briefcase,
    Shield,
    Users,
    GraduationCap,
    FileText,
    FlaskConical,
    FolderKanban,
    ClipboardCheck,
    Presentation,
} from 'lucide-vue-next';
import { defineStore } from 'pinia';

export const useNavigationStore = defineStore('navigation', {
    state: () => ({
        drawerOpen: false,
        links: [
            { title: 'Inicio', href: '/', name: 'home', icon: Home },
            { title: 'Acerca de', href: '/about', name: 'about', icon: Users },
            {
                href: "/academic-production",
                icon: GraduationCap,
                title: "Academia",
                children: [
                    {
                        href: "/academic-production/articles",
                        title: "Artículos científicos",
                        description: "Publicaciones académicas revisadas por pares que difunden resultados de investigación científica.",
                        icon: FileText,
                    },
                    {
                        href: "/academic-production/research",
                        title: "Investigaciones libres",
                        description: "Trabajos de investigación independientes orientados al análisis, la reflexión y la generación de conocimiento.",
                        icon: FlaskConical,
                    },
                    {
                        href: "/academic-production/thesis",
                        title: "Tesis doctoral",
                        description: "Producciones académicas de alto nivel que acreditan la obtención del grado de doctor mediante investigación original.",
                        icon: FolderKanban,
                    },
                    {
                        href: "/academic-production/evaluations",
                        title: "Evaluaciones",
                        description: "Instrumentos y procesos académicos destinados a la valoración del aprendizaje y el desempeño investigativo.",
                        icon: ClipboardCheck,
                    },
                    {
                        href: "/academic-production/workshops",
                        title: "Talleres",
                        description: "Espacios formativos prácticos orientados al fortalecimiento de competencias académicas y científicas.",
                        icon: Presentation,
                    },
                ]

            },

            {
                title: 'Contacto',
                href: '/contact',
                name: 'contact',
                icon: Mail,
            },
        ],
        admin: {
            title: 'Admin',
            href: '/dashboard',
            name: 'admin',
            icon: Shield,
        },
    }),

    actions: {
        toggleDrawer() {
            this.drawerOpen = !this.drawerOpen;
        },
        closeDrawer() {
            this.drawerOpen = false;
        },
        openDrawer() {
            this.drawerOpen = true;
        },
    },
});
