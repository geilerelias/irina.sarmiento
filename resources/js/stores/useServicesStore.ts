import { defineStore } from 'pinia'

export const useServicesStore = defineStore('services', {
    state: () => ({
        services: [
            {
                id: 1,
                titulo: 'Educación y Formación Integral',
                icon: 'GraduationCap',
                descripcion:
                    'Procesos educativos orientados al desarrollo humano, la inclusión y el aprendizaje significativo.',
                detalle: [
                    'Diseño de proyectos pedagógicos institucionales (PEI)',
                    'Formación docente',
                    'Pedagogías inclusivas y contextualizadas',
                    'Educación con enfoque diferencial'
                ]
            },
            {
                id: 2,
                titulo: 'Etnoeducación e Interculturalidad',
                icon: 'Globe',
                descripcion:
                    'Acompañamiento educativo desde el reconocimiento de la diversidad cultural y los saberes propios.',
                detalle: [
                    'Propuestas etnoeducativas',
                    'Diseño curricular intercultural',
                    'Educación propia',
                    'Fortalecimiento de identidad cultural'
                ]
            },
            {
                id: 3,
                titulo: 'Psicología Social Comunitaria',
                icon: 'Users',
                descripcion:
                    'Intervención psicosocial orientada al bienestar colectivo y la transformación social.',
                detalle: [
                    'Diagnósticos comunitarios',
                    'Intervención psicosocial',
                    'Convivencia escolar',
                    'Prevención de conflictos'
                ]
            },
            {
                id: 4,
                titulo: 'Planeación y Gestión Educativa',
                icon: 'ClipboardList',
                descripcion:
                    'Acompañamiento estratégico para la organización y mejora institucional.',
                detalle: [
                    'Planeación educativa',
                    'Planes de mejoramiento',
                    'Gestión escolar',
                    'Evaluación institucional'
                ]
            },
            {
                id: 5,
                titulo: 'Investigación Educativa',
                icon: 'Search',
                descripcion:
                    'Investigación aplicada para fortalecer prácticas pedagógicas y sociales.',
                detalle: [
                    'Investigación educativa',
                    'Sistematización de experiencias',
                    'Proyectos investigativos',
                    'Informes académicos'
                ]
            },
            {
                id: 6,
                titulo: 'Orientación y Acompañamiento Educativo',
                icon: 'HeartHandshake',
                descripcion:
                    'Orientación humana, académica y psicoeducativa en contextos escolares.',
                detalle: [
                    'Orientación educativa',
                    'Acompañamiento familiar',
                    'Apoyo psicoeducativo',
                    'Habilidades para la vida'
                ]
            }
        ]
    })
})
