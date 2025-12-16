<template>
    <section id="estadisticas" class="relative bg-orinoco-primary/10 py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Encabezado -->
            <div class="mb-16 text-center">
                <h2
                    class="text-orinoco-darker mb-4 text-[clamp(2rem,4vw,2.75rem)] font-bold"
                >
                    Impacto y Trayectoria
                </h2>
                <p
                    class="text-orinoco-text-muted mx-auto max-w-3xl text-[clamp(1rem,2.5vw,1.15rem)] leading-relaxed"
                >
                    Una labor educativa sostenida en el tiempo, orientada al
                    fortalecimiento de comunidades, procesos pedagógicos y
                    contextos etnoeducativos desde una perspectiva humana, ética
                    y transformadora.
                </p>
            </div>

            <!-- Estadísticas -->
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <StatCard
                    v-for="stat in stats"
                    :key="stat.id"
                    :value="stat.value"
                    :label="stat.label"
                    :color="stat.color"
                />
            </div>

            <!-- Cierre reflexivo -->
            <div
                class="border-orinoco-border mx-auto mt-20 max-w-4xl rounded-3xl border bg-white px-8 py-10 text-center shadow-sm"
            >
                <p
                    class="text-orinoco-text text-[clamp(1rem,2.5vw,1.15rem)] leading-relaxed"
                >
                    La educación no se mide únicamente en cifras, sino en la
                    huella que deja en las personas, las comunidades y los
                    territorios. Cada proceso acompañado representa una
                    oportunidad de transformación social y cultural.
                </p>
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
import StatCard from '@/components/ui/StatCard.vue';
import { onMounted, ref } from 'vue';

interface Stat {
    id: number;
    value: string;
    label: string;
    color: string;
}

const stats = ref<Stat[]>([
    {
        id: 1,
        value: '20+',
        label: 'Años de experiencia en educación',
        color: 'from-orinoco-primary to-orinoco-accent',
    },
    {
        id: 2,
        value: '2000+',
        label: 'Estudiantes acompañados',
        color: 'from-orinoco-secondary to-orinoco-primary',
    },
    {
        id: 3,
        value: '15+',
        label: 'Procesos educativos y comunitarios',
        color: 'from-orinoco-bronze to-orinoco-accent',
    },
    {
        id: 4,
        value: '1',
        label: 'Vocación centrada en la educación con sentido humano',
        color: 'from-orinoco-dark to-orinoco-primary',
    },
]);

/* Animación suave y segura */
const animateNumbers = (): void => {
    stats.value.forEach((stat) => {
        const target = parseInt(stat.value);
        if (isNaN(target)) return;

        let current = 0;
        const increment = Math.max(1, Math.floor(target / 40));

        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                stat.value = target + '+';
                clearInterval(timer);
            } else {
                stat.value = current + '+';
            }
        }, 30);
    });
};

onMounted(() => {
    const section = document.querySelector('#estadisticas');
    if (!section) return;

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    animateNumbers();
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.3 },
    );

    observer.observe(section);
});
</script>
