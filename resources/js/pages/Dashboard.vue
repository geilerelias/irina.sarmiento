<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

import { usePage } from '@inertiajs/vue3';
import {
    ArcElement,
    BarElement,
    CategoryScale,
    Chart as ChartJS,
    Legend,
    LinearScale,
    LineElement,
    PointElement,
    Tooltip,
} from 'chart.js';
import { User } from 'lucide-vue-next';
import { computed } from 'vue';
import { Bar, Line, Pie } from 'vue-chartjs';

ChartJS.register(
    ArcElement,
    BarElement,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Tooltip,
    Legend,
);

// 👉 Usuario logueado desde Inertia
const page = usePage();
const user = computed(() => page.props.auth.user);

// const stats2 = computed(() => page.props.stats);
// const monthly = computed(() => page.props.monthly);

// 👉 Estadísticas (ejemplo, luego puedes traerlas del backend)
const stats = {
    articles: 24,
    research: 12,
    thesis: 6,
    evaluations: 18,
    workshops: 9,
};

// 👉 Datos gráficos
const barData = {
    labels: [
        'Artículos',
        'Investigaciones',
        'Tesis',
        'Evaluaciones',
        'Talleres',
    ],
    datasets: [
        {
            label: 'Producción académica',
            data: Object.values(stats),
            backgroundColor: [
                '#8b6f47',
                '#a0826d',
                '#d4af37',
                '#7a9fb3',
                '#9b7653',
            ],
        },
    ],
};

const pieData = {
    labels: [
        'Artículos',
        'Investigaciones',
        'Tesis',
        'Evaluaciones',
        'Talleres',
    ],
    datasets: [
        {
            data: Object.values(stats),
            backgroundColor: [
                '#8b6f47',
                '#a0826d',
                '#d4af37',
                '#7a9fb3',
                '#9b7653',
            ],
        },
    ],
};

const lineData = {
    labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
    datasets: [
        {
            label: 'Documentos subidos',
            data: [2, 6, 9, 14, 20, 24],
            borderColor: '#8b6f47',
            backgroundColor: 'rgba(139, 111, 71, 0.2)',
            tension: 0.4,
        },
    ],
};

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            labels: {
                color: '#3d3d3d',
            },
        },
    },
};
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="space-y-8">
                <!-- =========================
                HEADER
            ========================== -->
                <div>
                    <h1 class="text-2xl font-semibold text-orinoco-dark">
                        Panel de control
                    </h1>
                    <p class="text-orinoco-gray">
                        Resumen general de la producción académica
                    </p>
                </div>

                <!--  <pre>{{ page.props }}</pre> -->

                <!-- =========================
                TARJETA USUARIO
            ========================== -->
                <div
                    class="flex items-center gap-4 rounded-xl border bg-orinoco-light p-6 shadow-sm"
                >
                    <div
                        class="flex h-14 w-14 items-center justify-center rounded-full bg-orinoco-primary text-white"
                    >
                        <User class="h-6 w-6" />
                    </div>

                    <div>
                        <p class="text-lg font-medium text-orinoco-dark">
                            {{ user.name }}
                        </p>
                        <p class="text-orinoco-gray text-sm">
                            {{ user.email }}
                        </p>
                    </div>
                </div>

                <!-- =========================
                KPIs
            ========================== -->
                <div class="grid grid-cols-2 gap-4 md:grid-cols-5">
                    <div
                        v-for="(value, key) in stats"
                        :key="key"
                        class="rounded-xl border bg-white p-4 text-center shadow-sm"
                    >
                        <p class="text-orinoco-gray text-sm capitalize">
                            {{ key }}
                        </p>
                        <p class="text-2xl font-semibold text-orinoco-primary">
                            {{ value }}
                        </p>
                    </div>
                </div>

                <!-- =========================
                GRÁFICOS
            ========================== -->
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                    <!-- Barras -->
                    <div class="h-80 rounded-xl border bg-white p-4 shadow-sm">
                        <h3 class="mb-2 font-medium text-orinoco-dark">
                            Producción por categoría
                        </h3>
                        <Bar :data="barData" :options="chartOptions" />
                    </div>

                    <!-- Pastel -->
                    <div class="h-80 rounded-xl border bg-white p-4 shadow-sm">
                        <h3 class="mb-2 font-medium text-orinoco-dark">
                            Distribución porcentual
                        </h3>
                        <Pie :data="pieData" :options="chartOptions" />
                    </div>

                    <!-- Línea -->
                    <div class="h-80 rounded-xl border bg-white p-4 shadow-sm">
                        <h3 class="mb-2 font-medium text-orinoco-dark">
                            Evolución mensual
                        </h3>
                        <Line :data="lineData" :options="chartOptions" />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
